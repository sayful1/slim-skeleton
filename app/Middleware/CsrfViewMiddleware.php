<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * CsrfViewMiddleware
 */
class CsrfViewMiddleware extends Middleware
{
    /**
     * CSRF view middleware closure
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->container->view->getEnvironment()->addGlobal('csrf_field',
            '<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '">
			<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">'
        );

        $response = $next($request, $response);

        return $response;
    }
}