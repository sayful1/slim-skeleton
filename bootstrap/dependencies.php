<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Container;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/** @var Container $container */
$container = $app->getContainer();

/**
 * Get site configurations
 *
 * @return \Noodlehaus\Config
 */
$container['config'] = function () use ($config) {
    return $config;
};

/**
 * Monolog
 *
 * @param Container $container
 *
 * @return Logger
 */
$container['logger'] = function (Container $container) {
    $config = $container->get('config');
    $logger = new Logger($config->get('logger.name'));
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler(
        $config->get('logger.path'),
        $config->get('logger.level')
    ));

    return $logger;
};

/**
 * Set up Illuminate Database
 */
$capsule = new Capsule();
$capsule->addConnection($container->get('config')->get('database.mysql'));
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function () use ($capsule) {
    return $capsule;
};


$container['flash'] = function () {
    return new Messages();
};

$container['csrf'] = function () {
    return new Guard;
};

/**
 * Add Twig view to container
 *
 * @param Container $container
 *
 * @return Twig
 */
$container['view'] = function (Container $container) {
    $config = $container->get('config');

    $view = new Twig(
        $config->get('twig.path'), [
        'cache' => $config->get('twig.cache')
    ]);

    $view->addExtension(new TwigExtension(
        $container->get('router'),
        $container->get('request')->getUri()
    ));

    $view->getEnvironment()->addGlobal('flash', $container->get('flash'));

    $view->getEnvironment()->addGlobal('csrf', [
        'name'  => $container->get('csrf')->getTokenName(),
        'value' => $container->get('csrf')->getTokenValue(),
    ]);

    return $view;
};

//Override the default Error Handler
$container['errorHandler'] = function (Container $container) {
    /**
     * @param Request $request
     * @param Response $response
     * @param Exception $exception
     *
     * @return string
     */
    return function (Request $request, Response $response, \Exception $exception) use ($container) {
        $container['logger']->critical("{$exception->getCode()} Error!", [
            'File'      => $exception->getFile(),
            'Line'      => $exception->getLine(),
            'ErrorCode' => $exception->getCode(),
            'Message'   => $exception->getMessage(),
        ]);

        if (0 === strpos($request->getUri()->getPath(), '/api', 0)) {
            $code    = 500;
            $message = 'There was an error';

            if ($exception !== null) {
                $code    = $exception->getCode();
                $message = $exception->getMessage();
            }

            // If it's not a valid HTTP status code, replace it with a 500
            if ( ! is_integer($code) || $code < 100 || $code > 599) {
                $code = 500;
            }

            return $response
                ->withStatus($code)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    'success' => false,
                    'code'    => $code,
                    'message' => $message,
                ]));
        }

        return $container->get('view')->render($response, 'errors/error.twig');
    };
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function (Container $container) {
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return mixed
     */
    return function (Request $request, Response $response) use ($container) {
        $container['logger']->info("404 Page Not Found!", [
            'ErrorCode' => 404,
            'Message'   => 'Page Not Found',
        ]);

        if (0 === strpos($request->getUri()->getPath(), '/api', 0)) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    'success' => false,
                    'code'    => 404,
                    'message' => 'Resource not valid',
                ]));
        }

        return $container['view']->render($response, 'errors/404.twig');
    };
};

//Override the default Not Allowed Handler
$container['notAllowedHandler'] = function (Container $container) {
    /**
     * @param Request $request
     * @param Response $response
     * @param array $methods
     *
     * @return mixed
     */
    return function (Request $request, Response $response, array $methods) use ($container) {
        $container['logger']->error("405 Method Not Allowed!", [
            'ErrorCode'      => 405,
            'Message'        => 'Method Not Allowed',
            'AllowedMethods' => implode(', ', $methods)
        ]);

        if (0 === strpos($request->getUri()->getPath(), '/api', 0)) {
            return $response
                ->withStatus(405)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode([
                    'success' => false,
                    'code'    => 405,
                    'message' => 'Method Not Allowed',
                ]));
        }

        return $container['view']->render($response, 'errors/405.twig');
    };
};