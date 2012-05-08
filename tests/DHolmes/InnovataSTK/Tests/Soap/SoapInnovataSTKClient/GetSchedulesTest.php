<?php

namespace DHolmes\InnovataSTK\Tests\Soap\SoapInnovataSTKClient;

use DateTime;
use stdClass;
use Phake;
use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\SoapClient;
use DHolmes\InnovataSTK\Model\Results\FlightResults;
use DHolmes\InnovataSTK\Soap\ResponseParser;

class GetSchedulesTest extends PHPUnit_Framework_TestCase
{
    /** @var SoapClient */
    private $soapClient;
    /** @var ResponseParser */
    private $responseParser;
    /** @var SoapInnovataSTKClient */
    private $client;
    
    protected function setUp()
    {
        $this->soapClient = Phake::mock('DHolmes\InnovataSTK\Soap\SoapClient');
        $this->responseParser = Phake::mock('DHolmes\InnovataSTK\Soap\ResponseParser');
        $this->client = new SoapInnovataSTKClient($this->soapClient, 'customerCode', 'password', 
                            $this->responseParser);
    }
    
    public function testGetSchedules_NormalCall_InvokesSoapCorrectly()
    {
        // TODO: Compare xml semantically rather than through strings
        $expectedIn = new stdClass();
        $expectedIn->_sSchedulesSearchXML = '<GetSchedules_Input 
            customerCode="customerCode" productCode="external" 
            DD="03" MM="02" YYYY="2012" flightNumber="0010" carCode="BA" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:noNamespaceSchemaLocation="GetSchedules_Input.xsd" />';
        $result = new stdClass();
        $result->GetSchedulesResult = '<flightResults></flightResults>';
        Phake::when($this->soapClient)->makeCall(Phake::anyParameters())->thenReturn($result);
        
        $this->client->getSchedules(new DateTime('2012-02-03'), 'BA', '0010');
        
        Phake::verify($this->soapClient)->makeCall('GetSchedules', array($expectedIn));
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
        
        Phake::when($this->soapClient)->makeCall(Phake::anyParameters())->thenReturn($response);
        
        $this->client->getSchedules(new DateTime('2012-02-03'), 'BA', '0010');
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
        Phake::when($this->soapClient)->makeCall(Phake::anyParameters())->thenReturn($result);
        
        $this->client->getSchedules(new DateTime('2012-02-03'), 'BA', '0010');
    }
    
    public function testGetSchedules_Success_ParsesCorrectly()
    {
        $response = new stdClass();
        $response->GetSchedulesResult = '<flightResults></flightResults>';
        Phake::when($this->soapClient)->makeCall(Phake::anyParameters())->thenReturn($response);
        $parsedResult = new FlightResults(array());
        Phake::when($this->responseParser)->parseFlightResults(Phake::anyParameters())
                                          ->thenReturn($parsedResult);
        
        $result = $this->client->getSchedules(new DateTime('2012-02-03'), 'BA', '0010');
        
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