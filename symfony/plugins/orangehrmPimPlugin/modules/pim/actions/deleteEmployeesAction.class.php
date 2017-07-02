<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * delete employees list action
 */
class deleteEmployeesAction extends basePimAction {

    /**
     * Delete action. Deletes the employees with the given ids
     */
    public function execute($request) {
        
        $allowedToDeleteActive = $this->getContext()->getUserRoleManager()->isActionAllowed(PluginWorkflowStateMachine::FLOW_EMPLOYEE, 
                Employee::STATE_ACTIVE, PluginWorkflowStateMachine::EMPLOYEE_ACTION_DELETE_ACTIVE);
        $allowedToDeleteTerminated = $this->getContext()->getUserRoleManager()->isActionAllowed(PluginWorkflowStateMachine::FLOW_EMPLOYEE, 
                Employee::STATE_TERMINATED, PluginWorkflowStateMachine::EMPLOYEE_ACTION_DELETE_TERMINATED);
        

        if ($allowedToDeleteActive || $allowedToDeleteTerminated) {
            $form = new DefaultListForm(array(), array(), true) ;
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $ids = $request->getParameter('chkSelectRow');

                $userRoleManager = $this->getContext()->getUserRoleManager();
                if (!$userRoleManager->areEntitiesAccessible('Employee', $ids)) {
                    $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
                }

                $this->_checkLastAdminDeletion($ids);

                $employeeService = $this->getEmployeeService();               
                $count = $employeeService->deleteEmployees($ids);

                if ($count == count($ids)) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('failure', __('A Problem Occured When Deleting The Selected Employees'));
                }
            }
                $this->redirect('pim/viewEmployeeList');
        } else {
            $this->getUser()->setFlash('warning', __('Contact Admin for delete Credentials'));
            $this->redirect('pim/viewEmployeeList');
        }
    }
    
    /**
     * Restricts deleting employees when there is only one admin
     * and the admin is assigned to an employee to be deleted
     */
    protected function _checkLastAdminDeletion($empNumbers) {
        
        $searchClues['userType']    = SystemUser::ADMIN_USER_ROLE_ID;
        $searchClues['status']      = SystemUser::ENABLED;
        
        $systemUserService  = new SystemUserService();        
        $adminUsers         = $systemUserService->searchSystemUsers($searchClues);
        $adminEmpNumbers    = array();
        $defaultAdminExists = false;
        
        foreach ($adminUsers as $adminUser) {
            
            $adminEmpNumber = $adminUser->getEmployee()->getEmpNumber();
            
            if (!empty($adminEmpNumber)) {
                $adminEmpNumbers[] = $adminEmpNumber;
            } else {
                $defaultAdminExists = true;
            }
            
        }
        
        if ($defaultAdminExists) {
            return;
        }        
        
        $adminUserDiff = array_diff($adminEmpNumbers, $empNumbers);
        
        if (empty($adminUserDiff)) {
            
            $this->getUser()->setFlash('templateMessage', array('failure', __('Failed to Delete: At Least One Admin Should Exist')));
            $this->redirect('pim/viewEmployeeList');            
            
        }
        
    }

}
