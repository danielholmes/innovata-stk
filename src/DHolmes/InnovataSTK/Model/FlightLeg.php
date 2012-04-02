<?php

namespace DHolmes\InnovataSTK\Model;

/**
 *
 * @author Creatio Pty Ltd
 */
class FlightLeg
{
    /** @var int */
    private $stops;
    /** @var string */
    private $cs;
    /** @var Carrier */
    private $carrier;
    /** @var string */
    private $flightNumber;
    /** @var string */
    private $serviceType;
    /** @var int */
    private $dayIndicator;
    /** @var Equipment */
    private $equipment;
    /** @var Departure */
    private $departure;
    /** @var Arrival */
    private $arrival;
    
    /* TODO:
       <equipmentChange>0</equipmentChange>
        <distance>0</distance>
       <restrictionCode />
       <operatedByCarrierCode />
     * <stopCodes>N/A</stopCodes>
     */
    
    /**
     *
     * @param int $stops
     * @param string $cs
     * @param Carrier $carrier
     * @param string $flightNumber
     * @param string $serviceType
     * @param int $dayIndicator
     * @param Equipment $equipment
     * @param Departure $departure
     * @param Arrival $arrival 
     */
    public function __construct($stops, $cs, Carrier $carrier, $flightNumber, $serviceType, 
        $dayIndicator, Equipment $equipment, Departure $departure, Arrival $arrival)
    {
        $this->stops = $stops;
        $this->cs = $cs;
        $this->carrier = $carrier;
        $this->flightNumber = $flightNumber;
        $this->serviceType = $serviceType;
        $this->dayIndicator = $dayIndicator;
        $this->equipment = $equipment;
        $this->departure = $departure;
        $this->arrival = $arrival;
    }

    /**
     *
     * @return int
     */
    public function getStops()
    {
        return $this->stops;
    }

    public function getCs()
    {
        return $this->cs;
    }

    /**
     *
     * @return Carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     *
     * @return int
     */
    public function getDayIndicator()
    {
        return $this->dayIndicator;
    }

    /**
     *
     * @return Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     *
     * @return Departure
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     *
     * @return Arrival
     */
    public function getArrival()
    {
        return $this->arrival;
    }
}