<?php

namespace DHolmes\InnovataSTK;

use DateTime;

/**
 *
 * @author Creatio Pty Ltd
 */
interface InnovataSTKClient
{
    /**
     * @param DateTime $date
     * @param string $carrierCode
     * @param string $flightNumber
     * @return FlightResults
     */
    public function getSchedules(DateTime $date, $carrierCode, $flightNumber);
    
    
    /*1 => 'GetSchedulesContractedResponse GetSchedulesContracted(GetSchedulesContracted $parameters)',
      2 => 'GetStationListResponse GetStationList(GetStationList $parameters)',
      3 => 'GetCountryListResponse GetCountryList(GetCountryList $parameters)',
      4 => 'GetCountryDependencyResponse GetCountryDependency(GetCountryDependency $parameters)',
      5 => 'GetNextDirectsResponse GetNextDirects(GetNextDirects $parameters)',
      6 => 'GetStationsDependencyResponse GetStationsDependency(GetStationsDependency $parameters)',
      7 => 'GetNearestAirportsResponse GetNearestAirports(GetNearestAirports $parameters)',
      8 => 'GetSchedulesResponse GetSchedules(GetSchedules $parameters)',
      9 => 'GetSchedulesContractedResponse GetSchedulesContracted(GetSchedulesContracted $parameters)',
      10 => 'GetStationListResponse GetStationList(GetStationList $parameters)',
      11 => 'GetCountryListResponse GetCountryList(GetCountryList $parameters)',
      12 => 'GetCountryDependencyResponse GetCountryDependency(GetCountryDependency $parameters)',
      13 => 'GetNextDirectsResponse GetNextDirects(GetNextDirects $parameters)',
      14 => 'GetStationsDependencyResponse GetStationsDependency(GetStationsDependency $parameters)',
      15 => 'GetNearestAirportsResponse GetNearestAirports(GetNearestAirports $parameters)',*/
}