<?php

namespace DHolmes\InnovataSTK\Cached;

class NullCache implements Cache
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $lifetime
     */
    public function set($key, $value, $lifetime)
    {
        
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return null;
    }
    
    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return false;
    }
}