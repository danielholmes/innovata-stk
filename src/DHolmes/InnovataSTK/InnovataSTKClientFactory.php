<?php

namespace DHolmes\InnovataSTK;

use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\ServiceDetails;
use DHolmes\InnovataSTK\Stub\StubInnovataSTKClient;

class InnovataSTKClientFactory
{
    /**
     * @param string $customerCode
     * @param string $password
     * @return InnovataSTKClient 
     */
    public static function createClient($customerCode, $password)
    {
        $factory = new static();
        return $factory->createNativePhpSoapClient($customerCode, $password);
    }
    
    /**
     * @param string $customerCode
     * @param string $password
     * @return InnovataSTKClient 
     */
    public function createNativePhpSoapClient($customerCode, $password)
    {
        $adapter = new NativeSoapClientAdapter(ServiceDetails::WSDL_URL);
        return new SoapInnovataSTKClient($adapter, $customerCode, $password);
    }
    
    /**
     * @param array $fixedResponsesByCallName
     * @return InnovataSTKClient 
     */
    public static function createStubClient(array $fixedResponsesByCallName = array())
    {
        $client = new StubInnovataSTKClient();
        $client->setFixedResponsesByCallName($fixedResponsesByCallName);
        return $client;
    }
}