<?php

namespace DHolmes\InnovataSTK\Model;

class Flight
{
    /** @var string */
    private $dayIndicator;
    /** @var array */
    private $stops;
    /** @var int */
    private $elapsedTime;
    /** @var int */
    private $flightMiles;
    /** @var string */
    // TODO: Convert to richer data type. e.g. raw MTW**S*
    private $frequency;
    /** @var array */
    private $legs;
    
    /**
     * @param string $dayIndicator
     * @param array $stops
     * @param int $elapsedTime
     * @param int $flightMiles
     * @param string $frequency 
     * @param array $legs
     */
    public function __construct($dayIndicator, array $stops, $elapsedTime, $flightMiles, $frequency, 
        array $legs)
    {
        $this->dayIndicator = $dayIndicator;
        $this->stops = $stops;
        $this->elapsedTime = $elapsedTime;
        $this->flightMiles = $flightMiles;
        $this->frequency = $frequency;
        $this->legs = $legs;
    }
    
    /** @return Departure */
    public function getDeparture()
    {
        $departure = null;
        if (count($this->legs) > 0)
        {
            $firstLeg = $this->legs[0];
            $departure = $firstLeg->getDeparture();
        }
        return $departure;
    }
    
    /** @return Arrival */
    public function getArrival()
    {
        $arrival = null;
        if (count($this->legs) > 0)
        {
            $lastLeg = $this->legs[count($this->legs) - 1];
            $arrival = $lastLeg->getArrival();
        }
        return $arrival;
    }

    /** @return string */
    public function getFlightNumber()
    {
        $all = array_map(function(FlightLeg $leg) { return $leg->getFlightNumber(); }, $this->legs);
        return join('/', $all);
    }
    
    /** @return array */
    public function getCarriers()
    {
        $all = array_map(function(FlightLeg $leg) { return $leg->getCarrier(); }, $this->legs);
        return array_unique($all);
    }

    /** @return array */
    public function getLegs()
    {
        return $this->legs;
    }
    
    /** @return string */
    public function getDayIndicator()
    {
        return $this->dayIndicator;
    }

    /** @return array */
    public function getStops()
    {
        return $this->stops;
    }

    /** @return int */
    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }

    /** @return int */
    public function getFlightMiles()
    {
        return $this->flightMiles;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }
}