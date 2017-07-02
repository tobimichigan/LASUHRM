<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * ViewJobDetailsAction
 */
class viewJobDetailsAction extends basePimAction {

    public function execute($request) {
        
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $job = $request->getParameter('job');
        $empNumber = (isset($job['emp_number'])) ? $job['emp_number'] : $request->getParameter('empNumber');
        
        $this->activeEmploymentForm = new ActiveEmploymentForm( array(),array(),true);
        /*
         * TODO: $empNumber gets empty when uploaded file size exceeds PHP max upload size.
         * Check for a better solution.
         */
        if (empty($empNumber)) {
            $this->getUser()->setFlash('jobdetails.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            $this->redirect($request->getReferer());
        }
        
        $this->empNumber = $empNumber;
        
        $this->jobInformationPermission = $this->getDataGroupPermissions('job_details', $empNumber);
        $this->ownRecords = ($loggedInEmpNum == $empNumber) ? true : false;


        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $param = array('empNumber' => $empNumber, 'ESS' => $this->essMode,
            'employee' => $employee,
            'loggedInUser' => $loggedInEmpNum,
            'loggedInUserName' => $loggedInUserName);
        
        $joinedDate = $employee->getJoinedDate();

        $this->form = new EmployeeJobDetailsForm(array(), $param, true);
        $this->employeeState = $employee->getState();
        
        if ($loggedInEmpNum == $empNumber) {
            $this->allowActivate = FALSE;
            $this->allowTerminate = FALSE;
        } else {
            $allowedActions = $this->getContext()->getUserRoleManager()->getAllowedActions(WorkflowStateMachine::FLOW_EMPLOYEE, $this->employeeState);
            $this->allowActivate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_REACTIVE]);
            $this->allowTerminate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_TERMINATE]);            
        }
        
        $paramForTerminationForm = array('empNumber' => $empNumber,
            'employee' => $employee,
            'allowTerminate' => $this->allowTerminate,
            'allowActivate' => $this->allowActivate);

        $this->employeeTerminateForm = new EmployeeTerminateForm(array(), $paramForTerminationForm, true);

        if ($this->getRequest()->isMethod('post')) {


            // Handle the form submission           
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

            if ($this->form->isValid()) {

                // save data
                if ($this->jobInformationPermission->canUpdate()) {
                    $service = new EmployeeService();
                    $service->saveEmployee($this->form->getEmployee(), false);
                   
                    if( $this->form->getIsJoinDateChanged()){
                      
                        $this->dispatcher->notify(new sfEvent($this, EmployeeEvents::JOINED_DATE_CHANGED,
                                array('employee' => $this->form->getEmployee(),'previous_joined_date'=> $joinedDate)));

                    }
                }

                $this->form->updateAttachment();


                $this->getUser()->setFlash('jobdetails.success', __(TopLevelMessages::UPDATE_SUCCESS));
            } else {
                $validationMsg = '';
                foreach ($this->form->getWidgetSchema()->getPositions() as $widgetName) {
                    if ($this->form[$widgetName]->hasError()) {
                        $validationMsg .= $this->form[$widgetName]->getError()->getMessageFormat();
                    }
                }

                $this->getUser()->setFlash('jobdetails.warning', $validationMsg);
            }

            $this->redirect('pim/viewJobDetails?empNumber=' . $empNumber);
        }
    }

}
