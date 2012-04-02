<?php

namespace DHolmes\InnovataSTK;

use stdClass;
use SimpleXMLElement;
use DateTime;
use DHolmes\InnovataSTK\Soap\SoapClient;
use DHolmes\InnovataSTK\Model\Results\FlightResults;

/**
 *
 * @author Creatio Pty Ltd
 */
class SoapInnovataSTKClient implements InnovataSTKClient
{
    /** @var SoapClient */
    private $client;
    /** @var string */
    private $customerCode;
    /** @var string */
    private $productCode;
    /** @var ResponseParser */
    private $responseParser;
    
    /**
     *
     * @param SoapClient $client
     * @param string $customerCode
     * @param string $productCode
     * @param ResponseParser $responseParser 
     */
    public function __construct(SoapClient $client, $customerCode, $productCode, 
        ResponseParser $responseParser)
    {
        $this->client = $client;
        $this->customerCode = $customerCode;
        $this->productCode = $productCode;
        if ($responseParser === null)
        {
            $this->responseParser = new ResponseParser();
        }
        else
        {
            $this->responseParser = $responseParser;
        }
    }
    
    /**
     * @param DateTime $date
     * @param string $flightNumber
     * @param string $carrierCode
     * @return FlightResults
     */
    public function getSchedules(DateTime $date, $flightNumber, $carrierCode)
    {
        $flightResults = null;
        
        // TODO: Figure out how to deal with xml in more structured way        
        $expectedIn = new stdClass();
        $expectedIn->_sSchedulesSearchXML = sprintf('<GetSchedules_Input 
            customerCode="%s" 
            productCode="%s" 
            DD="%s" 
            MM="%s" 
            YYYY="%s" 
            flightNumber="%s" 
            carCode="%s" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:noNamespaceSchemaLocation="GetSchedules_Input.xsd" />', 
            $this->customerCode, $this->productCode, $date->format('d'), $date->format('m'), 
            $date->format('Y'), $flightNumber, $carrierCode);
        $result = $this->performCall('GetSchedules', $expectedIn);
        
        if ($result instanceof stdClass && isset($result->GetSchedulesResult))
        {
            $xmlResult = new SimpleXMLElement($result->GetSchedulesResult);
            if (isset($xmlResult->error))
            {
                throw new CallException($xmlResult->error);
            }
            else
            {
                $flightResults = $this->responseParser->parseFlightResults($xmlResult);
            }
        }
        else
        {
            throw new CallException('Invalid Response: ' . var_export($result, true));
        }
        
        return $flightResults;
    }
    
    /**
     *
     * @param string $name
     * @param string $inputRequest 
     * @return mixed
     */
    private function performCall($name, $inputRequest)
    {
        return $this->client->makeCall($name, array($inputRequest));
    }
}