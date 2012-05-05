<?php

namespace DHolmes\InnovataSTK\Model;

use DateTime;

class Departure
{
    /** @var Station */
    private $station;
    /** @var DateTime */
    private $date;
    /** @var string */
    private $terminal;
    
    /**
     * @param Station $station
     * @param DateTime $date
     * @param string $terminal 
     */
    public function __construct(Station $station, DateTime $date, $terminal)
    {
        $this->date = $date;
        $this->station = $station;
        $this->terminal = $terminal;
    }

    /** @return Station */
    public function getStation()
    {
        return $this->station;
    }

    /** @return DateTime */
    public function getDate()
    {
        return $this->date;
    }

    /** @return string */
    public function getTerminal()
    {
        return $this->terminal;
    }
}