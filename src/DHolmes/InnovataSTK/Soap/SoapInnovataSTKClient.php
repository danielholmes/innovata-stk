<?php

namespace DHolmes\InnovataSTK\Soap;

use stdClass;
use SimpleXMLElement;
use DateTime;
use DHolmes\InnovataSTK\InnovataSTKClient;
use DHolmes\InnovataSTK\CallException;
use DHolmes\InnovataSTK\Model\Results\FlightResults;

class SoapInnovataSTKClient implements InnovataSTKClient
{
    /** @var SoapClient */
    private $client;
    /** @var string */
    private $customerCode;
    /** @var string */
    private $password;
    /** @var ResponseParser */
    private $responseParser;
    
    /**
     * @param SoapClient $client
     * @param string $customerCode
     * @param string $password
     * @param ResponseParser $responseParser 
     */
    public function __construct(SoapClient $client, $customerCode, $password, 
        ResponseParser $responseParser = null)
    {
        $this->client = $client;
        $this->customerCode = $customerCode;
        $this->password = $password;
        if ($responseParser === null)
        {
            $this->responseParser = new ResponseParser();
        }
        else
        {
            $this->responseParser = $responseParser;
        }
        
        $this->client->setHeaders(array(
            new SoapHeader('http://DataTimeTableToolKit.com/', 'WSAuthenticate', array(
                'CustomerRefCode' => $customerCode,
                'Password' => $password,
                'WebServicesRefCode' => 'TKS'
            ))
        ));
    }
    
    /**
     * @param DateTime $date
     * @param string $carrierCode
     * @param string $flightNumber
     * @return FlightResults
     */
    public function getSchedules(DateTime $date, $carrierCode, $flightNumber)
    {
        $flightResults = null;
        
        // TODO: Figure out how to deal with xml in more structured way        
        $expectedIn = new stdClass();
        $expectedIn->_sSchedulesSearchXML = sprintf('<GetSchedules_Input 
            customerCode="%s" productCode="external" 
            DD="%s" MM="%s" YYYY="%s" flightNumber="%s" carCode="%s" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:noNamespaceSchemaLocation="GetSchedules_Input.xsd" />', 
            $this->customerCode, $date->format('d'), $date->format('m'), 
            $date->format('Y'), $flightNumber, $carrierCode);
        $result = $this->performCall('GetSchedules', $expectedIn);
        $xmlResult = $this->parseXmlResult($result, 'GetSchedulesResult');
        
        return $this->responseParser->parseFlightResults($xmlResult);
    }
    
    /**
     * @param mixed $result
     * @param string $xmlParamName 
     * @return SimpleXMLElement
     */
    private function parseXmlResult($result, $xmlParamName)
    {
        $validXmlResult = null;
        
        if ($result instanceof stdClass && isset($result->$xmlParamName))
        {
            $xmlResult = new SimpleXMLElement($result->$xmlParamName);
            if (isset($xmlResult->error))
            {
                throw new CallException($xmlResult->error);
            }
            else
            {
                $validXmlResult = $xmlResult;
            }
        }
        else
        {
            throw new CallException('Invalid Response: ' . var_export($result, true));
        }
        
        return $validXmlResult;
    }
    
    /**
     * @param string $name
     * @param string $inputRequest 
     * @return mixed
     */
    private function performCall($name, $inputRequest)
    {
        return $this->client->makeCall($name, array($inputRequest));
    }
}