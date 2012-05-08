<?php

namespace DHolmes\InnovataSTK\Tests\Soap\SoapInnovataSTKClient;

use PHPUnit_Framework_TestCase;
use Phake;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\SoapClient;
use DHolmes\InnovataSTK\Soap\SoapHeader;

class AuthTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct_NormalParams_SetsCorrectSoapHeaders()
    {
        $soapClient = Phake::mock('DHolmes\InnovataSTK\Soap\SoapClient');
        
        new SoapInnovataSTKClient($soapClient, 'guest', 'password');
        
        Phake::verify($soapClient)->setHeaders(array(
            new SoapHeader('http://DataTimeTableToolKit.com/', 'WSAuthenticate', array(
                'CustomerRefCode' => 'guest',
                'Password' => 'password',
                'WebServicesRefCode' => 'TKS'
            ))
        ));
    }
}