<?php

namespace DHolmes\InnovataSTK\Model;

class Departure
{
    /** @var Station */
    private $station;
    /** @var int */
    private $time;
    /** @var string */
    private $terminal;
    
    /**
     *
     * @param Station $station
     * @param int $time
     * @param string $terminal 
     */
    public function __construct(Station $station, $time, $terminal)
    {
        $this->time = $time;
        $this->station = $station;
        $this->terminal = $terminal;
    }

    /**
     *
     * @return Station
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     *
     * @return string
     */
    public function getTerminal()
    {
        return $this->terminal;
    }
}