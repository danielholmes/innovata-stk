<?php

namespace DHolmes\InnovataSTK\Soap;

use SoapClient as NativeSoapClient;
use SoapHeader as NativeSoapHeader;

/**
 *
 * @author Creatio Pty Ltd
 */
class NativeSoapClientAdapter implements SoapClient
{
    /** @var NativeSoapClient */
    private $nativeClient;
    
    /**
     *
     * @param NativeSoapClient $nativeClient 
     */
    public function __construct(NativeSoapClient $nativeClient)
    {
        $this->nativeClient = $nativeClient;
    }
    
    /**
     *
     * @param string $name
     * @param array $args 
     */
    public function makeCall($name, array $args)
    {
        $this->nativeClient->__soapCall($name, $args);
    }
    
    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $nativeHeaders = array_map(function(SoapHeader $header)
        {
            return new NativeSoapHeader($header->uri, $header->name, $header->data, true);
        }, $headers);
        $this->nativeClient->__setSoapHeaders($nativeHeaders);
    }
}