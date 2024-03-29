<?php

namespace DHolmes\InnovataSTK;

use DHolmes\InnovataSTK\Soap\NativeSoapClientAdapter;
use DHolmes\InnovataSTK\Soap\SoapInnovataSTKClient;
use DHolmes\InnovataSTK\Soap\ServiceDetails;
use DHolmes\InnovataSTK\Stub\StubInnovataSTKClient;
use DHolmes\InnovataSTK\Cached\Cache;
use Doctrine\Common\Cache\Cache as DoctrineCache;
use DHolmes\InnovataSTK\Cached\CachedClient;
use DHolmes\InnovataSTK\Cached\DoctrineCacheAdapter;

class InnovataSTKClientFactory
{
    /**
     * @param string $customerCode
     * @param string $password
     * @return InnovataSTKClient 
     */
    public static function createClient($customerCode, $password)
    {
        return static::createNativePhpSoapClient($customerCode, $password);
    }
    
    /**
     * @param string $customerCode
     * @param string $password
     * @return InnovataSTKClient 
     */
    private static function createNativePhpSoapClient($customerCode, $password)
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
    
    /**
     * @param string $customerCode
     * @param string $password
     * @param Cache $cache
     * @param int $lifetime
     * @return CachedClient 
     */
    public static function createCached($customerCode, $password, Cache $cache, $lifetime)
    {
        $cachedClient = static::createClient($customerCode, $password);
        return new CachedClient($cachedClient, $cache, $lifetime);
    }
    
    /**
     * @param string $customerCode
     * @param string $password
     * @param DoctrineCache $cache
     * @param int $lifetime
     * @return CachedClient 
     */
    public static function createDoctrineCached($customerCode, $password, DoctrineCache $cache, 
        $lifetime)
    {
        $adapter = new DoctrineCacheAdapter($cache);
        return static::createCached($customerCode, $password, $adapter, $lifetime);
    }
}