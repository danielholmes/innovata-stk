<?php

namespace DHolmes\InnovataSTK\Tests\Soap;

use PHPUnit_Framework_TestCase;
use SoapClient;
use DHolmes\InnovataSTK\InnovataSTKClientFactory;
use DHolmes\InnovataSTK\Soap\ServiceDetails;

class ServiceDetailsTest extends PHPUnit_Framework_TestCase
{
    public function testWsdl_InitialiseService_IntegratesCorrectly()
    {
        if (extension_loaded('soap'))
        {
            $guaranteedUrl = 'http://www.google.com';
            $result = @file_get_contents($guaranteedUrl);
            if ($result === false)
            {
                $this->markTestSkipped('Internet connection required');
            }
            else
            {            
                $client = new SoapClient(ServiceDetails::WSDL_URL);
            
                $functions = $client->__getFunctions();
                
                $this->assertGreaterThan(0, count($functions));
            }
        }
        else
        {
            $this->markTestSkipped(sprintf('Soap extension required'));
        }
    }
}