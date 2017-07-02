<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class attachmentsComponent extends sfComponent {

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
    
    /**
     * Execute method of component
     * 
     * @param type $request 
     */
    public function execute($request) {       

        $this->attEditPane = false;
        $this->attSeqNO = false;
        $this->attComments = '';
        $this->scrollToAttachments = false;
        
        $this->permission = $this->getDataGroupPermissions($this->screen . '_attachment', $this->empNumber);        

        if ($this->getUser()->hasFlash('attachmentMessage')) {  
            
            $this->scrollToAttachments = true;
            
            list($this->attachmentMessageType, $this->attachmentMessage) = $this->getUser()->getFlash('attachmentMessage');
                       
            if ($this->attachmentMessageType == 'warning') {
                $this->attEditPane = true;
                if ( $this->getUser()->hasFlash('attachmentComments') ) {
                    $this->attComments = $this->getUser()->getFlash('attachmentComments');
                }
                
                if ( $this->getUser()->hasFlash('attachmentSeqNo')) {
                    $tmpNo = $this->getUser()->getFlash('attachmentSeqNo');
                    $tmpNo = trim($tmpNo);
                    if (!empty($tmpNo)) {
                        $this->attSeqNO = $tmpNo;
                    }
                }
            }
        } else {
            $this->attachmentMessageType = '';
            $this->attachmentMessage = '';
        }

        
        $this->employee = $this->getEmployeeService()->getEmployee($this->empNumber);
        $this->attachmentList = $this->getEmployeeService()->getEmployeeAttachments($this->empNumber, $this->screen);          
        $this->form = new EmployeeAttachmentForm(array(),  array(), true);  
        $this->deleteForm = new EmployeeAttachmentDeleteForm(array(), array(), true);
    }

    protected function getDataGroupPermissions($dataGroups, $empNumber) { 
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        
        $entities = array('Employee' => $empNumber);
        
        $self = $empNumber == $loggedInEmpNum;
        
         return $this->getContext()->getUserRoleManager()->getDataGroupPermissions($dataGroups, array(), array(), $self, $entities);
    }
}

