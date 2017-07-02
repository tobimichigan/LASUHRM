<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of HomePageDao
 */
class HomePageDao extends BaseDao {
    
    /**
     * Get home page records for the given user role ids in priority order. (Descending order of the priority field).
     * If two records have the same priority, the higher ID will be returned first. (Assuming the later entry was 
     * intended to override the earlier entry).
     * 
     * @param Array $userRoleIds Array of user role ids
     * @return Doctrine_Collection List of matching home page entries
     * 
     * @throws DaoException on an error from the database layer
     */
    public function getHomePagesInPriorityOrder($userRoleIds) {
        try {
            if (empty($userRoleIds)) {
                return new Doctrine_Collection('HomePage');
            } else {
                $query = Doctrine_Query::create()
                        ->from('HomePage h')
                        ->whereIn('h.user_role_id', $userRoleIds)
                        ->orderBy('h.priority DESC, h.id DESC');

                return $query->execute();
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
    }
    
    /**
     * Get module default page records for the given module and given user role ids in priority order. 
     * (Descending order of the priority field).
     * If two records have the same priority, the higher ID will be returned first. (Assuming the later entry was 
     * intended to override the earlier entry).
     * 
     * @param Array $userRoleIds Array of user role ids
     * @param String $moduleName Module Name
     * @return Doctrine_Collection List of matching default page entries
     * 
     * @throws DaoException on an error from the database layer
     */
    public function getModuleDefaultPagesInPriorityOrder($moduleName, $userRoleIds) {
        try {
            if (empty($userRoleIds)) {
                return new Doctrine_Collection('ModuleDefaultPage');
            } else {
                $query = Doctrine_Query::create()
                        ->from('ModuleDefaultPage p')
                        ->leftJoin('p.Module m')
                        ->whereIn('p.user_role_id', $userRoleIds)
                        ->andWhere('m.name = ?', $moduleName)
                        ->orderBy('p.priority DESC, p.id DESC');

                return $query->execute();
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }         
    }    
}
