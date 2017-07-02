<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class MonthlyTimesheetPeriod extends TimesheetPeriod {

    public function calculateDaysInTheTimesheetPeriod($currentDate, $xml) {

        $startDay = (String) $xml->StartDate;
        ;
        list($year, $month, $day) = explode("-", $currentDate);
        if ($startDay <= $day) {
            $start_of_month = mktime(00, 00, 00, $month, $startDay, $year);
            $end_of_month = mktime(23, 59, 59, $month + 1, $startDay, $year);
        } else {
            $start_of_month = mktime(00, 00, 00, $month - 1, $startDay, $year);
            $end_of_month = mktime(23, 59, 59, $month, $startDay, $year);
        }
        $startDate = date('Y-m-d', $start_of_month);
        $endDate = date('Y-m-d', $end_of_month);

        if ($startDate < $endDate) {
            $dates_range[] = $startDate;
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            while ($startDate != $endDate) {
                $startDate = mktime(0, 0, 0, date("m", $startDate), date("d", $startDate) + 1, date("Y", $startDate));
                $dates_range[] = date('Y-m-d', $startDate);
            }
        }
        array_pop($dates_range);
        return $dates_range;
    }

    public function setTimesheetPeriodAndStartDate($startDay) {

        return "<TimesheetPeriod><PeriodType>Monthly</PeriodType><ClassName>MonthlyTimesheetPeriod</ClassName><StartDate>" . $startDay . "</StartDate><Heading>Month</Heading></TimesheetPeriod>";
    }

    public function getDatesOfTheTimesheetPeriod($startDate, $endDate) {
        
         $userObj = sfContext::getInstance()->getUser()->getAttribute('user');
        $clientTimeZoneOffset = $userObj->getUserTimeZoneOffset();
        $serverTimezoneOffset = ((int) date('Z'));
        $timeStampDiff = $clientTimeZoneOffset * 3600 - $serverTimezoneOffset;
        
        

        if ($startDate < $endDate) {
            $dates_range[] = $startDate;
            
            $startDate = strtotime($startDate) + $timeStampDiff;
            $endDate = strtotime($endDate) + $timeStampDiff;
            while (date('Y-m-d', $startDate) != date('Y-m-d', $endDate)) {
                $startDate = mktime(0, 0, 0, date("m", $startDate), date("d", $startDate) + 1, date("Y", $startDate));
                $dates_range[] = date('Y-m-d', $startDate);
            }
        }
        return $dates_range;
    }

}

?>
