<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class activateEmployementAction extends basePimAction {

    public function execute($request) {
        $empNumber = $request->getParameter('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $allowedActions = $this->getContext()->getUserRoleManager()->getAllowedActions(WorkflowStateMachine::FLOW_EMPLOYEE, $employee->getState());

        $allowActivate = isset($allowedActions[WorkflowStateMachine::EMPLOYEE_ACTION_REACTIVE]);;

        if ($allowActivate) {
            $form = new ActiveEmploymentForm(array(), array(), true) ;
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $this->getEmployeeService()->activateTerminatedEmployment($empNumber);
                $this->getUser()->setFlash('jobdetails.success', __(TopLevelMessages::UPDATE_SUCCESS));
                
            }
            $this->redirect('pim/viewJobDetails?empNumber=' . $empNumber);
        }
    }

}

