<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of AdminUserRole
 *
 * @author Chameera Senarathna
 */
class AdminUserRole extends AbstractUserRole {

    public function getAccessibleEmployeeIds($operation = null, $returnType = null, $requiredPermissions = array()) {

        return $this->getEmployeeService()->getEmployeeIdList(false);
    }

    public function getAccessibleEmployeePropertyList($properties, $orderField, $orderBy, $requiredPermissions = array()) {

        return $this->getEmployeeService()->getEmployeePropertyList($properties, $orderField, $orderBy, false);
    }

    public function getAccessibleEmployees($operation = null, $returnType = null, $requiredPermissions = array()) {

        $employees = $this->getEmployeeService()->getEmployeeList('empNumber', 'ASC', true);

        $employeesWithIds = array();

        foreach ($employees as $employee) {
            $employeesWithIds[$employee->getEmpNumber()] = $employee;
        }

        return $employeesWithIds;
    }

    public function getAccessibleLocationIds($operation, $returnType) {

        $locations = $this->getLocationService()->getLocationList();

        $ids = array();

        foreach ($locations as $location) {
            $ids[] = $location->getId();
        }

        return $ids;
    }

    public function getAccessibleOperationalCountryIds($operation, $returnType) {

        $operationalCountries = $this->getOperationalCountryService()->getOperationalCountryList();

        $ids = array();

        foreach ($operationalCountries as $country) {
            $ids[] = $country->getId();
        }

        return $ids;
    }

    public function getAccessibleSystemUserIds($operation, $returnType) {

        return $this->getSystemUserService()->getSystemUserIdList();
    }

    public function getAccessibleUserRoleIds($operation, $returnType) {

        $userRoles = $this->getSystemUserService()->getAssignableUserRoles();

        $ids = array();

        foreach ($userRoles as $role) {
            $ids[] = $role->getId();
        }

        return $ids;
    }
    
    public function getEmployeesWithRole($entities = array()) {
        return $this->getSystemUserService()->getEmployeesByUserRole($this->roleName);
    }
    
    

}