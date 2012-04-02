<?php

namespace DHolmes\InnovataSTK\Tests\Soap\SoapInnovataSTKClient;

use DateTime;
use stdClass;
use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\SoapClient;
use DHolmes\InnovataSTK\Model\Results\FlightResults;
use DHolmes\InnovataSTK\Soap\ResponseParser;

/**
 *
 * @author Creatio Pty Ltd
 */
class GetSchedulesTest extends PHPUnit_Framework_TestCase
{
    /** @var SoapClient */
    private $soapClient;
    /** @var ResponseParser /*
    private $responseParser;
    /** @var SoapInnovataSTKClient */
    private $client;
    
    protected function setUp()
    {
        $this->soapClient = $this->getMockBuilder('DHolmes\InnovataSTK\Soap\SoapClient')
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->responseParser = $this->getMock('DHolmes\InnovataSTK\Soap\ResponseParser');
        $this->client = new SoapInnovataSTKClient($this->soapClient, 'guest', 'external', 
                            $this->responseParser);
    }
    
    public function testGetSchedules_NormalCall_InvokesSoapCorrectly()
    {
        // TODO: Compare xml semantically rather than through strings
        $expectedIn = new stdClass();
        $expectedIn->_sSchedulesSearchXML = '<GetSchedules_Input 
            customerCode="guest" productCode="external" 
            DD="03" MM="02" YYYY="2012" flightNumber="0010" carCode="BA" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:noNamespaceSchemaLocation="GetSchedules_Input.xsd" />';
        $result = new stdClass();
        $result->GetSchedulesResult = '<flightResults></flightResults>';
        $this->soapClient->expects($this->once())
                         ->method('makeCall')
                         ->with('GetSchedules', array($expectedIn))
                         ->will($this->returnValue($result));
        
        $this->client->getSchedules(new DateTime('2012-02-03'), '0010', 'BA');
    }
    
    /**
     *
     * @dataProvider invalidResponseDataProvider
     * @param mixed $response 
     */
    public function testGetSchedules_InvalidResponse_ThrowsException($response)
    {
        $this->setExpectedException('DHolmes\InnovataSTK\CallException', 
            'Invalid Response: ' . var_export($response, true));
        
        $this->soapClient->expects($this->any())
                         ->method('makeCall')
                         ->with($this->anything(), $this->anything())
                         ->will($this->returnValue($response));
        
        $this->client->getSchedules(new DateTime('2012-02-03'), '0010', 'BA');
    }
    
    public function testGetSchedules_ReturnsErrorNode_ThrowsExceptionWithMessage()
    {
        $this->setExpectedException('DHolmes\InnovataSTK\CallException', 
            'Please enter the correct login credential.');
        
        $result = new stdClass();
        $result->GetSchedulesResult = 
            '<flightResults>
                <flights count="0" /><carriers count="0" /><equipments count="0" />
                <stations count="0" /><metros count="0" /><countries count="0" />
                <regions count="0" />
                <error>Please enter the correct login credential.</error>
            </flightResults>';
        $this->soapClient->expects($this->any())
                         ->method('makeCall')
                         ->with($this->anything(), $this->anything())
                         ->will($this->returnValue($result));
        
        $this->client->getSchedules(new DateTime('2012-02-03'), '0010', 'BA');
    }
    
    public function testGetSchedules_Success_ParsesCorrectly()
    {
        $response = new stdClass();
        $response->GetSchedulesResult = '<flightResults></flightResults>';
        $this->soapClient->expects($this->any())
                         ->method('makeCall')
                         ->with($this->anything(), $this->anything())
                         ->will($this->returnValue($response));
        $parsedResult = new FlightResults(array());
        $this->responseParser->expects($this->once())
                             ->method('parseFlightResults')
                             ->with($this->anything())
                             ->will($this->returnValue($parsedResult));
        
        $result = $this->client->getSchedules(new DateTime('2012-02-03'), '0010', 'BA');
        
        $this->assertSame($parsedResult, $result);
    }
    
    /**
     *
     * @return array
     */
    public function invalidResponseDataProvider()
    {
        return array(
            array('hello'),
            array(new stdClass()),
        );
    }
}