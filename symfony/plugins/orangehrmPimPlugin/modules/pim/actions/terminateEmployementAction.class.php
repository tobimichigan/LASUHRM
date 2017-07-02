<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class terminateEmployementAction extends basePimAction {

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        $empNumber = $request->getParameter('empNumber');
        $terminatedId = $request->getParameter('terminatedId');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        
        $allowedActions = $this->getContext()->getUserRoleManager()->getAllowedActions(WorkflowStateMachine::FLOW_EMPLOYEE, $employee->getState());
        
        $this->allowActivate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_REACTIVE]);
        $this->allowTerminate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_TERMINATE]);

        $paramForTerminationForm = array('empNumber' => $empNumber, 
                                                                 'employee' => $employee, 
                                                                 'allowTerminate' => $this->allowTerminate,
                                                                 'allowActivate' => $this->allowActivate);
        

        $this->form = new EmployeeTerminateForm(array(), $paramForTerminationForm, true);

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        
        if (!$this->isAllowedAdminOnlyActions($loggedInEmpNum, $empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        if ($this->getRequest()->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->terminateEmployement($empNumber, $terminatedId);
                $this->getUser()->setFlash('jobdetails.success', __(TopLevelMessages::UPDATE_SUCCESS));
            }

            $this->redirect('pim/viewJobDetails?empNumber=' . $empNumber);
        }
    }

}

