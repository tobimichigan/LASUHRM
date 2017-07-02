<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ScreenPermissionService
 *
 */
class ScreenPermissionService {
    
    private $screenPermissionDao;    
    private $screenDao;
    
    public function getScreenDao() {
        if (empty($this->screenDao)) {
            $this->screenDao = new ScreenDao();
        }         
        return $this->screenDao;
    }

    public function setScreenDao($screenDao) {       
        $this->screenDao = $screenDao;
    }

    public function getScreenPermissionDao() {
        if (empty($this->screenPermissionDao)) {
            $this->screenPermissionDao = new ScreenPermissionDao();
        }
        return $this->screenPermissionDao;
    }

    public function setScreenPermissionDao($screenPermissionDao) {
        $this->screenPermissionDao = $screenPermissionDao;
    }

        
    
    /**
     * Get Screen Permissions for given module, action for the given roles
     * @param string $module Module Name
     * @param string $actionUrl Action Name
     * @param string $roles Array of Role names or Array of UserRole objects
     */
    public function getScreenPermissions($module, $actionUrl, $roles) {
        $screenPermissions = $this->getScreenPermissionDao()->getScreenPermissions($module, $actionUrl, $roles);
        
        $permission = null;

        // if empty, give all permissions
        if (count($screenPermissions) == 0) {
            
            // If screen not defined, give all permissions, if screen is defined, 
            // but don't give any permissions.
            $screen = $this->getScreenDao()->getScreen($module, $actionUrl);
            if ($screen === false) {
                $permission = new ResourcePermission(true, true, true, true);
            } else {
                $permission = new ResourcePermission(false, false, false, false);
            }
        } else {
            $read = false;
            $create = false;            
            $update = false;
            $delete = false;
            
            foreach ($screenPermissions as $screenPermission) {
                if ($screenPermission->can_read) {
                    $read = true;
                }
                if ($screenPermission->can_create) {
                    $create = true;
                }
                if ($screenPermission->can_update) {
                    $update = true;
                }
                if ($screenPermission->can_delete) {
                    $delete = true;
                }             
            }
            
            $permission = new ResourcePermission($read, $create, $update, $delete);
        }
        
        return $permission;
    }
    
    public function getScreen($module, $actionUrl) {
        return $this->getScreenDao()->getScreen($module, $actionUrl);
    }
}

