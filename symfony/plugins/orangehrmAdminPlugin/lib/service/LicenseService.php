<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class LicenseService extends BaseService {
    
    private $licenseDao;
    
    /**
     * @ignore
     */
    public function getLicenseDao() {
        
        if (!($this->licenseDao instanceof LicenseDao)) {
            $this->licenseDao = new LicenseDao();
        }
        
        return $this->licenseDao;
    }

    /**
     * @ignore
     */
    public function setLicenseDao($licenseDao) {
        $this->licenseDao = $licenseDao;
    }
    
    /**
     * Saves a license
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param License $license 
     * @return NULL Doesn't return a value
     */
    public function saveLicense(License $license) {        
        $this->getLicenseDao()->saveLicense($license);        
    }
    
    /**
     * Retrieves a license by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return License An instance of License or NULL
     */    
    public function getLicenseById($id) {
        return $this->getLicenseDao()->getLicenseById($id);
    }
    
    /**
     * Retrieves a license by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return License An instance of License or false
     */    
    public function getLicenseByName($name) {
        return $this->getLicenseDao()->getLicenseByName($name);
    }     
  
    /**
     * Retrieves all licenses ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of License objects 
     */        
    public function getLicenseList() {
        return $this->getLicenseDao()->getLicenseList();
    }
    
    /**
     * Deletes licenses
     * 
     * @version 2.6.12 
     * @param array $toDeleteIds An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteLicenses($toDeleteIds) {
        return $this->getLicenseDao()->deleteLicenses($toDeleteIds);
    }

    /**
     * Checks whether the given license name exists
     *
     * Case insensitive
     *
     * @version 2.6.12
     * @param string $licenseName License name that needs to be checked
     * @return boolean
     */
    public function isExistingLicenseName($licenseName) {
        return $this->getLicenseDao()->isExistingLicenseName($licenseName);
    }
    
}