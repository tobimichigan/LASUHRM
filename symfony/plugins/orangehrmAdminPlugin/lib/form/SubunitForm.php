<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class SubunitForm extends sfForm {

    protected $companyStructureService;

    /**
     *
     * @return EmployeeService 
     */
    public function getCompanyStructureService() {
        if (!($this->companyStructureService instanceof CompanyStructureService)) {
            $this->companyStructureService = new CompanyStructureService();
        }
        return $this->companyStructureService;
    }
    /**
     *
     * @param EmployeeService $employeeService 
     */
    public function setCompanyStructureService(CompanyStructureService $companyStructureService) {
        $this->companyStructureService = $companyStructureService;
    }
    
    public function configure() {
        $this->setWidgets(array(
            'hdnId' => new sfWidgetFormInputHidden(),
            'hdnParent' => new sfWidgetFormInputHidden(),
            'txtUnit_Id' => new sfWidgetFormInputText(),
            'txtName' => new sfWidgetFormInputText(),
            'txtDescription' => new sfWidgetFormTextArea(array(), array('rows' => 5, 'cols' => 20)),
        ));
        
        $this->setValidators(array(
            'hdnId' => new sfValidatorString(array('required' => TRUE, 'max_length' => 255)),
            'hdnParent' => new sfValidatorString(array('required' => TRUE, 'max_length' => 255)),
            'txtUnit_Id' => new sfValidatorString(array('required' => FALSE, 'max_length' => 255)),
            'txtName' => new sfValidatorString(array('required' => TRUE, 'max_length' => 255)),
            'txtDescription' => new sfValidatorString(array('required' => FALSE, 'max_length' => 400)),
        ));
        
        $required = '<span class="required new"> * </span>';
        $this->widgetSchema->setLabels(array(
            'txtUnit_Id' => __('Unit Id'),
            'txtName' => __('Name') . $required,
            'txtDescription' => __('Description'),
        ));
        
       // $this->widgetSchema->setNameFormat('companyStructure[%s]');
    }

    

}