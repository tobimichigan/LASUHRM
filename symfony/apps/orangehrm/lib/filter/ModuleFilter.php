<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class ModuleFilter extends sfFilter {

    public function execute($filterChain) {

        /* Populating enabled modules */
        
        $disabledModules = array();
        
        if ($this->getContext()->getUser()->hasAttribute("admin.disabledModules")) {
            
            $disabledModules = $this->getContext()->getUser()->getAttribute("admin.disabledModules");
            
        } else {
            
            $moduleService = new ModuleService();
            $disabledModuleList = $moduleService->getDisabledModuleList();
            
            foreach ($disabledModuleList as $module) {
                $disabledModules[] = $module->getName();
            }
            
            $this->getContext()->getUser()->setAttribute("admin.disabledModules", $disabledModules);
            
        }
        
        /* Checking request with disabled modules */
        
        $request = $this->getContext()->getRequest();
        
        if (in_array($request['module'], $disabledModules)) {
            header("HTTP/1.0 404 Not Found");
            die;
        }
        
        /* Continuing the filter chain */

        $filterChain->execute();
        
    }

}
