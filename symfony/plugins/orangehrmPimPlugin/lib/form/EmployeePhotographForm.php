<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmployeePhotographForm extends BaseForm {
    
    public $fullName;
    private $employeeService;
    private $widgets = array();

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
        $this->photographPermissions = $this->getOption('photographPermissions');

        $empNumber = $this->getOption('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $this->fullName = $employee->getFullName();

        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => true)));
        
        if ($this->photographPermissions->canRead()) {

            $photographWidgets = $this->getPhotographWidgets();
            $photographValidators = $this->getPhotographValidators();

            if (!($this->photographPermissions->canUpdate()) ) {
                foreach ($photographWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $photographWidgets);
            $validators = array_merge($validators, $photographValidators);
        }
        $this->setWidgets($widgets);
        $this->setValidators($validators);
        
    }
    
    /**
     * Get form widgets
     * @return \sfWidgetFormInputFileEditable 
     */
    private function getPhotographWidgets() {
        $widgets = array(
            'photofile' => new sfWidgetFormInputFileEditable(array(
	            'edit_mode'=>false,
	            'with_delete' => false,
	            'file_src' => '')));
        return $widgets;
    }
    
    /**
     * Get validators
     * @return \sfValidatorFile 
     */
    private function getPhotographValidators() {
        $validators = array(
            'photofile' =>  new sfValidatorFile(
	        array(
	            'max_size' => 1000000,
	            'required' => true,
	        ))
        );
        return $validators;
    }
}
?>
