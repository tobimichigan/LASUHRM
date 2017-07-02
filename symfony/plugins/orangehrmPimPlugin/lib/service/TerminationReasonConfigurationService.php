<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * TerminationReason Service
 * 
 * Rename to TerminationConfigurationReasonService
 * 
  * @package pim
 */

class TerminationReasonConfigurationService extends BaseService {
    
    /**
     * @ignore
     * @var TerminationReasonConfigurationDao 
     */
    private $terminationReasonConfigurationDao;
    
    /**
     * @ignore
     */
    public function getTerminationReasonDao() {
        
        if (!($this->terminationReasonConfigurationDao instanceof TerminationReasonConfigurationDao)) {
            $this->terminationReasonConfigurationDao = new TerminationReasonConfigurationDao();
        }
        
        return $this->terminationReasonConfigurationDao;
    }

    /**
     * @ignore
     */
    public function setTerminationReasonDao($terminationReasonConfigurationDao) {
        $this->terminationReasonConfigurationDao = $terminationReasonConfigurationDao;
    }
    
    /**
     * Saves a termination reason
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param TerminationReason $terminationReason 
     * @return NULL Doesn't return a value
     * 
     * @todo return saved entity [DONE]
     */
    public function saveTerminationReason(TerminationReason $terminationReason) {        
        return $this->getTerminationReasonDao()->saveTerminationReason($terminationReason);        
    }
    
    /**
     * Retrieves a termination reason by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return TerminationReason An instance of TerminationReason or NULL
     * 
     * @todo rename method as getTerminationReason( $id ) [DONE]
     */    
    public function getTerminationReason($id) {
        return $this->getTerminationReasonDao()->getTerminationReason($id);
    }
    
    /**
     * Retrieves a termination reason by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return TerminationReason An instance of TerminationReason or false
     */    
    public function getTerminationReasonByName($name) {
        return $this->getTerminationReasonDao()->getTerminationReasonByName($name);
    }      
  
    /**
     * Retrieves all termination reasons ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of TerminationReason objects 
     */        
    public function getTerminationReasonList() {
        return $this->getTerminationReasonDao()->getTerminationReasonList();
    }
    
    /**
     * Deletes termination reasons
     * 
     * @version 2.6.12 
     * 
     * @param array $ids An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteTerminationReasons($ids) {
        return $this->getTerminationReasonDao()->deleteTerminationReasons($ids);
    }

    /**
     * Checks whether the given termination reason name exists
     *
     * Case insensitive
     *
     * @version 2.6.12
     * @param string $terminationReasonName Termination reason name that needs to be checked
     * @return boolean
     * 
     */
    public function isExistingTerminationReasonName($terminationReasonName) {
        return $this->getTerminationReasonDao()->isExistingTerminationReasonName($terminationReasonName);
    }
    
    /**
     * Checks whether the given IDs have been assigned to any employee
     * 
     * @ignore
     * 
     * @param array $idArray Reason IDs
     * @return boolean 
     * 
     * @todo rename method as isTerminationReasonsInUse 
     */
    public function isReasonInUse($idArray) {
        return $this->getTerminationReasonDao()->isReasonInUse($idArray);
    }
    
}