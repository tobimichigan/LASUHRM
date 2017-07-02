<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Formats date using current date format.
 *
 * @param Date $date in YYYY-MM-DD format
 * @return formatted date.
 */

function set_datepicker_date_format($date) {

    if (sfContext::hasInstance()) {
        $dateFormat = sfContext::getInstance()->getUser()->getDateFormat();
    } else{
        $configService = new ConfigService();
        $dateFormat = $configService->getAdminLocalizationDefaultDateFormat();
    }

    if (empty($date)) {
        $formattedDate = null;
    } else {
        $dateArray = explode('-', $date);
        $dateTime = new DateTime();
        $year = $dateArray[0];
        $month = $dateArray[1];
        $day = $dateArray[2];
        
        // For timestamp fields, clean time part from $day (day will look like "21 00:00:00"
        $day = trim($day);
        $spacePos = strpos($day, ' ');
        if ($spacePos !== FALSE) {
            $day = substr($day, 0, $spacePos);
        }
        
        $dateTime->setDate($year, $month, $day);
        $formattedDate = $dateTime->format($dateFormat);
    }

    return $formattedDate;
}

function get_datepicker_date_format($symfonyDateFormat) {
    $jsDateFormat = "";

    $len = strlen($symfonyDateFormat);

    for ($i = 0; $i < $len; $i++) {
        $char = $symfonyDateFormat{$i};
        switch ($char) {
            case 'j':
                $jsDateFormat .= 'd';
                break;
            case 'd':
                $jsDateFormat .= 'dd';
                break;
            case 'l':
                $jsDateFormat .= 'DD';
                break;
            case 'L':
                $jsDateFormat .= 'DD';
                break;
            case 'n':
                $jsDateFormat .= 'm';
                break;
            case 'm':
                $jsDateFormat .= 'mm';
                break;
            case 'F':
                $jsDateFormat .= 'MM';
                break;
            case 'Y':
                $jsDateFormat .= 'yy';
                break;
            default:
                $jsDateFormat .= $char;
                break;
        }
    }
    return($jsDateFormat);
}