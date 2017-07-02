<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ohrmAuthorizationFilter
 *
 */
class ohrmAuthorizationFilter extends sfFilter {

    /**
     * Executes the authorization filter.
     *
     * @param sfFilterChain $filterChain A sfFilterChain instance
     */
    public function execute($filterChain) {
        
        $moduleName = $this->context->getModuleName();
        $actionName = $this->context->getActionName();
        
        // disable security on login and secure actions
        if ((sfConfig::get('sf_login_module') == $moduleName) 
                    && (sfConfig::get('sf_login_action') == $actionName)
                || (sfConfig::get('sf_secure_module') == $moduleName) 
                    && (sfConfig::get('sf_secure_action') == $actionName) 
                || ('auth' == $moduleName && 
                            (($actionName == 'retryLogin') || 
                             ($actionName == 'validateCredentials') || 
                             ($actionName == 'logout')))) {
            $filterChain->execute();

            return;
        }        
        

        $logger = Logger::getLogger('filter.ohrmAuthorizationFilter');

        try {
            $userRoleManager = UserRoleManagerFactory::getUserRoleManager();
            $this->context->setUserRoleManager($userRoleManager);

        } catch (Exception $e) {
            $logger->error('Exception: ' . $e);
            $this->forwardToSecureAction();
        }

        // disable security on non-secure actions
        try {
            $secure = $this->context->getController()->getActionStack()->getLastEntry()->getActionInstance() ->getSecurityValue('is_secure');

            if (!$secure || ($secure === "false") || ($secure === "off")) {

                $filterChain->execute();
                return;            
            }
        } catch (Exception $e) {
            $logger->error('Error getting is_secure value for action: ' . $e);            
            $this->forwardToSecureAction();              
        }    

        try {
            $permissions = $userRoleManager->getScreenPermissions($moduleName, $actionName);
        } catch (Exception $e) {                    
            $logger->error('Exception: ' . $e);            
            $this->forwardToSecureAction();                     
        }

        // user does not have read permissions
        if (!$permissions->canRead()) {

            $logger->warn('User does not have access read access to ' . $moduleName . ' - ' . $actionName);
                        
            // the user doesn't have access
            $this->forwardToSecureAction();
        } else {
            // set permissions in context
            $this->context->set('screen_permissions', $permissions);
        }

        // the user has access, continue
        $filterChain->execute();
    }

    /**
     * Forwards the current request to the secure action.
     *
     * @throws sfStopException
     */
    protected function forwardToSecureAction() {
        $this->context->getController()->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

        throw new sfStopException();
    }

    /**
     * Forwards the current request to the login action.
     *
     * @throws sfStopException
     */
    protected function forwardToLoginAction() {
        $this->context->getController()->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));

        throw new sfStopException();
    }

}

