Innovata STK Web Service Client
===============================
This library provides a client to the Innovata STK (Standard Tool-kit) Web Service. It is SOAP based
and its description can be found here:

* http://stk.innovataw3svc.com/
* http://stk.innovataw3svc.com/DataTimetableToolKitServices.asmx?WSDL


Example Usage
-------------
```php
$client = \DHolmes\InnovataSTK\InnovataSTKClientFactory::createClient('customerCode', 'password');
$flightResults = $client->getSchedules(new \DateTime('+5 days'), 'BA', '0010');
```

Dependencies
------------

 * PHP 5.3+
 * PHP open ssl extension
 * PHP Soap extension (optional if provide own Soap Client)
 * PHPUnit 3.5+
 * Ant 1.7+ or Phing (optional)


Running Tests
-------------

Run `phpunit -c tests`