<?php

namespace DHolmes\InnovataSTK\Tests\ResponseParser\Soap;

use SimpleXMLElement;
use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Soap\ResponseParser;
use DHolmes\InnovataSTK\Model\Results\FlightResults;
use DHolmes\InnovataSTK\Model\Carrier;
use DHolmes\InnovataSTK\Model\Equipment;
use DHolmes\InnovataSTK\Model\Station;
use DHolmes\InnovataSTK\Model\City;
use DHolmes\InnovataSTK\Model\Metro;
use DHolmes\InnovataSTK\Model\Region;
use DHolmes\InnovataSTK\Model\Flight;
use DHolmes\InnovataSTK\Model\FlightLeg;
use DHolmes\InnovataSTK\Model\Country;
use DHolmes\InnovataSTK\Model\Arrival;
use DHolmes\InnovataSTK\Model\Departure;

class FlightResultsTest extends PHPUnit_Framework_TestCase
{    
    public function testParseFlightResults_ValidXml_ReturnsCorrect()
    {
        $parser = new ResponseParser();
        
        $xml = new SimpleXMLElement(self::VALID_XML);
        $result = $parser->parseFlightResults($xml);
        
        $baCarrier = new Carrier('BA', 'British Airways', 'www.ba.com');
        $europeRegion = new Region('EUR', 'Europe');
        $sEAsiaRegion = new Region('SEA', 'Southeast Asia');
        $gbCountry = new Country('GB', 'United Kingdom', $europeRegion);
        $thCountry = new Country('TH', 'Thailand', $sEAsiaRegion);
        $bangkokMetro = new Metro('BKK', 'Bangkok');
        $londonMetro = new Metro('LON', 'London');
        $bangkokCity = new City('BKK', 'Bangkok', $thCountry, 13.91111111, 100.60833333);
        $londonCity = new City('LON', 'London', $gbCountry, 51.30972222, -0.32472222);
        
        $bangkokStation = new Station('BKK', 'Suvarnabhumi International', $bangkokCity, 
                            $bangkokMetro);
        $heathrowStation = new Station('LHR', 'Heathrow Airport', $londonCity, $londonMetro);
        $equipment = new Equipment('744', '747', 'Boeing 747-400 Passenger', 'Jet-engined aircraft', 
                        true);
        $stops = array();
        $departure = new Departure($bangkokStation, 20, '');
        $arrival = new Arrival($heathrowStation, 385, '3');
        $legs = array(
            new FlightLeg(0, 'N', $baCarrier, '0010', 'J', 0, $equipment, $departure, $arrival)
        );
        
        $flight = new Flight(0, $stops, 725, 5957, 'MTWTFSS', $legs);
        $expectedResult = new FlightResults(array($flight));
        $this->assertEquals($expectedResult, $result);
    }
    
    const VALID_XML = <<<XML
        <flightResults>
            <flights count="1">
                <flight carFlight="BA 0010" dptStation="BKK" dptTerm="" arvStation="LHR" arvTerm="3" 
                        dayIndicator="0" stops="0" equipment="744" elapsedTime="725" fltMiles="5957" 
                        frequency="MTWTFSS">
                    <dpt aptCode="BKK" terminal="" cityCode="BKK" metroCityCode="BKK"/>
                    <arv aptCode="LHR" terminal="3" cityCode="" metroCityCode="LON"/>
                    <viaCodes></viaCodes>
                    <opDates effective="Y" discontinue="N">
                        <effective mm="03" dd="26" yyyy="2012" />
                        <discontinue mm="12" dd="31" yyyy="2999" />
                    </opDates>
                    <legs count="1">
                        <leg number="1" dptTime="20" arvTime="385" stops="0" cs="N" carCode="BA" 
                             flightNumber="0010" serviceType="J" dayIndicator="0" equipCode="744">
                            <restrictionCode />
                            <operatedByCarrierCode />
                            <dpt aptCode="BKK" terminal="" cityCode="BKK" country="" region=""/>
                            <arv aptCode="LHR" terminal="3" cityCode="LON" country="" region=""/>
                            <stopCodes>N/A</stopCodes>
                            <equipmentChange>0</equipmentChange>
                            <distance>0</distance>
                        </leg>
                    </legs>
                    <stops />
                </flight>
            </flights>
            <carriers count="1">
                <carrier code="BA" name="British Airways" url="www.ba.com"/>
            </carriers>
            <equipments count="1">
                <equipment code="744" class="747" desc="Boeing 747-400 Passenger" 
                           acftType="Jet-engined aircraft" Widebody="Y"/>
            </equipments>
            <stations count="2">
                <station code="BKK" name="Suvarnabhumi International" cityCode="BKK" 
                         metroCityCode="BKK" />
                <station code="LHR" name="Heathrow Airport" cityCode="LON" metroCityCode="LON" />
            </stations>
            <cities count="2">
                <city Code="BKK" name="Bangkok" cntryCode="TH" lat="13.91111111" lon="100.60833333"/>
                <city Code="LON" name="London" cntryCode="GB" lat="51.30972222" lon="-0.32472222"/>
            </cities>
            <metros count="2">
                <metro code="BKK" name="Bangkok"/>
                <metro code="LON" name="London"/>
            </metros>
            <countries count="2">
                <country code="GB" name="United Kingdom" regioncode="EUR"/>
                <country code="TH" name="Thailand" regioncode="SEA"/>
            </countries>
            <regions count="2">
                <region code="EUR" name="Europe" regioncode="EUR"/>
                <region code="SEA" name="Southeast Asia" regioncode="SEA"/>
            </regions>
        </flightResults>
XML;
}