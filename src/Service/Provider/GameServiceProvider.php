<?php

namespace Convertize\Bees\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Convertize\Bees\Service\GameService;

/**
 * Bees game service integration for Silex.
 *
 * @package Convertize\Bees\Service\Provider
 */
class GameServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['game.settings'] = [];

        // inject the GameService
        $app['game'] = $app->share(function ($app) {
            return new GameService($app['game.settings']);
        });

    }

    public function boot(Application $app)
    {
    }
}
