<?php

namespace DHolmes\InnovataSTK\Model;

class Equipment
{
    /** @var string */
    private $code;
    /** @var string */
    private $class;
    /** @var string */
    private $description;
    /** @var string */
    private $aircraftType;
    /** @var boolean */
    private $isWidebody;
    
    /**
     * @param string $code
     * @param string $class
     * @param string $description
     * @param string $aircraftType
     * @param boolean $isWidebody 
     */
    public function __construct($code, $class, $description, $aircraftType, $isWidebody)
    {
        $this->code = $code;
        $this->class = $class;
        $this->description = $description;
        $this->aircraftType = $aircraftType;
        $this->isWidebody = $isWidebody;
    }
    
    /** @return string */
    public function getCode()
    {
        return $this->code;
    }

    /** @return string */
    public function getClass()
    {
        return $this->class;
    }

    /** @return string */
    public function getDescription()
    {
        return $this->description;
    }

    /** @return string */
    public function getAircraftType()
    {
        return $this->aircraftType;
    }

    /** @return boolean */
    public function getIsWidebody()
    {
        return $this->isWidebody;
    }
}