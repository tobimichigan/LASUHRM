<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * ReportingMethodConfigurationService Service
 * @package pim
 * @todo Rename to ReportingMethodConfigurationService [DONE]
 * @todo Deside if all methods need to have try catch blocks [DONE]
 */

class ReportingMethodConfigurationService extends BaseService {
    
    /**
     * @ignore
     * @var ReportingMethodConfigurationDao 
     */
    private $reportingMethodDao;
    
    /**
     * @ignore
     */
    public function getReportingMethodDao() {
        
        if (!($this->reportingMethodDao instanceof ReportingMethodConfigurationDao)) {
            $this->reportingMethodDao = new ReportingMethodConfigurationDao();
        }

        return $this->reportingMethodDao;
    }

    /**
     * @ignore
     */
    public function setReportingMethodDao($reportingMethodDao) {
        $this->reportingMethodDao = $reportingMethodDao;
    }
    
    /**
     * Saves a reportingMethod
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param ReportingMethod $reportingMethod 
     * @return NULL Doesn't return a value
     * 
     * @todo return saved entity [DONE]
     */
    public function saveReportingMethod(ReportingMethod $reportingMethod) {        
        return $this->getReportingMethodDao()->saveReportingMethod($reportingMethod);        
    }
    
    /**
     * Retrieves a reportingMethod by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return ReportingMethod An instance of ReportingMethod or NULL
     * 
     * @todo rename method as getReportingMethod( $id )[DONE]
     */    
    public function getReportingMethod($id) {
        return $this->getReportingMethodDao()->getReportingMethod($id);
    }
    
    /**
     * Retrieves a reporting method by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return ReportingMethod An instance of ReportingMethod or false
     */    
    public function getReportingMethodByName($name) {
        return $this->getReportingMethodDao()->getReportingMethodByName($name);
    }     
  
    /**
     * Retrieves all reportingMethods ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of ReportingMethod objects 
     */        
    public function getReportingMethodList() {
        return $this->getReportingMethodDao()->getReportingMethodList();
    }
    
    /**
     * Deletes reportingMethods
     * 
     * @version 2.6.12 
     * @param array $ids An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteReportingMethods($ids) {
        return $this->getReportingMethodDao()->deleteReportingMethods($ids);
    }

    /**
     * Checks whether the given reportingMethod name exists
     *
     * Case insensitive
     *
     * @version 2.6.12
     * @param string $reportingMethodName ReportingMethod name that needs to be checked
     * @return boolean
     * 
     * 
     */
    public function isExistingReportingMethodName($reportingMethodName) {
        return $this->getReportingMethodDao()->isExistingReportingMethodName($reportingMethodName);
    }
    
}