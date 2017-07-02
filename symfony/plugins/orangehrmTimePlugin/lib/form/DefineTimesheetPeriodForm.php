<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class DefineTimesheetPeriodForm extends sfForm {

    private $timesheetPeriodService;

    public function configure() {

        $dates = array('' => "-- " . __('Select') . " --", '1' => __('Monday'), '2' => __('Tuesday'), '3' => __('Wednesday'), '4' => __('Thursday'), '5' => __('Friday'), '6' => __('Saturday'), '7' => __('Sunday'));


        $this->setWidgets(array(
            'startingDays' => new sfWidgetFormSelect(array('choices' => $dates)),
        ));

        $this->widgetSchema->setNameFormat('time[%s]');

        $this->widgetSchema['startingDays']->setAttribute('style', 'width:150px');

        $this->setValidators(array(
            'startingDays' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($dates))),
        ));
    }

    public function save() {
        $startDay = $this->getValue('startingDays');
        $this->getTimesheetPeriodService()->setTimesheetPeriod($startDay);
    }

    public function getTimesheetPeriodService() {

        if (is_null($this->timesheetPeriodService)) {

            $this->timesheetPeriodService = new TimesheetPeriodService();
        }
        return $this->timesheetPeriodService;
    }

}

?>
