<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of SupervisorUserRole
 *
 * @author Chameera Senarathna
 */
class SupervisorUserRole extends AbstractUserRole {

    protected $employeeNumber;
    
    public function getEmployeeNumber() {
        if(empty($this->employeeNumber)) {
            $this->employeeNumber = sfContext::getInstance()->getUser()->getEmployeeNumber();
        }
        return $this->employeeNumber;
    }

    public function setEmployeeNumber($employeeNumber) {
        $this->employeeNumber = $employeeNumber;
    }

    public function getAccessibleEmployeeIds($operation = null, $returnType = null, $requiredPermissions = array()) {

        $employeeIdArray = array();

        $empNumber = $this->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employeeIdArray = $this->getEmployeeService()->getSubordinateIdListBySupervisorId($empNumber);
        }

        return $employeeIdArray;
    }

    public function getAccessibleEmployeePropertyList($properties, $orderField, $orderBy, $requiredPermissions = array()) {

        $employeeProperties = array();

        $empNumber = $this->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employeeProperties = $this->getEmployeeService()->getSubordinatePropertyListBySupervisorId($empNumber, $properties, $orderField, $orderBy, true);
        }

        return $employeeProperties;
    }

    public function getAccessibleEmployees($operation = null, $returnType = null, $requiredPermissions = array()) {

        $employees = array();

        $empNumber = $this->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employees = $this->getEmployeeService()->getSubordinateList($empNumber, true);
        }

        $employeesWithIds = array();

        foreach ($employees as $employee) {
            $employeesWithIds[$employee->getEmpNumber()] = $employee;
        }

        return $employeesWithIds;
    }

    public function getAccessibleLocationIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleOperationalCountryIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleSystemUserIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleUserRoleIds($operation, $returnType) {

        return array();
    }

}