<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class WorkExperienceForm extends sfForm {

    private $employeeService;
    public $fullName;
    public $workExperiences;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }

    public function configure() {
        $this->workExperiencePermissions = $this->getOption('workExperiencePermissions');

        $empNumber = $this->getOption('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $this->fullName = $employee->getFullName();
        
        
        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => false)));
        
        if ($this->workExperiencePermissions->canRead()) {

            $workExperienceWidgets = $this->getWorkExperienceWidgets();
            $workExperienceValidators = $this->getWorkExperienceValidators();

            if (!($this->workExperiencePermissions->canUpdate() || $this->workExperiencePermissions->canCreate()) ) {
                foreach ($workExperienceWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $workExperienceWidgets);
            $validators = array_merge($validators, $workExperienceValidators);
        }

        $this->setWidgets($widgets);
        $this->setValidators($validators);

        $this->workExperiences = $this->getEmployeeService()->getEmployeeWorkExperienceRecords($empNumber);
        $this->widgetSchema->setNameFormat('experience[%s]');
    }

    /*
     * Tis fuction will return the widgets of the form
     */

    public function getWorkExperienceWidgets() {
        $widgets = array();

        //creating widgets
        $widgets['seqno'] = new sfWidgetFormInputHidden();
        $widgets['employer'] = new sfWidgetFormInputText();
        $widgets['jobtitle'] = new sfWidgetFormInputText();
        $widgets['from_date'] = new ohrmWidgetDatePicker(array(), array('id' => 'experience_from_date'));
        $widgets['to_date'] = new ohrmWidgetDatePicker(array(), array('id' => 'experience_to_date'));
        $widgets['comments'] = new sfWidgetFormTextarea();

        return $widgets;
    }

    /*
     * Tis fuction will return the form validators
     */

    public function getWorkExperienceValidators() {
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();

        $validators = array(
            'seqno' => new sfValidatorString(array('required' => false)),
            'employer' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
            'jobtitle' => new sfValidatorString(array('required' => true, 'max_length' => 120)),
            'relationship' => new sfValidatorString(array('required' => false, 'trim' => true, 'max_length' => 100)),
            'from_date' => new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => false), array('required' => 'Date field is required', 'invalid' => 'Date format should be ' . $inputDatePattern)),
            'to_date' => new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => false), array('required' => 'Date field is required', 'invalid' => 'Date format should be ' . $inputDatePattern)),
            'comments' => new sfValidatorString(array('required' => false, 'max_length' => 200)),
        );

        return $validators;
    }

}

?>