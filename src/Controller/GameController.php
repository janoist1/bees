<?php

namespace Convertize\Bees\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Convertize\Bees\Exception\GameException;
use Convertize\Bees\Service\GameService;

/**
 * Class GameController
 * @package Convertize\Bees\Controller
 */
class GameController
{
    /** @var Application */
    private $app;

    /**
     * @param Application $app
     */
    function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Display home view
     *
     * @return string
     */
    public function home()
    {
        // load game session
        $this->loadGameSession();

        // get messages if there are any
        $message = implode(', ', $this->getFlashBag()->get('message', []));

        return $this->getTwig()->render('game/home.html.twig', [
            'message' => $message
        ]);
    }

    /**
     * Handle hit request then redirect to home
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hit()
    {
        // load game session
        $this->loadGameSession();

        $gameOver = $this->getGame()->hit();

        if ($gameOver) {
            $this->resetGame();
            $message = 'game over';

        } else {
            $message = 'keep hitting poor bees';
        }

        // store a message to display it next time
        $this->getFlashBag()->add('message', $message);

        // update session
        $this->updateGameSession();

        // redirect to home page
        return $this->app->redirect($this->getUrlGenerator()->generate('home'));
    }

    /**
     * load game status from session
     */
    private function loadGameSession()
    {
        $gameData = $this->getSession()->get('gameData', null);
        $this->getGame()->initialize($gameData);
    }

    /**
     * load game status from session
     */
    private function updateGameSession()
    {
        $this->getSession()->set('gameData', $this->getGame()->getGameData());
    }

    /**
     * restart game
     */
    private function resetGame()
    {
        $this->getGame()->restart();
        $this->getSession()->remove('gameData');
    }

    /**
     * @return UrlGenerator
     */
    private function getUrlGenerator()
    {
        return $this->app['url_generator'];
    }

    /**
     * @return Session
     */
    private function getSession()
    {
        return $this->app['session'];
    }

    /**
     * Shortcut to the Session's FlashBag
     *
     * @return \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
     */
    private function getFlashBag()
    {
        return $this->getSession()->getFlashBag();
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwig()
    {
        return $this->app['twig'];
    }

    /**
     * @return GameService
     */
    private function getGame()
    {
        return $this->app['game'];
    }
}
