<?php

namespace Convertize\Bees;

use Silex\Application;

/**
 * Class Bees
 * @package Convertize\Bees
 */
class Bees extends Application
{
    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->loadProviders();
        $this->loadRoutes();
    }

    /**
     * Tie components to the app - dep. inj.
     */
    private function loadProviders()
    {
        $providers = $this->load('providers');

        foreach ($providers as $provider) {
            $this->register($provider[0], $provider[1]);
        }
    }

    /**
     * Map routes to controllers
     */
    private function loadRoutes()
    {
        $routes = $this->load('routes');

        foreach ($routes as $prefix => $controller) {
            $this->mount($prefix, $controller);
        }
    }

    /**
     * Load a configuration file from the app folder
     *
     * @param string $config
     * @return mixed
     */
    private function load($config)
    {
        return require __DIR__ . "/../config/" . $config . ".php";
    }
}
