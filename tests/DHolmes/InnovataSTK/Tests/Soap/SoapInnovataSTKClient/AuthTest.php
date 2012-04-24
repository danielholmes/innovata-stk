<?php

namespace DHolmes\InnovataSTK\Tests\Soap\SoapInnovataSTKClient;

use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\SoapClient;
use DHolmes\InnovataSTK\Soap\SoapHeader;

class AuthTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct_NormalParams_SetsCorrectSoapHeaders()
    {
        $soapClient = $this->getMock('DHolmes\InnovataSTK\Soap\SoapClient');
        $soapClient->expects($this->once())
                   ->method('setHeaders')
                   ->with(array(
                       new SoapHeader('http://DataTimeTableToolKit.com/', 'WSAuthenticate', array(
                            'CustomerRefCode' => 'guest',
                            'Password' => 'password',
                            'WebServicesRefCode' => 'TKS'
                       ))
                   ));
        
        new SoapInnovataSTKClient($soapClient, 'guest', 'password');
    }
}