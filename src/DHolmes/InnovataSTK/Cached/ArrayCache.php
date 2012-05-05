<?php

namespace DHolmes\InnovataSTK\Cached;

/** @author Creatio Pty Ltd */
class ArrayCache implements Cache
{
    /** @var array */
    private $data;
    
    public function __construct()
    {
        $this->data = array();
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @param int $lifetime
     */
    public function set($key, $value, $lifetime)
    {
        $this->data[$key] = $value;
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $value = null;
        if ($this->has($key))
        {
            $value = $this->data[$key];
        }
        return $value;
    }
    
    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }
}