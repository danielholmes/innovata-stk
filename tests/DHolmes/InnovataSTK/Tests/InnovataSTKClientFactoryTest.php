<?php

namespace DHolmes\InnovataSTK\Tests;

use PHPUnit_Framework_TestCase;
use SoapClient as NativeSoapClient;
use DHolmes\InnovataSTK\InnovataSTKClientFactory;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;

/**
 *
 * @author Creatio Pty Ltd
 */
class InnovataSTKClientFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateNativePhpSoapClient_Normal_ReturnsCorrectClient()
    {
        $factory = new InnovataSTKClientFactory();
        $client = $factory->createNativePhpSoapClient('customerCode', 'password');
        
        $expectedAdapter = new NativeSoapClientAdapter('http://stk.innovataw3svc.com/DataTimetableToolKitServices.asmx?WSDL');
        $expectedClient = new SoapInnovataSTKClient($expectedAdapter, 'customerCode', 'password');
        $this->assertEquals($expectedClient, $client);
    }
    
    public function testCreateClient_Normal_ReturnsCorrectClient()
    {
        $client = InnovataSTKClientFactory::createClient('customerCode', 'password');
        
        $expectedAdapter = new NativeSoapClientAdapter('http://stk.innovataw3svc.com/DataTimetableToolKitServices.asmx?WSDL');
        $expectedClient = new SoapInnovataSTKClient($expectedAdapter, 'customerCode', 'password');
        $this->assertEquals($expectedClient, $client);
    }
}