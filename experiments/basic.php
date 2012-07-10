<?php

$customerCode = 'Flightfox';
$password = '877*()yu';

$client = new SoapClient('http://stk.innovataw3svc.com/DataTimetableToolKitServices.asmx?WSDL');
$client->__setSoapHeaders(array(
    new SoapHeader('http://DataTimeTableToolKit.com/', 'WSAuthenticate', array(
		'CustomerRefCode' => $customerCode,
		'Password' => $password,
		'WebServicesRefCode' => 'TKS'
	))
));

$date = new DateTime();
$in = new stdClass();
$in->_sSchedulesSearchXML = sprintf('<GetSchedules_Input 
	customerCode="%s" productCode="external" 
	DD="%s" MM="%s" YYYY="%s" flightNumber="%s" carCode="%s" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:noNamespaceSchemaLocation="GetSchedules_Input.xsd" />', 
	$customerCode, $date->format('d'), $date->format('m'), 
	$date->format('Y'), '0010', 'BA');
$result = $client->GetSchedules($in);
echo print_r($result, true);
echo 'Done' . "\n";