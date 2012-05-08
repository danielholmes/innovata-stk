<?php

namespace DHolmes\InnovataSTK\Tests\Cached;

use DateTime;
use Phake;
use PHPUnit_Framework_TestCase;
use DHolmes\InnovataSTK\Stub\StubInnovataSTKClient;
use DHolmes\InnovataSTK\Cached\ArrayCache;
use DHolmes\InnovataSTK\Cached\CachedClient;
use DHolmes\InnovataSTK\Cached\Cache;

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
    
    public function testGetSchedules_CachedResult_DoesntCallTwice()
    {
        $cachedClient = Phake::mock('DHolmes\InnovataSTK\InnovataSTKClient');
        $client = new CachedClient($cachedClient, new ArrayCache());
        
        $client->getSchedules(new DateTime(), 'AB', '0123');
        $client->getSchedules(new DateTime(), 'AB', '0123');
        
        Phake::verify($cachedClient, Phake::times(1))->getSchedules(Phake::anyParameters());
    }
    
    public function testGetSchedules_CachedResult_ReturnsCachedResult()
    {
        $cachedClient = Phake::mock('DHolmes\InnovataSTK\InnovataSTKClient');
        $cache = Phake::mock('DHolmes\InnovataSTK\Cached\Cache');
        Phake::when($cache)->has(Phake::anyParameters())->thenReturn(true);
        Phake::when($cache)->get(Phake::anyParameters())->thenReturn(12345);
        $client = new CachedClient($cachedClient, $cache);
        
        $result = $client->getSchedules(new DateTime(), 'AB', '0123');
        
        $this->assertSame(12345, $result);
    }
    
    public function testGetSchedules_DifferentCalls_DoesntShareCache()
    {
        $cachedClient = Phake::mock('DHolmes\InnovataSTK\InnovataSTKClient');
        $client = new CachedClient($cachedClient, new ArrayCache());
        
        $client->getSchedules(new DateTime(), 'AB', '0123');
        $client->getSchedules(new DateTime(), 'AB', '4567');
        
        Phake::verify($cachedClient, Phake::times(2))->getSchedules(Phake::anyParameters());
    }
    
    public function testGetSchedules_NormalCall_SavesToCacheCorrectly()
    {
        $cache = Phake::mock('DHolmes\InnovataSTK\Cached\Cache');
        $cachedClient = Phake::mock('DHolmes\InnovataSTK\InnovataSTKClient');
        Phake::when($cachedClient)->getSchedules(Phake::anyParameters())
                                  ->thenReturn(12345);
        $client = new CachedClient($cachedClient, $cache, 3600);
        
        $client->getSchedules(new DateTime(), 'AB', '0123');
        
        Phake::verify($cache)->set($this->anything(), 12345, 3600);
    }
}