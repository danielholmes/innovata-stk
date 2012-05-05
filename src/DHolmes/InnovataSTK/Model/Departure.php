<?php

namespace DHolmes\InnovataSTK\Model;

class Departure
{
    /** @var Station */
    private $station;
    /** @var int */
    private $minutesSinceMidnight;
    /** @var string */
    private $terminal;
    
    /**
     * @param Station $station
     * @param int $minutesSinceMidnight
     * @param string $terminal 
     */
    public function __construct(Station $station, $minutesSinceMidnight, $terminal)
    {
        $this->minutesSinceMidnight = $minutesSinceMidnight;
        $this->station = $station;
        $this->terminal = $terminal;
    }

    /** @return Station */
    public function getStation()
    {
        return $this->station;
    }

    /** @return int */
    public function getMinutesSinceMidnight()
    {
        return $this->minutesSinceMidnight;
    }

    /** @return string */
    public function getTerminal()
    {
        return $this->terminal;
    }
}