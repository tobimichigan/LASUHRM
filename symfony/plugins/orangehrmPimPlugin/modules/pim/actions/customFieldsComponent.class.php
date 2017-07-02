<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class customFieldsComponent extends sfComponent {

    private $employeeService;
    private $customFieldsService;

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
    
    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getCustomFieldsService() {
        if(is_null($this->customFieldsService)) {
            $this->customFieldsService = new CustomFieldConfigurationService();
        }
        return $this->customFieldsService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setCustomFieldsService(CustomFieldConfigurationService $customFieldsService) {
        $this->customFieldsService = $customFieldsService;
    }
    
    /**
     * Execute method of component
     * 
     * @param type $request 
     */
    public function execute($request) {       

        $this->customFieldsMessageType = '';
        $this->customFieldsMessage = '';
        
         $this->permission = $this->getDataGroupPermissions($this->screen . '_custom_fields', $this->empNumber);
        
        if ($this->getUser()->hasFlash('customFieldsMessage')) {  
            list($this->customFieldsMessageType, $this->customFieldsMessage) = $this->getUser()->getFlash('customFieldsMessage');
            $this->getUser()->setFlash($this->customFieldsMessageType, $this->customFieldsMessage);
        }
        
        $this->employee = $this->getEmployeeService()->getEmployee($this->empNumber);
        $this->customFieldList = $this->getCustomFieldsService()->getCustomFieldList($this->screen);          
        $this->form = new EmployeeCustomFieldsForm(array(),  array('customFields'=>$this->customFieldList), true);  
    }
    
    
    protected function getDataGroupPermissions($dataGroups, $empNumber) { 
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

        $entities = array('Employee' => $empNumber);
        
        $self = $empNumber == $loggedInEmpNum;

        return $this->getContext()->getUserRoleManager()->getDataGroupPermissions($dataGroups, array(), array(), $self, $entities);


    }
}

