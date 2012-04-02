<?php

namespace DHolmes\InnovataSTK;

use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\ServiceDetails;

/**
 *
 * @author Creatio Pty Ltd
 */
class InnovataSTKClientFactory
{
    /**
     *
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
     *
     * @param string $customerCode
     * @param string $password
     * @return InnovataSTKClient 
     */
    public function createNativePhpSoapClient($customerCode, $password)
    {
        $adapter = new NativeSoapClientAdapter(ServiceDetails::WSDL_URL);
        return new SoapInnovataSTKClient($adapter, $customerCode, $password);
    }
}