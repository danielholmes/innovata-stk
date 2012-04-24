<?php

namespace DHolmes\InnovataSTK\Model;

class Carrier
{
    /** @var string */
    private $code;
    /** @var string */
    private $name;
    /** @var string */
    private $url;
    
    /**
     * @param string $code
     * @param string $name
     * @param string $url 
     */
    public function __construct($code, $name, $url)
    {
        $this->code = $code;
        $this->name = $name;
        $this->url = $url;
    }
    
    /** @return string */
    public function getCode()
    {
        return $this->code;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @return string */
    public function getUrl()
    {
        return $this->url;
    }
}