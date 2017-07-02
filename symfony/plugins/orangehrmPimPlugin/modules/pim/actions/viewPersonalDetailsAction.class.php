<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
/**
 * personalDetailsAction
 *
 */
class viewPersonalDetailsAction extends basePimAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }
    
    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        //$this->isLeavePeriodDefined();

        $personal = $request->getParameter('personal');
        $empNumber = (isset($personal['txtEmpID']))?$personal['txtEmpID']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        // TODO: Improve            
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        $this->personalInformationPermission = $this->getDataGroupPermissions('personal_information', $empNumber);
        $this->canEditSensitiveInformation = ($empNumber != $loggedInEmpNum) || $adminMode;


        $param = array('empNumber' => $empNumber, 
            'personalInformationPermission' => $this->personalInformationPermission,
            'canEditSensitiveInformation' => $this->canEditSensitiveInformation);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $this->showDeprecatedFields = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_DEPRECATED);
        $this->showSSN = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_SSN);
        $this->showSIN = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_PIM_SHOW_SIN);

        $this->setForm(new EmployeePersonalDetailsForm(array(), $param, true));

        if ($this->personalInformationPermission->canUpdate()){
            if ($request->isMethod('post')) {

                $this->form->bind($request->getParameter($this->form->getName()));
                if ($this->form->isValid()) {

                    $this->_checkWhetherEmployeeIdExists($this->form->getValue('txtEmployeeId'), $empNumber);

                    $employee = $this->form->getEmployee();
                    $this->getEmployeeService()->saveEmployee($employee);
                    $this->getUser()->setFlash('personaldetails.success', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);

                }
            }
        }
    }

//    private function isLeavePeriodDefined() {
//
//        $leavePeriodService = new LeavePeriodService();
//        $leavePeriodService->setLeavePeriodDao(new LeavePeriodDao());
//        $leavePeriod = $leavePeriodService->getCurrentLeavePeriodByDate(date("Y-m-d"));
//        $flag = 0;
//        
//        if(!empty($leavePeriod)) {
//            $flag = 1;
//        }
//
//        $_SESSION['leavePeriodDefined'] = $flag;
//    }

    protected function _checkWhetherEmployeeIdExists($employeeId, $empNumber) {

        if (!empty($employeeId)) {

            $employee = $this->getEmployeeService()->getEmployeeByEmployeeId($employeeId);

            if (($employee instanceof Employee) && trim($employee->getEmpNumber()) != trim($empNumber)) {
                $this->getUser()->setFlash('templateMessage', array('warning', __('Employee Id Exists')));
                $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
            }

        }

    }

}
