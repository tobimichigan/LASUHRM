<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * PluginEmployee class file
 */

/**
 * Contains plugin level customizations of Employee class
 * @package    orangehrm
 * @subpackage model\pim\plugin
 */
abstract class PluginEmployee extends BaseEmployee {

    /**
     * Get First name and middle name
     * @return string 
     */
    public function getFirstAndMiddleName() {
        $name = $this->getFirstName();
        if ($this->getMiddleName() != '') {
            $name .= ' ' . $this->getMiddleName();
        }

        return $name;
    }

    /**
     * @ignore
     * @return type 
     */
    public function getFullLastName() {
        $terminationId = $this->getTerminationId();
        $name = (!empty($terminationId)) ? $this->getLastName() . " (" . __('Past Employee') . ")" : $this->getLastName();
        
        return $name;
    }

    /**
     * Get Job title name of an Employee
     * 
     * @return string 
     */
    public function getJobTitleName() {
        $jobTitle = $this->getJobTitle();
        $jobTitleName = '';
        if ($jobTitle instanceof JobTitle) {
            $jobTitleName = ($jobTitle->getIsDeleted() == JobTitle::DELETED) ? $jobTitle->getJobTitleName() . " (" . __("Deleted") . ")" : $jobTitle->getJobTitleName();
        }
        return $jobTitleName;
    }

}