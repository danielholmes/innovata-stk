<?php

namespace DHolmes\InnovataSTK\Model;

class FlightLeg
{
    /** @var int */
    private $stops;
    /** @var string */
    private $cs;
    /** @var Carrier */
    private $carrier;
    /** @var string */
    private $flightNumberNumeric;
    /** @var string */
    private $serviceType;
    /** @var Equipment */
    private $equipment;
    /** @var Departure */
    private $departure;
    /** @var Arrival */
    private $arrival;
    
    /**
     * @param int $stops
     * @param string $cs
     * @param Carrier $carrier
     * @param string $flightNumberNumeric
     * @param string $serviceType
     * @param Equipment $equipment
     * @param Departure $departure
     * @param Arrival $arrival 
     */
    public function __construct($stops, $cs, Carrier $carrier, $flightNumberNumeric, $serviceType, 
        Equipment $equipment, Departure $departure, Arrival $arrival)
    {
        $this->stops = $stops;
        $this->cs = $cs;
        $this->carrier = $carrier;
        $this->flightNumberNumeric = $flightNumberNumeric;
        $this->serviceType = $serviceType;
        $this->equipment = $equipment;
        $this->departure = $departure;
        $this->arrival = $arrival;
    }
    
    /** @return string */
    public function getFlightNumber()
    {
        return $this->carrier->getCode() . $this->getFlightNumberNumeric();
    }

    /** @return int */
    public function getStops()
    {
        return $this->stops;
    }

    public function getCs()
    {
        return $this->cs;
    }

    /** @return Carrier */
    public function getCarrier()
    {
        return $this->carrier;
    }

    public function getFlightNumberNumeric()
    {
        return $this->flightNumberNumeric;
    }

    public function getServiceType()
    {
        return $this->serviceType;
    }

    /** @return Equipment */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /** @return Departure */
    public function getDeparture()
    {
        return $this->departure;
    }

    /** @return Arrival */
    public function getArrival()
    {
        return $this->arrival;
    }
}