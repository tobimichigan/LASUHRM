<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewUsTaxExemptionsAction extends basePimAction {

    private $employeeService;

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

    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

        $tax = $request->getParameter('tax');
        $empNumber = (isset($tax['empNumber']))?$tax['empNumber']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        $this->taxExemptionPermission = $this->getDataGroupPermissions('tax_exemptions', $empNumber);
        
        $this->essUserMode = !$this->isAllowedAdminOnlyActions($loggedInEmpNum, $empNumber);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $param = array('empNumber' => $empNumber, 'taxExemptionPermission' => $this->taxExemptionPermission);
        $this->form = new EmployeeUsTaxExemptionsForm(array(), $param, true);

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        if ($this->taxExemptionPermission->canUpdate()){
            
            if ($request->isMethod('post')) {
                
                $this->form->bind($request->getParameter($this->form->getName()));
                if ($this->form->isValid()) {
                    $empUsTaxExemption = $this->form->getEmpUsTaxExemption();
                    $this->getEmployeeService()->saveEmployeeTaxExemptions($empUsTaxExemption, false);
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('pim/viewUsTaxExemptions?empNumber='. $empUsTaxExemption->getEmpNumber());
                }
            }
        }
    }

}

