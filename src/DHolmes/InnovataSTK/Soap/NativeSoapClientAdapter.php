<?php

namespace DHolmes\InnovataSTK\Soap;

use Exception;
use RuntimeException;
use SoapClient as NativeSoapClient;
use SoapHeader as NativeSoapHeader;

/**
 *
 * @author Creatio Pty Ltd
 */
class NativeSoapClientAdapter implements SoapClient
{
    /** @var string */
    private $wsdlUrl;
    /** @var NativeSoapClient */
    private $nativeClient;
    
    /**
     *
     * @param string $wsdlUrl
     */
    public function __construct($wsdlUrl)
    {
        $this->wsdlUrl = $wsdlUrl;
    }
    
    /**
     *
     * @return NativeSoapClient 
     */
    public function getNativeClient()
    {
        if ($this->nativeClient === null)
        {
            try
            {
                $this->nativeClient = @new NativeSoapClient($this->wsdlUrl);
            }
            catch (Exception $e)
            {
                $message = sprintf('Error loading WSDL: %s', $this->wsdlUrl);
                throw new RuntimeException($message, 0, $e);
            }
        }
        return $this->nativeClient;
    }
    
    /**
     *
     * @param string $name
     * @param array $args 
     */
    public function makeCall($name, array $args = array())
    {
        $this->getNativeClient()->__soapCall($name, $args);
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
        $this->getNativeClient()->__setSoapHeaders($nativeHeaders);
    }
}