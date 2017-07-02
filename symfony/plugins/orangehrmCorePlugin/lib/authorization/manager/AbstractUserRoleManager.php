<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * AbstractUserRoleManager interface
 */
abstract class AbstractUserRoleManager {
    
    protected $user;
    protected $userRoles;
    
    public function setUser(SystemUser $user) {
        $this->user = $user;        
        $this->userRoles = $this->getUserRoles($user);
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public function userHasNonPredefinedRole() {
        $nonPredefined = false;
        
        foreach ($this->userRoles as $role) {
            
            if (!$role->getIsPredefined()) {
                $nonPredefined = true;
                break;
            }
        }
        
        return $nonPredefined;
    }
    
    public abstract function getAccessibleEntities($entityType, $operation = null, $returnType = null, 
            $rolesToExclude = array(), $rolesToInclude = array(), $requestedPermissions = array());
    
    public abstract function getAccessibleEntityIds($entityType, $operation = null, $returnType = null,
            $rolesToExclude = array(), $rolesToInclude = array(), $requiredPermissions = array());
    
    public abstract function isEntityAccessible($entityType, $entityId, $operation = null, 
            $rolesToExclude = array(), $rolesToInclude = array(), $requiredPermissions = array());
    
    public abstract function areEntitiesAccessible($entityType, $entityIds, $operation = null, 
            $rolesToExclude = array(), $rolesToInclude = array(), $requiredPermissions = array());
    
    public abstract function getAccessibleEntityProperties($entityType, $properties = array(), 
            $orderField = null, $orderBy = null, $rolesToExclude = array(), 
            $rolesToInclude = array(), $requiredPermissions = array());
            
    public abstract function getAccessibleModules();
    
    public abstract function getAccessibleMenuItemDetails();
    
    public abstract function isModuleAccessible($module);
    
    public abstract function isScreenAccessible($module, $screen, $field);
    
    public abstract function getScreenPermissions($module, $screen);
    
    public abstract function isFieldAccessible($module, $screen, $field);
    
    public abstract function getEmployeesWithRole($roleName, $entities = array());        
    
    protected abstract function getUserRoles(SystemUser $user);    
    
    protected abstract function isActionAllowed($workFlowId, $state, $action, $rolesToExclude = array(), $rolesToInclude = array(), $entities = array());
    
    protected abstract function getAllowedActions($workFlowId, $state, $rolesToExclude = array(), $rolesToInclude = array(), $entities = array());
    
    //public abstract function getDataGroupPermissions ($dataGroupName, $rolesToExclude = array(), $rolesToInclude = array());
    public abstract function getModuleDefaultPage($module);
    public abstract function getHomePage();
}

