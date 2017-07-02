<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EditAttendanceRecordRowForm extends sfForm {
    
     private $attendanceService;

    public function configure() {
        $this->setWidgets(array(
            'punchIn' => new sfWidgetFormInputText(array(), array()),
            'inNote' => new sfWidgetFormInputText(array(), array()),
            'punchOut' => new sfWidgetFormInputText(array(), array()),
            'outNote' => new sfWidgetFormInputText(array(), array()),
        ));


        $this->widgetSchema->setNameFormat('attendance[%s]');

        $this->setValidators(array(
            'punchIn' => new sfValidatorDateTime(array(), array('required' => __('Enter Punch In Time'))),
            'inNote' => new sfValidatorDateTime(),
            'punchOut' => new sfValidatorDateTime(array('required' => __('Enter Punch Out Time'))),
            'outNote' => new sfValidatorString(),
        ));
    }
    
       /**
     * Get the Timesheet Data Access Object
     * @return AttendanceService
     */
    public function getAttendanceService() {

        if (is_null($this->attendanceService)) {
            $this->attendanceService = new AttendanceService();
        }

        return $this->attendanceService;
    }

    /**
     * Set TimesheetData Access Object
     * @param AttendanceService $TimesheetDao
     * @return void
     */
    public function setTimesheetDao(AttendanceService $attendanceService) {

        $this->attendanceService = $attendanceService;
    }


}

