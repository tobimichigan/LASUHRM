<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class undeleteLeaveTypeAction extends orangehrmAction {

    protected $leaveTypeService;
    
    public function execute($request) {
        $this->form = $this->getForm();

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $undeleteId = $this->form->getValue('undeleteId');
                
                $this->undeleteLeaveType($undeleteId);
            } else {
                // Since this form does not have any user data entry fields,
                // this is a error.
                $this->getLoggerInstance()->error($this->form);
            }
        }
        $this->redirect("leave/leaveTypeList");        
    }



    protected function undeleteLeaveType($leaveTypeId) {
        $leaveTypeService = $this->getLeaveTypeService();
        $leaveTypeService->undeleteLeaveType($leaveTypeId);

        $leaveType = $leaveTypeService->readLeaveType($leaveTypeId);
        $leaveTypeName = $leaveType->getName();
        
        $message = __('Successfully Undeleted');
        $this->getUser()->setFlash('success', $message);
    }


    protected function getForm() {
        $form = new UndeleteLeaveTypeForm(array(), array(), true);
        return $form;
    }

    protected function getLeaveTypeService() {

        if (is_null($this->leaveTypeService)) {
            $this->leaveTypeService = new LeaveTypeService();
        }

        return $this->leaveTypeService;
    }
    
    /**
     * Get Logger instance. Creates if not already created.
     *
     * @return Logger
     */
    protected function getLoggerInstance() {
        if (is_null($this->logger)) {
            $this->logger = Logger::getLogger('leave.undeleteLeaveTypeAction');
        }

        return($this->logger);
    }    

}
