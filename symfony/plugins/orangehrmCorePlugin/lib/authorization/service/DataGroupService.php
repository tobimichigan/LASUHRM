<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of DataGroupService
 *
 */
class DataGroupService {
    
    public $dao;
    
    /**
     * Get the Data group dao
     * @return DataGroupDao dao instance
     */
    public function getDao() {
        if (empty($this->dao)) {
            $this->dao = new DataGroupDao();
        }
        return $this->dao;
    }

    /**
     * Set the data group dao
     * @param DataGroupDao $dao
     */
    public function setDao(DataGroupDao $dao) {
        $this->dao = $dao;
    }
    
    /**
     * Get Data Group permissions 
     * 
     * @param mixed $dataGroup A single data group name (string), an array of data group names or null (to return all data group permissions)
     * @param int $userRoleId User role id
     * @param bool $selfPermission If true, self permissions are returned. If false non-self permissions are returned
     * 
     * @return Doctrine_Collection Collection of DataGroupPermission objects
     */
    public function getDataGroupPermission($dataGroup, $userRoleId , $selfPermission = false){
        return $this->getDao()->getDataGroupPermission($dataGroup, $userRoleId, $selfPermission );
    }
    
    /**
     * Get All defined data groups in the system
     * 
     * @return Doctrine_Collection Colelction of DataGroup objects
     */
    public function getDataGroups(){
        return $this->getDao()->getDataGroups();
    }
    
    /**
     * Get Data Group with given name
     * 
     * @param string $name Data Group name
     * @return DataGroup DataGroup or false if no match.
     */
    public function getDataGroup($name) {
        return $this->getDao()->getDataGroup($name);       
    }    


}

