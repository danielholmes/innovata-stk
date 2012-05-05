<?php

namespace DHolmes\InnovataSTK\Tests\Model;

use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Model\Flight;
use DHolmes\InnovataSTK\Model\Carrier;
use DHolmes\InnovataSTK\Model\FlightLeg;
use DHolmes\InnovataSTK\Model\Equipment;
use DHolmes\InnovataSTK\Model\Arrival;
use DHolmes\InnovataSTK\Model\Departure;

class FlightTest extends PHPUnit_Framework_TestCase
{
    public function testGetFlightNumber_OneLeg_ReturnsLegNumber()
    {        
        $legs = array(
            $this->createLeg('BA', '1234')
        );
        $flight = new Flight(1, array(), 0, 0, 0, $legs);
        
        $this->assertSame('BA1234', $flight->getFlightNumber());
    }
    
    public function testGetFlightNumber_MultipleLegs_ReturnsJoinedNumber()
    {        
        $legs = array(
            $this->createLeg('BA', '1234'),
            $this->createLeg('AB', '5678')
        );
        $flight = new Flight(1, array(), 0, 0, 0, $legs);
        
        $this->assertSame('BA1234/AB5678', $flight->getFlightNumber());
    }
    
    private function createLeg($carrierCode, $flightNumber)
    {
        $equipment = $this->getMockBuilder('DHolmes\InnovataSTK\Model\Equipment')
                          ->disableOriginalConstructor()
                          ->getMock();
        $departure = $this->getMockBuilder('DHolmes\InnovataSTK\Model\Departure')
                          ->disableOriginalConstructor()
                          ->getMock();
        $arrival = $this->getMockBuilder('DHolmes\InnovataSTK\Model\Arrival')
                        ->disableOriginalConstructor()
                        ->getMock();
        
        return new FlightLeg(null, null, new Carrier($carrierCode, null, null), $flightNumber,  
                null, $equipment, $departure, $arrival);
    }
}