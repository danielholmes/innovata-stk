<?php

namespace DHolmes\InnovataSTK\Cached;

use Doctrine\Common\Cache\Cache as DoctrineCache;

/** @author Creatio Pty Ltd */
class DoctrineCacheAdapter implements Cache
{
    /** @var DoctrineCache */
    private $cache;
    
    /** @param DoctrineCache $cache */
    public function __construct(DoctrineCache $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @param int $lifetime
     */
    public function set($key, $value, $lifetime)
    {
        $this->cache->save($key, $value, $lifetime);
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->fetch($key);
    }
    
    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->cache->contains($key);
    }
}