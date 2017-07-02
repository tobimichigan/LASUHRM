<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Screen Permission Dao
 */
class ScreenPermissionDao {
   
    /**
     *
     * @param string $module Module Name
     * @param string $actionUrl Action
     * @param array $roles Array of UserRole objects or user role names
     */
    public function getScreenPermissions($module, $actionUrl, $roles) {
        try {
            $roleNames = array();
            
            foreach($roles as $role) {
                if ($role instanceof UserRole) {
                    $roleNames[] = $role->getName();
                } else if (is_string($role)) {
                    $roleNames[] = $role;
                }
            }
            
            $query = Doctrine_Query::create()
                    ->from('ScreenPermission sp')
                    ->leftJoin('sp.UserRole ur')
                    ->leftJoin('sp.Screen s')
                    ->leftJoin('s.Module m')
                    ->where('m.name = ?', $module)
                    ->andWhere('s.action_url = ?', $actionUrl)
                    ->andWhereIn('ur.name', $roleNames);

            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
    }
}

