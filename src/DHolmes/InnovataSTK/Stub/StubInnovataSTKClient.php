<?php

namespace DHolmes\InnovataSTK\Stub;

use DateTime;
use DHolmes\InnovataSTK\InnovataSTKClient;
use DHolmes\InnovataSTK\Model\Results\FlightResults;

/**
 *
 * @author Creatio Pty Ltd
 */
class StubInnovataSTKClient implements InnovataSTKClient
{
    /** @var array */
    private $fixedResponsesByCallName;
    
    /**
     *
     */
    public function __construct()
    {
        $this->fixedResponsesByCallName = array();
    }
    
    /**
     *
     * @param array $fixedResponsesByCallName 
     */
    public function setFixedResponsesByCallName(array $fixedResponsesByCallName)
    {
        $this->fixedResponsesByCallName = $fixedResponsesByCallName;
    }
    
    /**
     * @param DateTime $date
     * @param string $carrierCode
     * @param string $flightNumber
     * @return FlightResults
     */
    public function getSchedules(DateTime $date, $carrierCode, $flightNumber)
    {
        return $this->getFixedResponseForCall('getSchedules', func_get_args());
    }
    
    /**
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    private function getFixedResponseForCall($name, array $args = array())
    {
        $response = null;
        if (isset($this->fixedResponsesByCallName[$name]))
        {
            $response = $this->fixedResponsesByCallName[$name];
        }
        
        return $response;
    }
}