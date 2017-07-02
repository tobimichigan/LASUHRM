<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ProxyPunchInPunchOutForm extends AttendanceForm {

    private $attendanceService;

    public function getAttendanceService() {

        if (is_null($this->attendanceService)) {

            $this->attendanceService = new AttendanceService();
        }

        return $this->attendanceService;
    }

    public function setAttendanceService(AttendanceService $attendanceService) {

        $this->attendanceService = $attendanceService;
    }

    public function configure() {
        $timeZone = $this->getOption('timezone');
        $date = $this->getOption('date');

        $this->formWidgets['timezone'] = new sfWidgetFormSelect(array('choices' => $this->getTimezoneArray()), array('class' => 'timezone'));
        $this->setWidgets($this->formWidgets);


        $this->formValidators['timezone'] = new sfValidatorString(array(), array('required' => __('Enter timezone')));
        $this->setValidators($this->formValidators);

        $this->widgetSchema->setNameFormat('attendance[%s]');
        parent::configure();
        
        $index = array_keys($this->getAttendanceService()->getTimezoneArray(), $timeZone);
        $this->setDefault('timezone', $index[0]);
        $this->setDefault('date', set_datepicker_date_format($date));
        $this->getWidgetSchema()->setPositions(array('date', 'time', 'timezone', 'note'));
    }
    
    
     public function getTimezoneArray() {


        $this->timezoneArray[0] = '(GMT)';
        $this->timezoneArray[1] = '(GMT+01.00) '.__('Europe/Belgrade');
        $this->timezoneArray[2] = '(GMT+02.00) '.__('Europe/Minsk');
        $this->timezoneArray[3] = '(GMT+03.00) '.__('Asia/Kuwait');
        $this->timezoneArray[4] = '(GMT+04.00) '.__('Asia/Muscat');
        $this->timezoneArray[5] = '(GMT+05.00) '.__('Asia/Yekaterinburg');
        $this->timezoneArray[6] = '(GMT+05.50) '.__('Asia/Kolkata');
        $this->timezoneArray[7] = '(GMT+06.00) '.__('Asia/Dhaka');
        $this->timezoneArray[8] = '(GMT+07.00) '.__('Asia/Krasnoyarsk');
        $this->timezoneArray[9] = '(GMT+08.00) '.__('Asia/Brunei');
        $this->timezoneArray[10] = '(GMT+09.00) '.__('Asia/Seoul');
        $this->timezoneArray[11] = '(GMT+09.50) '.__('Australia/Darwin');
        $this->timezoneArray[12] = '(GMT+10.00) '.__('Australia/Canberra');
        $this->timezoneArray[13] = '(GMT+11.00) '.__('Asia/Magadan');
        $this->timezoneArray[14] = '(GMT+12.00) '.__('Pacific/Fiji');
        $this->timezoneArray[15] = '(GMT-11.00) '.__('Pacific/Midway');
        $this->timezoneArray[16] = '(GMT-10.00) '.__('Pacific/Honolulu');
        $this->timezoneArray[17] = '(GMT-09.00) '.__('America/Anchorage');
        $this->timezoneArray[18] = '(GMT-08.00) '.__('America/Los_Angeles');
        $this->timezoneArray[19] = '(GMT-07.00) '.__('America/Denver');
        $this->timezoneArray[20] = '(GMT-06.00) '.__('America/Tegucigalpa');
        $this->timezoneArray[21] = '(GMT-05.00) '.__('America/New_York');
        $this->timezoneArray[22] = '(GMT-04.00) '.__('America/Halifax');
        $this->timezoneArray[23] = '(GMT-03.50) '.__('America/St_Johns');
        $this->timezoneArray[24] = '(GMT-03.00) '.__('America/Argentina/Buenos_Aires');
        $this->timezoneArray[25] = '(GMT-02.00) '.__('Atlantic/South_Georgia');
        $this->timezoneArray[26] = '(GMT-01.00) '.__('Atlantic/Azores');
        
        return $this->timezoneArray;
    }

}

?>
