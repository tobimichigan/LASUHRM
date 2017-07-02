<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ModuleService extends BaseService {
    
    private $moduleDao;
    
    /**
     * @ignore
     */
    public function getModuleDao() {
        
        if (!($this->moduleDao instanceof ModuleDao)) {
            $this->moduleDao = new ModuleDao();
        }
        
        return $this->moduleDao;
    }

    /**
     * @ignore
     */
    public function setModuleDao($moduleDao) {
        $this->moduleDao = $moduleDao;
    }
    
    /**
     * Retrieves disabled module list
     * 
     * @version 2.6.12.2 
     * @return Doctrine_Collection A collection of Module objects
     */    
    public function getDisabledModuleList() {
        return $this->getModuleDao()->getDisabledModuleList();
    }
    
    /**
     * Changes the status of set of modules
     * 
     * @version 2.6.12.2 
     * @param array $moduleList Names of modules
     * @return int Number of records updated
     */
    public function updateModuleStatus($moduleList, $status) {
        return $this->getModuleDao()->updateModuleStatus($moduleList, $status);
    }
    
}