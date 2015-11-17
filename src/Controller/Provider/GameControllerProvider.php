<?php

namespace Convertize\Bees\Controller\Provider;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Convertize\Bees\Controller\GameController;

/**
 * Class GameControllerProvider
 * @package Convertize\Bees\Controller\Provider
 */
class GameControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function connect(Application $app)
    {
        $gameController = new GameController($app);

        /** @var ControllerCollection $controllerCollection */
        $controllerCollection = $app["controllers_factory"];

        // basic sub-routing with route names
        $controllerCollection
            ->get("/", [$gameController, 'home'])
            ->bind('home');
        $controllerCollection
            ->get("/hit", [$gameController, 'hit'])
            ->bind('hit');

        // set layout
        $app->before(function () use ($app) {
            $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.html.twig'));
        });

        return $controllerCollection;
    }
} 