<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of UserRoleInterface
 *
 * @author Chameera Senarathna
 */
abstract class AbstractUserRole {
    
    protected $employeeService;
    protected $systemUserService;
    protected $operationalCountryService;
    protected $locationService;
    
    protected $userRoleManager;
    
    protected $roleName;
 
    public function __construct($roleName, $userRoleManager) {
        $this->userRoleManager = $userRoleManager;
        $this->roleName = $roleName;        
    }

    public function getSystemUserService() {
        if (empty($this->systemUserService)) {
            $this->systemUserService = new SystemUserService();
        }
        return $this->systemUserService;
    }

    public function setSystemUserService($systemUserService) {
        $this->systemUserService = $systemUserService;
    }

    public function getEmployeeService() {

        if (empty($this->employeeService)) {
            $this->employeeService = new EmployeeService();
        }
        return $this->employeeService;
    }

    public function setEmployeeService($employeeService) {
        $this->employeeService = $employeeService;
    }

    public function getLocationService() {
        if (empty($this->locationService)) {
            $this->locationService = new LocationService();
        }
        return $this->locationService;
    }

    public function setLocationService($locationService) {
        $this->locationService = $locationService;
    }

    public function getOperationalCountryService() {
        if (empty($this->operationalCountryService)) {
            $this->operationalCountryService = new OperationalCountryService();
        }
        return $this->operationalCountryService;
    }

    public function setOperationalCountryService($operationalCountryService) {
        $this->operationalCountryService = $operationalCountryService;
    }
       
    public function getAccessibleEntities($entityType, $operation = null, $returnType = null, $requiredPermissions = array()) {

        switch ($entityType) {
            case 'Employee':
                $entities = $this->getAccessibleEmployees($operation, $returnType, $requiredPermissions);
                break;
        }
        return $entities;
    }

    public function getAccessibleEntityProperties($entityType, $properties = array(), $orderField = null, $orderBy = null, $requiredPermissions = array()) {

        switch ($entityType) {
            case 'Employee':
                $propertyList = $this->getAccessibleEmployeePropertyList($properties, $orderField, $orderBy, $requiredPermissions);
                break;
        }
        return $propertyList;
    }

    public function getAccessibleEntityIds($entityType, $operation = null, $returnType = null, $requiredPermissions = array()) {   
        
        switch ($entityType) {
            case 'Employee':
                $ids = $this->getAccessibleEmployeeIds($operation, $returnType, $requiredPermissions);                
                break;
            case 'SystemUser':
                $ids = $this->getAccessibleSystemUserIds($operation, $returnType);
                break;
            case 'OperationalCountry':
                $ids = $this->getAccessibleOperationalCountryIds($operation, $returnType);
                break;
            case 'UserRole':
                $ids = $this->getAccessibleUserRoleIds($operation, $returnType);
                break;
            case 'Location':
                $ids = $this->getAccessibleLocationIds($operation, $returnType);
                break;
        }
        return $ids;
    }
    
    public function getEmployeesWithRole($entities = array()) {
        return array();
    }    

    public abstract function getAccessibleEmployees($operation = null, $returnType = null, $requiredPermissions = array());
    
    public abstract function getAccessibleEmployeePropertyList($properties, $orderField, $orderBy, $requiredPermissions = array());
    
    public abstract function getAccessibleEmployeeIds($operation, $returnType, $requiredPermissions = array());

    public abstract function getAccessibleSystemUserIds($operation, $returnType);

    public abstract function getAccessibleOperationalCountryIds($operation, $returnType);

    public abstract function getAccessibleUserRoleIds($operation, $returnType);

    public abstract function getAccessibleLocationIds($operation, $returnType); 
    
}