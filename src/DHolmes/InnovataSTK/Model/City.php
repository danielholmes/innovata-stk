<?php

namespace DHolmes\InnovataSTK\Model;

/**
 *
 * @author Creatio Pty Ltd
 */
class City
{
    /** @var string */
    private $code;
    /** @var string */
    private $name;
    /** @var Country */
    private $country;
    /** @var double */
    private $latitude;
    /** @var double */
    private $longitude;
    
    /**
     *
     * @param string $code
     * @param string $name
     * @param Country $country
     * @param double $latitude
     * @param double $longitude 
     */
    public function __construct($code, $name, Country $country, $latitude, $longitude)
    {
        $this->code = $code;
        $this->name = $name;
        $this->country = $country;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     *
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}