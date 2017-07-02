<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class LeaveTypeService extends BaseService {

    private $leaveTypeDao;

    public function getLeaveTypeDao() {
        if (!($this->leaveTypeDao instanceof LeaveTypeDao)) {
            $this->leaveTypeDao = new LeaveTypeDao();
        }
        return $this->leaveTypeDao;
    }

    public function setLeaveTypeDao(LeaveTypeDao $leaveTypeDao) {
        $this->leaveTypeDao = $leaveTypeDao;
    }

    /**
     *
     * @param LeaveType $leaveType
     * @return boolean
     */
    public function saveLeaveType(LeaveType $leaveType) {

        $this->getLeaveTypeDao()->saveLeaveType($leaveType);

        return true;
    }

    /**
     * Delete Leave Type
     * @param array $leaveTypeList
     * @returns boolean
     * @throws LeaveServiceException
     */
    public function deleteLeaveType($leaveTypeList) {

        return $this->getLeaveTypeDao()->deleteLeaveType($leaveTypeList);
    }

    /**
     *
     * @return LeaveType Collection
     */
    public function getLeaveTypeList($operationalCountryId = null) {

        return $this->getLeaveTypeDao()->getLeaveTypeList($operationalCountryId);
    }

    /**
     *
     * @return LeaveType
     */
    public function readLeaveType($leaveTypeId) {

        return $this->getLeaveTypeDao()->readLeaveType($leaveTypeId);
    }

    public function readLeaveTypeByName($leaveTypeName) {

        return $this->getLeaveTypeDao()->readLeaveTypeByName($leaveTypeName);
    }

    public function undeleteLeaveType($leaveTypeId) {

        return $this->getLeaveTypeDao()->undeleteLeaveType($leaveTypeId);
    }

    public function getDeletedLeaveTypeList($operationalCountryId = null) {

        return $this->getLeaveTypeDao()->getDeletedLeaveTypeList($operationalCountryId);
    }
    
    /**
     *
     * @return array
     */
    public function getActiveLeaveTypeNamesArray($operationalCountryId = null) {

        $activeLeaveTypes = $this->getLeaveTypeList($operationalCountryId);

        $activeTypeNamesArray = array();

        foreach ($activeLeaveTypes as $activeLeaveType) {
            $activeTypeNamesArray[] = $activeLeaveType->getName();
        }

        return $activeTypeNamesArray;
    }
    
    public function getDeletedLeaveTypeNamesArray($operationalCountryId = null) {

        $deletedLeaveTypes = $this->getDeletedLeaveTypeList($operationalCountryId);

        $deletedTypeNamesArray = array();

        foreach ($deletedLeaveTypes as $deletedLeaveType) {

            $deletedLeaveTypeObject = new stdClass();
            $deletedLeaveTypeObject->id = $deletedLeaveType->getId();
            $deletedLeaveTypeObject->name = $deletedLeaveType->getName();
            $deletedTypeNamesArray[] = $deletedLeaveTypeObject;
        }

        return $deletedTypeNamesArray;
    }

}