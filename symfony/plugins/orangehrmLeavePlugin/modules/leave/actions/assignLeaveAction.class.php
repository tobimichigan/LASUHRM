<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Action used to assign Leave to an Employee
 */
class assignLeaveAction extends baseLeaveAction {

    protected $leaveAssignmentService;
    protected $leaveRequestService;

    /**
     * Get leave assignment service instance
     * 
     * @return LeaveAssignmentService
     */
    public function getLeaveAssignmentService() {
        if (!($this->leaveAssignmentService instanceof LeaveAssignmentService)) {
            $this->leaveAssignmentService = new LeaveAssignmentService();
        }
        return $this->leaveAssignmentService;
    }

    /**
     * Set leave assignmente service instance
     * @param LeaveAssignmentService $service 
     */
    public function setLeaveAssignmentService(LeaveAssignmentService $service) {
        $this->leaveAssignmentService = $service;
    }
    
    /**
     *
     * @return LeaveRequestService
     */
    public function getLeaveRequestService() {
        if (!($this->leaveRequestService instanceof LeaveRequestService)) {
            $this->leaveRequestService = new LeaveRequestService();
        }
        return $this->leaveRequestService;
    }

    /**
     *
     * @param LeaveRequestService $service 
     */
    public function setLeaveRequestService(LeaveRequestService $service) {
        $this->leaveRequestService = $service;
    }
    
    public function execute($request) {

        $this->getLeaveRequestService()->markApprovedLeaveAsTaken();
        
        $this->leaveTypes = $this->getElegibleLeaveTypes();
        
        if (count($this->leaveTypes) == 0) {
            $this->getUser()->setFlash('warning.nofade', __('No Leave Types with Leave Balance'));
        }
        
        $this->form = $this->getAssignLeaveForm($this->leaveTypes);        
        $this->overlapLeave = 0;
        $this->workshiftLengthExceeded = false;

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                try {
                    $leaveParameters = $this->getLeaveParameterObject($this->form->getValues());
                    $success = $this->getLeaveAssignmentService()->assignLeave($leaveParameters);
                    
                    if ($success) {
                        $this->getUser()->setFlash('success', __('Successfully Assigned'));
                    } else {
                        $this->overlapLeave = $this->getLeaveAssignmentService()->getOverlapLeave();
                        $this->getUser()->setFlash('warning', __('Failed to Assign'));
                    }
                } catch (LeaveAllocationServiceException $e) {
                    $this->getUser()->setFlash('warning', __($e->getMessage()));
                    $this->overlapLeave = $this->getLeaveAssignmentService()->getOverlapLeave();
                    $this->workshiftLengthExceeded = true;
                }
            }
        }
    }
    
    /**
     * @todo Move to form?
     * @param array $formValues
     * @return LeaveParameterObject
     */
    protected function getLeaveParameterObject(array $formValues) {
        $empData = $formValues['txtEmployee'];
        $formValues['txtEmpID'] = $empData['empId'];
        
        $time = $formValues['time'];
        $formValues['txtFromTime'] = $time['from'];
        $formValues['txtToTime'] = $time['to'];
        
        return new LeaveParameterObject($formValues);
    }
    
    /**
     * Retrieve List of Eligible Leave Types
     * @return Array of leave type objects
     */
    protected function getElegibleLeaveTypes() {
        $leaveTypeList = $this->getLeaveTypeService()->getLeaveTypeList();
        return $leaveTypeList;
    }

    /**
     * Get the Assign leave form.
     */
    protected function getAssignLeaveForm($leaveTypes) {

        $leaveFormOptions = array('leaveTypes' => $leaveTypes);
        $form = new AssignLeaveForm(array(), $leaveFormOptions, true);

        return $form;
    }

}
