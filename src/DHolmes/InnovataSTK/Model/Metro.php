<?php

namespace DHolmes\InnovataSTK\Model;

class Metro
{
    /** @var string */
    private $code;
    /** @var string */
    private $name;
    
    /**
     * @param string $code
     * @param string $name 
     */
    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
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
}