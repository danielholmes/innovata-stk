<?php

namespace DHolmes\InnovataSTK\Tests\Soap;

use PHPUnit_Framework_TestCase;
use SoapHeader as NativeSoapHeader;
use SoapClient as NativeSoapClient;
use DHolmes\InnovataSTK\Soap\SoapHeader;
use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;

/**
 *
 * @author Creatio Pty Ltd
 */
class NativeSoapClientAdapterTest extends PHPUnit_Framework_TestCase
{
    /** @var NativeSoapClient */
    private $nativeClient;
    /** @var NativeSoapClientAdapter */
    private $client;
    
    protected function setUp()
    {
        if (extension_loaded('soap'))
        {
            $this->nativeClient = $this->getMockBuilder('SoapClient')
                                       ->disableOriginalConstructor()
                                       ->getMock();
            $this->client = new NativeSoapClientAdapter($this->nativeClient);
        }
        else
        {
            $this->markTestSkipped('Soap extension required');
        }
    }
    
    public function testMakeCall_NormalMethod_InvokesSoapClientCorrectly()
    {
        $this->nativeClient->expects($this->once())
                           ->method('__soapCall')
                           ->with('SomeMethod', array(1, 2, 3));
        
        $args = array(1, 2, 3);
        $this->client->makeCall('SomeMethod', $args);
    }
    
    public function testSetHeaders_Valid_SetsSoapClientCorrectly()
    {
        $expectedHeader = new NativeSoapHeader('http://url', 'Name', 'Data', true);
        
        $this->nativeClient->expects($this->once())
                           ->method('__setSoapHeaders')
                           ->with(array($expectedHeader));
        
        $this->client->setHeaders(array(new SoapHeader('http://url', 'Name', 'Data')));
    }
}