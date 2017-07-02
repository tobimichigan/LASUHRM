<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Changes from 3.0.1 to 3.1
 * 
 * 1) start end time in ohrm_work_shift
 * 2) duration_type in ohrm_leave
 */
class SchemaIncrementTask57 extends SchemaIncrementTask {
    public $userInputs;

    public function execute() {
        $this->incrementNumber = 57;
        parent::execute();

        $result = array();

        foreach ($this->sql as $sql) {
            $result[] = $this->upgradeUtility->executeSql($sql);
        }

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

        $sql = array();   
                
        $sql[] = "ALTER TABLE ohrm_work_shift ADD COLUMN `start_time` time,
            ADD COLUMN `end_time` time;";
          
        // Update end_time to start_time + hours per day using ADDTIME()
        // The CONCAT part converts time in hours to HH:MM:SS format
        // floor(hours_per_day) gets the hours (8 from 8.5)
        // mod(hours_per_day, 1) gets the decimal part of hours (0.5 from 8.5),
        // which is then multiplied by 60, rounded, and left padded with 0's if needed.
        $sql[] = "UPDATE ohrm_work_shift SET start_time = '09:00:00', end_time = ADDTIME('09:00;00', " . 
                    "CONCAT(floor(hours_per_day), ':', lpad(round(mod(hours_per_day, 1) * 60), 2, '0'), ':00')" .
                ");";
        
        $sql[] = "ALTER TABLE ohrm_work_shift MODIFY COLUMN `start_time` time not null,
            MODIFY COLUMN `end_time` time not null;";
        
        $sql[] = "ALTER TABLE ohrm_leave ADD COLUMN `duration_type` tinyint NOT NULL default 0;";        
        
        $sql[] = "UPDATE ohrm_leave SET duration_type = 3 WHERE start_time <> '00:00:00' AND end_time <> '00:00:00';";
        
        $this->sql = $sql;
    }
    
    public function getNotes() {
        return array('The start and end time for any existing workshifts have been set to 9:00 to 17:00');
    }
}


