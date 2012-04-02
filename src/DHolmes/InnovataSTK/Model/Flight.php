<?php

namespace DHolmes\InnovataSTK\Model;

/**
 *
 * @author Creatio Pty Ltd
 */
class Flight
{
    /** @var string */
    private $carrierFlight;
    /** @var Carrier */
    private $carrier;
    /** @var int */
    private $dayIndicator;
    /** @var array */
    private $stops;
    /** @var int */
    private $elapsedTime;
    /** @var int */
    private $flightMiles;
    /** @var string */
    private $frequency;
    /** @var array */
    private $legs;
    
    /**
     *
     * @param string $carrierFlight
     * @param Carrier $carrier
     * @param int $dayIndicator
     * @param array $stops
     * @param int $elapsedTime
     * @param int $flightMiles
     * @param string $frequency 
     * @param array $legs
     */
    public function __construct($carrierFlight, Carrier $carrier, $dayIndicator, array $stops, 
        $elapsedTime, $flightMiles, $frequency, array $legs)
    {
        $this->carrierFlight = $carrierFlight;
        $this->carrier = $carrier;
        $this->dayIndicator = $dayIndicator;
        $this->stops = $stops;
        $this->elapsedTime = $elapsedTime;
        $this->flightMiles = $flightMiles;
        $this->frequency = $frequency;
        $this->legs = $legs;
    }

    public function getCarrierFlight()
    {
        return $this->carrierFlight;
    }

    /**
     *
     * @return array
     */
    public function getLegs()
    {
        return $this->legs;
    }
    
    /**
     *
     * @return Carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
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