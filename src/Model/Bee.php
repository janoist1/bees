<?php

namespace Convertize\Bees\Model;

/**
 * Class Bee - reprezentation of a bee
 * @package Convertize\Bees\Model
 */
class Bee
{
    // types of bees - could be int values but it's better read for the config
    const TYPE_QUEEN = 'queen';
    const TYPE_WORKER = 'worker';
    const TYPE_DRONE = 'drone';

    /** @var int */
    private $type;

    /** @var int */
    private $life;

    /**
     * @param $type
     * @param $life
     */
    function __construct($type, $life)
    {
        $this->type = $type;
        $this->life = $life;
    }

    /**
     * @return int
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @param int $life
     */
    public function setLife($life)
    {
        $this->life = $life;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
