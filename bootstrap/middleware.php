<?php

use App\Middleware\CsrfViewMiddleware;

/**
 * Add middleware to the application
 */
$app->add(new CsrfViewMiddleware($container));
// $app->add($container->csrf);