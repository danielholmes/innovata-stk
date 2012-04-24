<?php

namespace DHolmes\InnovataSTK\Soap;

class SoapHeader
{
    /** @var string */
    public $uri;
    /** @var string */
    public $name;
    /** @var mixed */
    public $data;
    
    /**
     * @param string $uri
     * @param string $name
     * @param mixed $data 
     */
    public function __construct($uri, $name, $data)
    {
        $this->uri = $uri;
        $this->name = $name;
        $this->data = $data;
    }
}