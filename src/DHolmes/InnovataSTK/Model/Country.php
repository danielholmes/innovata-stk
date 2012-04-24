<?php

namespace DHolmes\InnovataSTK\Model;

class Country
{
    /** @var string */
    private $code;
    /** @var string */
    private $name;
    /** @var string */
    private $region;
    
    /**
     * @param string $code
     * @param string $name
     * @param Region $region 
     */
    public function __construct($code, $name, Region $region)
    {
        $this->code = $code;
        $this->name = $name;
        $this->region = $region;
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

    /** @return Region */
    public function getRegion()
    {
        return $this->region;
    }
}