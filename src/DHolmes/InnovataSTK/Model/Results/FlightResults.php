<?php

namespace DHolmes\InnovataSTK\Model\Results;

/**
 *
 * @author Creatio Pty Ltd
 */
class FlightResults
{
    /** @var array */
    private $flights;
    
    /**
     *
     * @param array $flights
     */
    public function __construct(array $flights)
    {
        $this->flights = $flights;
    }
    
    /**
     *
     * @return array
     */
    public function getFlights()
    {
        return $this->flights;
    }

    /**
     *
     * @return array
     */
    public function getCarriers()
    {
        $all = array_map(function(Flight $flight) { return $flight->getCarrier(); }, 
                $this->flights);
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getEquipments()
    {
        $all = array_map(function(Flight $flight) { return $flight->getEquipment(); }, 
                $this->flights);
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getStations()
    {
        $all = array();
        foreach ($this->flights as $flight)
        {
            $all[] = $flight->getDepartureStation();
            $all[] = $flight->getArrivalStation();
        }
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getCities()
    {
        $all = array_map(function(Station $station) { return $station->getCity(); }, 
                $this->getStations());
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getMetros()
    {
        $all = array_map(function(Station $station) { return $station->getMetro(); }, 
                $this->getStations());
        return array_unique($all);
    }
    
    /**
     *
     * @return array
     */
    public function getCountries()
    {
        $all = array_map(function(City $city) { return $city->getCountry(); }, 
                $this->getCities());
        return array_unique($all);
    }

    /**
     *
     * @return array
     */
    public function getRegions()
    {
        $all = array_map(function(Country $country) { return $city->getRegion(); }, 
                $this->getCountries());
        return array_unique($all);
    }
}