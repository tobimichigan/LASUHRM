<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ScreenDao
 *
 */
class ScreenDao {
    
    /**
     * Get screen for given module and action
     * 
     * @param string $module Module Name
     * @param string $actionUrl Action
     * @return Screen object or FALSE if not found
     */
    public function getScreen($module, $action) {
        try {           
            $query = Doctrine_Query::create()
                    ->from('Screen s')
                    ->leftJoin('s.Module m')
                    ->where('m.name = ?', $module)
                    ->andWhere('s.action_url = ?', $action);

            return $query->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
    }
}

