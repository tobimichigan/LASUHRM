<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

include_once 'SchemaIncrementTask.php';

class SchemaIncrementTask53 extends SchemaIncrementTask {
    
    public $userInputs;
    
    public function execute() {
        $this->incrementNumber = 53;
        parent::execute();
        
        $result = array();        
        
        $result[] = $this->createLeaveTakenStatusChangingMysqlEvent();
        
        $this->checkTransactionComplete($result);
        $this->updateOhrmUpgradeInfo($this->transactionComplete, $this->incrementNumber);
        $this->upgradeUtility->finalizeTransaction($this->transactionComplete);
        $this->upgradeUtility->closeDbConnection();
    }
    
    public function getUserInputWidgets() {        
    }
    
    public function setUserInputs() {        
    }
    
    public function loadSql() {
    }
    
    public function getNotes() {        
        return array();
    }
    
    public function createLeaveTakenStatusChangingMysqlEvent() {
        
        $eventTime = date('Y-m-d') . " 00:00:00";
        $query = "CREATE EVENT leave_taken_status_change
                    ON SCHEDULE EVERY 1 HOUR STARTS '$eventTime'
                    DO
                      BEGIN
                        UPDATE hs_hr_leave SET leave_status = 3 WHERE leave_status = 2 AND leave_date < DATE(NOW());
                      END";
        
        return $this->upgradeUtility->executeSql($query);
        
    }
    
}