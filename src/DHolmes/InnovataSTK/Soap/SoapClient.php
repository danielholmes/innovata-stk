<?php

namespace DHolmes\InnovataSTK\Soap;

/**
 *
 * @author Creatio Pty Ltd
 */
interface SoapClient
{
    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function makeCall($name, array $args = array());
    
    /**
     * @param array $headers
     */
    public function setHeaders(array $headers);
}