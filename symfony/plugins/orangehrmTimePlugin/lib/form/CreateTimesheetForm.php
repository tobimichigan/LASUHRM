<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CreateTimesheetForm extends sfForm {

    public $formWidgets = array();
    public $formValidators = array();

    public function configure() {

        $this->formWidgets['date'] = new ohrmWidgetDatePicker(array(), array('id' => 'time_date'));

        $this->setWidgets($this->formWidgets);
        
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();
        $this->formValidators['date'] = new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => false), array('invalid' => "Date format should be $inputDatePattern"));
        $this->widgetSchema->setNameFormat('time[%s]');

        $this->setValidators($this->formValidators);
    }

}
