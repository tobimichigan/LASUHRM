<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of TimesheetPeriodDefinedHomePageEnabler
 */
class TimesheetPeriodDefinedHomePageEnabler implements HomePageEnablerInterface {
    protected $configService;
           
    public function getConfigService() {        
        if (!$this->configService instanceof ConfigService) {
            $this->configService = new ConfigService();
        }        
        return $this->configService;        
    }

    public function setConfigService($configService) {
        $this->configService = $configService;
    }      

    /**
     * Returns true if timesheet period is not defined.
     * This class is used to direct the user to the define timesheet period page if timesheet period is not defined.
     * 
     * @param SystemUser $systemUser
     * @return boolean
     */
    public function isEnabled($systemUser) {
        return !$this->getConfigService()->isTimesheetPeriodDefined();
    }
}
