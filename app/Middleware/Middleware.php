<?php

namespace App\Middleware;

use Slim\Container;

class Middleware
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Middleware constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}