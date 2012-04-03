<?php

namespace DHolmes\InnovataSTK\Model;

/**
 *
 * @author Creatio Pty Ltd
 */
class Flight
{
    /** @var int */
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
     *
     * @param int $dayIndicator
     * @param array $stops
     * @param int $elapsedTime
     * @param int $flightMiles
     * @param string $frequency 
     * @param array $legs
     */
    public function __construct($dayIndicator, array $stops, 
        $elapsedTime, $flightMiles, $frequency, array $legs)
    {
        $this->dayIndicator = $dayIndicator;
        $this->stops = $stops;
        $this->elapsedTime = $elapsedTime;
        $this->flightMiles = $flightMiles;
        $this->frequency = $frequency;
        $this->legs = $legs;
    }

    /**
     *
     * @return string
     */
    public function getFlightNumber()
    {
        $all = array_map(function(FlightLeg $leg) { return $leg->getFlightNumber(); }, $this->legs);
        return join('/', $all);
    }
    
    /**
     *
     * @return array
     */
    public function getCarriers()
    {
        $all = array_map(function(FlightLeg $leg) { return $leg->getCarrier(); }, $this->legs);
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getLegs()
    {
        return $this->legs;
    }
    
    public function getDayIndicator()
    {
        return $this->dayIndicator;
    }

    /**
     *
     * @return array
     */
    public function getStops()
    {
        return $this->stops;
    }

    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }

    public function getFlightMiles()
    {
        return $this->flightMiles;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }
}