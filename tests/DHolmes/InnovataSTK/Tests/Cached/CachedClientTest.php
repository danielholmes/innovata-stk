<?php

namespace DHolmes\InnovataSTK\Tests\Cached;

use DateTime;
use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Stub\StubInnovataSTKClient;
use DHolmes\InnovataSTK\Cached\ArrayCache;
use DHolmes\InnovataSTK\Cached\CachedClient;

/** @author Creatio Pty Ltd */
class CachedClientTest extends PHPUnit_Framework_TestCase
{
    public function testGetSchedules_Normal_ReturnsLiveResult()
    {
        $cachedClient = new StubInnovataSTKClient();
        $cachedClient->setFixedResponsesByCallName(array('getSchedules' => array('hello')));
        $client = new CachedClient($cachedClient, new ArrayCache());
        
        $result = $client->getSchedules(new DateTime(), 'AB', '0123');
        
        $this->assertEquals(array('hello'), $result);
    }
    
    public function testGetSchedules_CachedResult_ReturnsCachedResult()
    {
        $cachedClient = $this->getMock('DHolmes\InnovataSTK\InnovataSTKClient');
        $cachedClient->expects($this->once())
                     ->method('getSchedules')
                     ->with($this->anything());
        $client = new CachedClient($cachedClient, new ArrayCache());
        
        $client->getSchedules(new DateTime(), 'AB', '0123');
        $client->getSchedules(new DateTime(), 'AB', '0123');
    }
    
    public function testGetSchedules_DifferentCalls_DoesntShareCache()
    {
        $cachedClient = $this->getMock('DHolmes\InnovataSTK\InnovataSTKClient');
        $cachedClient->expects($this->exactly(2))
                     ->method('getSchedules')
                     ->with($this->anything());
        $client = new CachedClient($cachedClient, new ArrayCache());
        
        $client->getSchedules(new DateTime(), 'AB', '0123');
        $client->getSchedules(new DateTime(), 'AB', '4567');
    }
}