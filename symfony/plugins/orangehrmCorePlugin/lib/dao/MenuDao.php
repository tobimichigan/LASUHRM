<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Menu Dao
 */
class MenuDao {
    
    public function getMenuItemList($userRoleList) {
        
        try {
                
            if (count($userRoleList) == 0) {
                return new Doctrine_Collection('MenuItem');
            }
            
            $roleNames = array();
            
            foreach($userRoleList as $role) {
                
                if ($role instanceof UserRole) {
                    $roleNames[] = $role->getName();
                } else if (is_string($role)) {
                    $roleNames[] = $role;
                }
                
            }            
            
            $query = Doctrine_Query::create()
                    ->from('MenuItem mi')
                    ->leftJoin('mi.Screen sc')
                    ->leftJoin('sc.Module mo')
                    ->leftJoin('sc.ScreenPermission sp')
                    ->leftJoin('sp.UserRole ur')
                    ->andWhere('mo.status = ?', Module::ENABLED)
                    ->andWhere('mi.status = ?', MenuItem::STATUS_ENABLED)
                    ->andWhere('sp.can_read = 1')
                    ->whereIn('ur.name', $roleNames)
                    ->orWhere('mi.screenId IS NULL')
                    ->orderBy('mi.orderHint ASC');

            return $query->execute();
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }    
        // @codeCoverageIgnoreEnd        
        
    }
    
    public function enableModuleMenuItems($moduleName, $menuTitles = array()) {
        
        try {
            
            $query = Doctrine_Query::create()
                    ->from('MenuItem mi')
                    ->leftJoin('mi.Screen sc')
                    ->leftJoin('sc.Module mo')
                    ->andWhere('mo.name = ?', $moduleName)
                    ->andWhere('mi.status = ?', MenuItem::STATUS_DISABLED);
            if (!empty($menuTitles)) {
                $query->andWhereIn('mi.menu_title', $menuTitles);
            }
            $menuItemList = $query->execute();
            $i = 0;
            
            foreach ($menuItemList as $menuItem) {
                
                $menuItem->setStatus(MenuItem::STATUS_ENABLED);
                $menuItem->save();
                $i++;
                
            }
            
            return $i;
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }    
        // @codeCoverageIgnoreEnd        
        
        
        
        
    }
    
}