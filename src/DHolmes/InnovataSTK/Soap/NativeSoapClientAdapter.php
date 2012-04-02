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
    /** @var array */
    private $headers;
    
    /**
     *
     * @param string $wsdlUrl
     */
    public function __construct($wsdlUrl)
    {
        $this->wsdlUrl = $wsdlUrl;
        $this->headers = array();
    }
    
    /**
     *
     * @return NativeSoapClient 
     */
    private function getNativeClient()
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
            $this->tryToApplyHeaders();
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
        $this->headers = array_map(function(SoapHeader $header)
        {
            return new NativeSoapHeader($header->uri, $header->name, $header->data, true);
        }, $headers);
        $this->tryToApplyHeaders();
    }
    
    /**
     * 
     */
    private function tryToApplyHeaders()
    {
        if ($this->nativeClient !== null)
        {
            $this->nativeClient->__setSoapHeaders($this->headers);
        }
    }
}