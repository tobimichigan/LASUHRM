<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmployeeSkillForm extends sfForm {
    
    private $employeeService;
    public $fullName;
    private $widgets = array();
    public $empSkillList;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if(is_null($this->employeeService)) {
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
        $this->skillPermissions = $this->getOption('skillPermissions');
        
        $empNumber = $this->getOption('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $this->fullName = $employee->getFullName();

        $this->empSkillList = $this->getEmployeeService()->getEmployeeSkills($empNumber);

        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => false)));
        
        if ($this->skillPermissions->canRead()) {

            $skillsWidgets = $this->getSkillsWidgets();
            $skillsValidators = $this->getSkillsValidators();

            if (!($this->skillPermissions->canUpdate() || $this->skillPermissions->canCreate()) ) {
                foreach ($skillsWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $skillsWidgets);
            $validators = array_merge($validators, $skillsValidators);
        }

        $this->setWidgets($widgets);
        $this->setValidators($validators);


        $this->widgetSchema->setNameFormat('skill[%s]');
    }
    
    
    /*
     * Tis fuction will return the widgets of the form
     */
    public function getSkillsWidgets() {
        $widgets = array();

        //creating widgets
        $widgets['code'] = new sfWidgetFormSelect(array('choices' => $this->_getSkillList()));
        $widgets['years_of_exp'] = new sfWidgetFormInputText();
        $widgets['comments'] = new sfWidgetFormTextarea();

        return $widgets;
    }

    /*
     * Tis fuction will return the form validators
     */
    public function getSkillsValidators() {
        
        $validators = array(
            'code' => new sfValidatorString(array('required' => true, 'max_length' => 13)),
            'years_of_exp' => new sfValidatorNumber(array('required' => false)),
            'comments' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
        );

        return $validators;
    }

    private function _getSkillList() {
        $skillService = new SkillService();
        $skillList = $skillService->getSkillList();
        $list = array("" => "-- " . __('Select') . " --");

        foreach($skillList as $skill) {
            $list[$skill->getId()] = $skill->getName();
        }
        
        // Clear already used skill items
        foreach ($this->empSkillList as $empSkill) {
            if (isset($list[$empSkill->skillId])) {
                unset($list[$empSkill->skillId]);
            }
        }
        return $list;
    }
}
?>