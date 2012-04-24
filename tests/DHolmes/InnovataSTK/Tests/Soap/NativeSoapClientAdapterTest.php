<?php

namespace DHolmes\InnovataSTK\Tests\Soap;

use PHPUnit_Framework_TestCase;
use SoapHeader as NativeSoapHeader;
use SoapClient as NativeSoapClient;
use DHolmes\InnovataSTK\Soap\SoapHeader;
use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;

class NativeSoapClientAdapterTest extends PHPUnit_Framework_TestCase
{    
    protected function setUp()
    {
        if (!extension_loaded('soap'))
        {
            $this->markTestSkipped('Soap extension required');
        }
    }
    
    public function testConstruct_InvalidWSDL_DoesntCauseErrorBecauseLazyInstantiated()
    {
        new NativeSoapClientAdapter('/non-existent-wsdl');
    }
    
    public function testSetHeaders_InvalidWSDL_DoesntCauseErrorBecauseLazyInstantiated()
    {
        $client = new NativeSoapClientAdapter('/non-existent-wsdl');
        
        $client->setHeaders(array());
    }
    
    public function testMakeCall_InvalidWSDL_ThrowsException()
    {
        $this->setExpectedException('RuntimeException', 
            'Error loading WSDL: /non-existent-wsdl');
        
        $client = new NativeSoapClientAdapter('/non-existent-wsdl');
        
        $client->makeCall('Something');
    }
}