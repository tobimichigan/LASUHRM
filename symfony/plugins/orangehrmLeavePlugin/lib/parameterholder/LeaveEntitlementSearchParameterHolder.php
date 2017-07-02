<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Parameter holder for leave entitlement search
 */
class LeaveEntitlementSearchParameterHolder extends SearchParameterHolder {
    protected $empNumber;    
    protected $leaveTypeId;    
    protected $fromDate;
    protected $toDate;
    protected $validDate ;
    protected $deletedFlag = false;
    protected $idList = array();
    protected $empIdList = array();
    protected $hydrationMode = null;
    
    public function getHydrationMode() {
        return $this->hydrationMode;
    }

    public function setHydrationMode($hydrationMode) {
        $this->hydrationMode = $hydrationMode;
    }

        
    public function getEmpIdList() {
        return $this->empIdList;
    }

    public function setEmpIdList($empIdList) {
        $this->empIdList = $empIdList;
    }

    
    public function __construct() {
        $this->orderField = 'from_date';
    }

    public function getEmpNumber() {
        return $this->empNumber;
    }

    public function setEmpNumber($empNumber) {
        $this->empNumber = $empNumber;
    }

    public function getLeaveTypeId() {
        return $this->leaveTypeId;
    }

    public function setLeaveTypeId($leaveTypeId) {
        $this->leaveTypeId = $leaveTypeId;
    }

    public function getFromDate() {
        return $this->fromDate;
    }

    public function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
    }

    public function getToDate() {
        return $this->toDate;
    }

    public function setToDate($toDate) {
        $this->toDate = $toDate;
    }    
    
    public function getDeletedFlag() {
        return $this->deletedFlag;
    }

    public function setDeletedFlag($deleted) {
        $this->deletedFlag = $deleted;
    }
    
    public function getIdList() {
        return $this->idList;
    }

    public function setIdList($idList) {
        $this->idList = $idList;
    }

    public function getValidDate() {
        return $this->validDate;
    }

    public function setValidDate($validDate) {
        $this->validDate = $validDate;
    }
}
