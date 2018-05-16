<?php

namespace App\Controllers;

use Slim\Container;

class BaseController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * BaseController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }

        return $this->{$property};
    }
}