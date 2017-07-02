<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EducationService extends BaseService {
    
    private $educationDao;
    
    /**
     * @ignore
     */
    public function getEducationDao() {
        
        if (!($this->educationDao instanceof EducationDao)) {
            $this->educationDao = new EducationDao();
        }
        
        return $this->educationDao;
    }

    /**
     * @ignore
     */
    public function setEducationDao($educationDao) {
        $this->educationDao = $educationDao;
    }
    
    /**
     * Saves an education object
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param Education $education 
     * @return NULL Doesn't return a value
     */
    public function saveEducation(Education $education) {        
        $this->getEducationDao()->saveEducation($education);        
    }
    
    /**
     * Retrieves an education object by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return Education An instance of Education or NULL
     */    
    public function getEducationById($id) {
        return $this->getEducationDao()->getEducationById($id);
    }
    
    /**
     * Retrieves an education object by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return Education An instance of Education or false
     */    
    public function getEducationByName($name) {
        return $this->getEducationDao()->getEducationByName($name);
    }    
  
    /**
     * Retrieves all education records ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of Education objects 
     */        
    public function getEducationList() {
        return $this->getEducationDao()->getEducationList();
    }
    
    /**
     * Deletes education records
     * 
     * @version 2.6.12 
     * @param array $toDeleteIds An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteEducations($toDeleteIds) {
        return $this->getEducationDao()->deleteEducations($toDeleteIds);
    }

    /**
     * Checks whether the given education name exists
     *
     * Case insensitive
     *
     * @version 2.6.12
     * @param string $educationName Education name that needs to be checked
     * @return boolean
     */
    public function isExistingEducationName($educationName) {
        return $this->getEducationDao()->isExistingEducationName($educationName);
    }
    
}