<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of DataGroupDao
 *
 */
class DataGroupDao {
    
    public function getDataGroup($name) {
        try {
            $query = Doctrine_Query::create()
                    ->from('DataGroup d')
                    ->where('d.name = ?', $name);
            return $query->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }        
    }
    
    
    /*
     * Get non pre defined UserRoles
     * 
     * @return Array Array of UserRole objects
     */

    public function getDataGroupPermission($dataGroupName, $userRoleId, $selfPermission = false) {
        
       if(!is_array($dataGroupName) && $dataGroupName != null){
           $dataGroupName = array($dataGroupName);
       }
       
        try {
            $query = Doctrine_Query::create()
                    ->from('DataGroupPermission as p')
                    ->leftJoin('p.DataGroup as g')
                    ->andWhere('p.user_role_id = ?', $userRoleId);
                    if($dataGroupName != null){
                        $query->andWhereIn('g.name ', $dataGroupName);
                    }
                    if($selfPermission){
                        $query->andWhere('p.self = 1');
                    }else {
                        $query->andWhere('p.self = 0');
                    }

            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     *
     * @return Doctrine_Collection 
     */
    public function getDataGroups(){
         try {
            $query = Doctrine_Query::create()
                    ->from('DataGroup as g')
                    ->orderBy('g.description'); 
            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}

