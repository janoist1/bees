<?php

namespace Convertize\Bees\Model;


/**
 * Class GameData
 * @package Convertize\Bees\Model
 */
class GameData
{
    /** @var Bee[] */
    private $bees;

    /**
     * @param Bee[] $bees
     */
    function __construct(array $bees = [])
    {
        $this->bees = $bees;
    }

    /**
     * @return Bee[]
     */
    public function getBees()
    {
        return $this->bees;
    }

    /**
     * @param Bee[] $bees
     */
    public function setBees(array $bees)
    {
        $this->bees = $bees;
    }
}
