<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ModuleDao extends BaseDao {
    
    public function getDisabledModuleList() {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('Module')
                                ->where('status = ?', Module::DISABLED);
            
            return $q->execute();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function updateModuleStatus($moduleList, $status) {
        
        try {
        
            $q = Doctrine_Query::create()
                               ->update('Module')
                               ->set('status', $status)
                               ->whereIn('name', $moduleList);
            
            return $q->execute();
        
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }

}