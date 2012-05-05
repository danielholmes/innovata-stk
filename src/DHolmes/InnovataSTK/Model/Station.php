<?php

namespace DHolmes\InnovataSTK\Model;

class Station
{
    /** @var string */
    private $code;
    /** @var string */
    private $name;
    /** @var City */
    private $city;
    /** @var Metro */
    private $metro;
    
    /**
     * @param string $code
     * @param string $name
     * @param City $city
     * @param Metro $metro
     */
    public function __construct($code, $name, City $city, Metro $metro = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->city = $city;
        $this->metro = $metro;
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

    /** @return City */
    public function getCity()
    {
        return $this->city;
    }

    /** @return Metro */
    public function getMetro()
    {
        return $this->metro;
    }
}