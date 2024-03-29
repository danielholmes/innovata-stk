<?php

namespace DHolmes\InnovataSTK\Soap;

use DateTime;
use DateInterval;
use SimpleXMLElement;
use DHolmes\InnovataSTK\Model\Results\FlightResults;
use DHolmes\InnovataSTK\Model\Carrier;
use DHolmes\InnovataSTK\Model\Equipment;
use DHolmes\InnovataSTK\Model\Station;
use DHolmes\InnovataSTK\Model\City;
use DHolmes\InnovataSTK\Model\Metro;
use DHolmes\InnovataSTK\Model\Region;
use DHolmes\InnovataSTK\Model\Country;
use DHolmes\InnovataSTK\Model\Flight;
use DHolmes\InnovataSTK\Model\FlightLeg;
use DHolmes\InnovataSTK\Model\Departure;
use DHolmes\InnovataSTK\Model\Arrival;

class ResponseParser
{
    /**
     * @param SimpleXMLElement $xml
     * @param DateTime $date
     * @return FlightResults 
     */
    public function parseFlightResults(SimpleXMLElement $xml, DateTime $date)
    {
        $carriersByCode = array();
        foreach ($xml->xpath('carriers/carrier') as $carrierXml)
        {
            $carrier = $this->parseCarrier($carrierXml);
            $carriersByCode[$carrier->getCode()] = $carrier;
        }
        
        $equipmentsByCode = array();
        foreach ($xml->xpath('equipments/equipment') as $equipmentXml)
        {
            $equipment = $this->parseEquipment($equipmentXml);
            $equipmentsByCode[$equipment->getCode()] = $equipment;
        }
        
        $regionsByCode = array();
        foreach ($xml->xpath('regions/region') as $regionXml)
        {
            $region = $this->parseRegion($regionXml);
            $regionsByCode[$region->getCode()] = $region;
        }
        
        $countriesByCode = array();
        foreach ($xml->xpath('countries/country') as $countryXml)
        {
            $country = $this->parseCountry($countryXml, $regionsByCode);
            $countriesByCode[$country->getCode()] = $country;
        }
        
        $citiesByCode = array();
        foreach ($xml->xpath('cities/city') as $cityXml)
        {
            $city = $this->parseCity($cityXml, $countriesByCode);
            $citiesByCode[$city->getCode()] = $city;
        }
        
        $metrosByCode = array();
        foreach ($xml->xpath('metros/metro') as $metroXml)
        {
            $metro = $this->parseMetro($metroXml);
            $metrosByCode[$metro->getCode()] = $metro;
        }
        
        $stationsByCode = array();
        foreach ($xml->xpath('stations/station') as $stationXml)
        {
            $station = $this->parseStation($stationXml, $citiesByCode, $metrosByCode);
            $stationsByCode[$station->getCode()] = $station;
        }
        
        $flights = array();
        foreach ($xml->xpath('flights/flight') as $flightXml)
        {
            $flights[] = $this->parseFlight($date, $flightXml, $stationsByCode, 
                            $equipmentsByCode, $carriersByCode);
        }
        
        return new FlightResults($flights);
    }
    
    /**
     * @param DateTime $date
     * @param SimpleXMLElement $flightXml
     * @param array $stationsByCode
     * @param array $equipmentsByCode 
     * @param array $carriersByCode
     * @return Equipment
     */
    private function parseFlight(DateTime $date, SimpleXMLElement $flightXml, 
        array $stationsByCode, array $equipmentsByCode, array $carriersByCode)
    {
        $atts = $flightXml->attributes();
        
        // TODO: stops
        $stops = array();
        $legs = array();
        if (isset($flightXml->legs->leg))
        {
            foreach ($flightXml->legs->leg as $legXml)
            {
                $legs[] = $this->parseFlightLeg($date, $legXml, $stationsByCode, 
                            $equipmentsByCode, $carriersByCode);
            }
        }
        
        // TODO: Operation dates
        /*<opDates effective="N" discontinue="Y">
            <effective mm="01" dd="01" yyyy="1901" />
            <discontinue mm="06" dd="06" yyyy="2012" />
        </opDates>*/
        
        return new Flight((int)$atts['dayIndicator'], $stops, 
                (int)$atts['elapsedTime'], (int)$atts['fltMiles'], (string)$atts['frequency'], 
                $legs);
    }
    
