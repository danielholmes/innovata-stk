<?php

namespace DHolmes\InnovataSTK\Cached;

use DHolmes\InnovataSTK\InnovataSTKClient;
use DHolmes\InnovataSTK\Cached\Cache;
use DateTime;

class CachedClient implements InnovataSTKClient
{
    /** @var InnovataSTKClient */
    private $cached;
    /** @var Cache */
    private $cache;
    /** @var int */
    private $cacheLifetime;
    
    /** 
     * @param InnovataSTKClient $cached
     * @param Cache $cache
     * @param int $cacheLifetime
     */
    public function __construct(InnovataSTKClient $cached, Cache $cache, $cacheLifetime = 0)
    {
        $this->cached = $cached;
        $this->cache = $cache;
        $this->cacheLifetime = $cacheLifetime;
    }
    
    /**
     * @param DateTime $date
     * @param string $carrierCode
     * @param string $flightNumber
     * @return FlightResults
     */
    public function getSchedules(DateTime $date, $carrierCode, $flightNumber)
    {
        $result = null;
        $key = $this->createCacheKey('getSchedules', func_get_args());
        if ($this->cache->has($key))
        {
            $result = $this->cache->get($key);
        }
        else
        {
            $result = $this->cached->getSchedules($date, $carrierCode, $flightNumber);
            $this->cache->set($key, $result, $this->cacheLifetime);
        }
        return $result;
    }
    
    /**
     * @param string $method
     * @param array $args
     * @return string
     */
    private function createCacheKey($method, array $args = array())
    {
        return md5($method . '::' . var_export($args, true));
    }
}