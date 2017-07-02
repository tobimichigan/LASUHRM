<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of UserRoleManagerService
 *
 */
class UserRoleManagerService {
    
    const KEY_USER_ROLE_MANAGER_CLASS = "authorize_user_role_manager_class";
    
    protected $configDao;    
    protected $authenticationService;
    protected $systemUserService;
    
    public function getConfigDao() {
        
        if (empty($this->configDao)) {
            $this->configDao = new ConfigDao();
        }
        return $this->configDao;
    }

    public function setConfigDao($configDao) {
        $this->configDao = $configDao;
    }

    public function getAuthenticationService() {
        if (empty($this->authenticationService)) {
            $this->authenticationService = new AuthenticationService();
        }        
        return $this->authenticationService;
    }

    public function setAuthenticationService($authenticationService) {
        $this->authenticationService = $authenticationService;
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

    
    public function getUserRoleManagerClassName() {
        return $this->getConfigDao()->getValue(self::KEY_USER_ROLE_MANAGER_CLASS);
    }
    
    public function getUserRoleManager() {
        
        $logger = Logger::getLogger('core.UserRoleManagerService');
        
        $class = $this->getUserRoleManagerClassName();
        
        $manager = null;
        
        if (class_exists($class)) {
            try {
                $manager = new $class;
            } catch (Exception $e) {
                throw new ServiceException('Exception when initializing user role manager:' . $e->getMessage());
            }
        } else {
            throw new ServiceException('User Role Manager class ' . $class . ' not found.');
        }
        
        if (!$manager instanceof AbstractUserRoleManager) {
            throw new ServiceException('User Role Manager class ' . $class . ' is not a subclass of AbstractUserRoleManager');
        }
        
        // Set System User object in manager
        $userId = $this->getAuthenticationService()->getLoggedInUserId();
        $systemUser = $this->getSystemUserService()->getSystemUser($userId);  
        
        if ($systemUser instanceof SystemUser) {
            $manager->setUser($systemUser);
        } else {
            if ($logger->isInfoEnabled() ) {
                $logger->info('No logged in system user when creating UserRoleManager');
            }            
        }
        
        return $manager;
    }
}

