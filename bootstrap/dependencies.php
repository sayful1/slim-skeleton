<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Container;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
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