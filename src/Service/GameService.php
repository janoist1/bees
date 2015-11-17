<?php

namespace Convertize\Bees\Service;

use Convertize\Bees\Exception\GameException;
use Convertize\Bees\Model\Bee;
use Convertize\Bees\Model\GameData;

/**
 * Class GameService - game logic
 * @package Convertize\Bees\Service
 */
class GameService
{
    const ERROR_SETTINGS = 'Missing or wrong setting for "%s"';

    /** @var array - game settings */
    private $settings;

    /** @var GameData */
    private $gameData;

    /**
     * @param array $settings
     */
    function __construct(array $settings)
    {
        $this->settings = $settings; // this could go to a Setting model - new Setting::fromArray(array) .. ?
        $this->gameData = new GameData();

        $this->validateSettings();
    }

    /**
     * Initialize the game
     *
     * @param GameData $gameData - load the game data
     */
    public function initialize(GameData $gameData = null)
    {
        if ($gameData === null) {
            // set up the hive
            $this->populateBees();
        } else {
            // load back the game data
            $this->gameData = $gameData;
        }
    }

    /**
     * Restart the game by resetting game data
     */
    public function restart()
    {
        $this->gameData = new GameData();

        $this->initialize();
    }

    /**
     * Hit a bee and return true if game over
     *
     * @return bool
     * @throws GameException
     */
    public function hit()
    {
        $bees = $this->gameData->getBees();
        $randomKey = array_rand($bees, 1);
        $bee = $bees[$randomKey];

        // reduce life
        $bee->setLife(max(0, $bee->getLife() - $this->settings['hit'][$bee->getType()]));

        // if queen is dead - game over
        if ($bee->getType() == Bee::TYPE_QUEEN && $bee->getLife() <= 0) {
            return true;
        }

        // remove dead bee
        if ($bee->getLife() < 1) {
            unset($bees[$randomKey]);
        }

        // there are no bees left :(
        if (count($bees) < 1) {
            return true;
        }

        $this->gameData->setBees(array_values($bees));

        return false;
    }

    /**
     * Add bees to the hive
     */
    private function populateBees()
    {
        $types = [
            Bee::TYPE_QUEEN,
            Bee::TYPE_WORKER,
            Bee::TYPE_DRONE,
        ];
        $bees = [];

        foreach ($types as $type) {
            for ($i = 0; $i < $this->settings['bees'][$type]; $i++) {
               $bees[] = new Bee($type, $this->settings['lifespan'][$type]);
            }
        }

        $this->getGameData()->setBees($bees);
    }

    /**
     * It allows us to get the game data in order to store it and load it back later
     * (ex. store it in a session)
     *
     * @return GameData
     */
    public function getGameData()
    {
        return $this->gameData;
    }

    /**
     * Very basic validation for the settings
     *
     * @throws GameException
     */
    private function validateSettings()
    {
        if (!array_key_exists('lifespan', $this->settings)
            || !is_array($this->settings['lifespan'])
        ) {
            throw new GameException(sprintf(self::ERROR_SETTINGS, 'lifespan'));
        }

        if (!array_key_exists('hit', $this->settings)
            || !is_array($this->settings['hit'])
        ) {
            throw new GameException(sprintf(self::ERROR_SETTINGS, 'hit'));
        }

        if (!array_key_exists('bees', $this->settings)
            || !is_array($this->settings['bees'])
        ) {
            throw new GameException(sprintf(self::ERROR_SETTINGS, 'bees'));
        }
    }
}