    /**
     * @param DateTime $date
     * @param SimpleXMLElement $legXml
     * @param array $stationsByCode
     * @param array $equipmentsByCode 
     * @param array $carriersByCode
     * @return FlightLeg 
     */
    private function parseFlightLeg(DateTime $date, SimpleXMLElement $legXml, array $stationsByCode, 
        array $equipmentsByCode, array $carriersByCode)
    {
        $atts = $legXml->attributes();
        
        $departureStationCode = (string)$legXml->dpt->attributes()->aptCode;
        $arrivalStationCode = (string)$legXml->arv->attributes()->aptCode;
        
        /* TODO:
       <equipmentChange>0</equipmentChange>
        <distance>0</distance>
       <restrictionCode />
       <operatedByCarrierCode />
     * <stopCodes>N/A</stopCodes>
     */
        
        $baseTime = strtotime($date->format('Y-m-d'));
        $departTime = $baseTime + ((int)$atts['dptTime'] * 60);
        $departDateTime = DateTime::createFromFormat('U', $departTime);
        $departure = new Departure($stationsByCode[$departureStationCode], $departDateTime,
                        (string)$legXml->dpt->attributes()->terminal);
        
        $arrivalTime = $baseTime + ((int)$atts['arvTime'] * 60);
        $arrivalDateTime = DateTime::createFromFormat('U', $arrivalTime);
        $dayIndicator = (string)$atts['dayIndicator'];
        if (strpos($dayIndicator, '+') === 0)
        {
            $days = substr($dayIndicator, 1);
            $arrivalDateTime->add(new DateInterval('P' . $days . 'D'));
        }
        else if (strpos($dayIndicator, '-') === 0)
        {
            $days = substr($dayIndicator, 1);
            $arrivalDateTime->sub(new DateInterval('P' . $days . 'D'));
        }        
        $arrival = new Arrival($stationsByCode[$arrivalStationCode], $arrivalDateTime,
                        (string)$legXml->arv->attributes()->terminal);
        
        $carrierCode = (string)$atts['carCode'];
        $equipmentCode = (string)$atts['equipCode'];
        
        return new FlightLeg((int)$atts['stops'], (string)$atts['cs'], $carriersByCode[$carrierCode], 
                (string)$atts['flightNumber'], (string)$atts['serviceType'],
                $equipmentsByCode[$equipmentCode], $departure, $arrival);
    }
    
    /**
     * @param SimpleXMLElement $xml
     * @param array $countriesByCode
     * @return City 
     */
    private function parseCity(SimpleXMLElement $xml, array $countriesByCode)
    {
        $atts = $xml->attributes();
        $countryCode = (string)$atts['cntryCode'];
        return new City((string)$atts['Code'], (string)$atts['name'], 
                $countriesByCode[$countryCode], (double)$atts['lat'], (double)$atts['lon']);
    }
    
    /**
     * @param SimpleXMLElement $xml
     * @return Region 
     */
    private function parseRegion(SimpleXMLElement $xml)
    {
        $atts = $xml->attributes();
        return new Region((string)$atts['code'], (string)$atts['name']);
    }
    
    /**
     * @param SimpleXMLElement $xml
     * @param array $regionsByCode
     * @return Country
     */
    private function parseCountry(SimpleXMLElement $xml, array $regionsByCode)
    {
        $atts = $xml->attributes();
        $regionCode = (string)$atts['regioncode'];
        return new Country((string)$atts['code'], (string)$atts['name'], 
                $regionsByCode[$regionCode]);
    }
    
    /**
     * @param SimpleXMLElement $xml
     * @return Metro
     */
    private function parseMetro(SimpleXMLElement $xml)
    {
        $atts = $xml->attributes();
        return new Metro((string)$atts['code'], (string)$atts['name']);
    }
    
    /**
     * @param SimpleXMLElement $xml
     * @return Equipment 
     */
    private function parseEquipment(SimpleXMLElement $xml)
    {
        $atts = $xml->attributes();
        return new Equipment((string)$atts['code'], (string)$atts['class'], (string)$atts['desc'], 
                (string)$atts['acftType'], ((string)$atts['Widebody'] === 'Y'));
    }
    
    /**
     * @param SimpleXMLElement $carrierXml
     * @return Carrier 
     */
    private function parseCarrier(SimpleXMLElement $xml)
    {
        $atts = $xml->attributes();
        return new Carrier((string)$atts['code'], (string)$atts['name'], (string)$atts['url']);
    }
    
    /**
     * @param SimpleXMLElement $carrierXml
     * @param array $citiesByCode
     * @param array $metrosByCode
     * @return Station
     */
    private function parseStation(SimpleXMLElement $xml, array $citiesByCode, array $metrosByCode)
    {
        $atts = $xml->attributes();
        $cityCode = (string)$atts['cityCode'];
        $metroCode = (string)$atts['metroCityCode'];
        $metro = null;
        if (!empty($metroCode))
        {
            $metro = $metrosByCode[$metroCode];
        }
        return new Station((string)$atts['code'], (string)$atts['name'], $citiesByCode[$cityCode],
                $metro);
    }
}