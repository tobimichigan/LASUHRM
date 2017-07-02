<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of WorkScheduleService
 */
class WorkScheduleService {
    
    protected $leaveConfigService;
    protected $workScheduleImplementationClass;
    protected $logger;
    
    public function __construct() {
        $this->logger = Logger::getLogger('leave.WorkScheduleService');
    }

    public function getLeaveConfigurationService() {
        if (!($this->leaveConfigService instanceof LeaveConfigurationService)) {
            $this->leaveConfigService = new LeaveConfigurationService();
        }        
        return $this->leaveConfigService;
    }

    public function setLeaveConfigurationService($leaveConfigService) {
        $this->leaveConfigService = $leaveConfigService;
    }   
    
    public function getWorkSchedule($empNumber) {
        
        if (!isset($this->workScheduleImplementationClass)) {            
            $this->workScheduleImplementationClass = $this->getLeaveConfigurationService()->getWorkScheduleImplementation();  
            
            if (empty($this->workScheduleImplementationClass)) {
                $this->logger->error('No work schedule implementation defined');
                throw new ConfigurationException('Work Schedule implemenentation not defined');
            }            
            
            if (!class_exists($this->workScheduleImplementationClass)) {
                throw new ConfigurationException('Work Schedule implemenentation class ' .
                        $this->workScheduleImplementationClass . ' does not exist.');
            }
        }

        try {
            $workSchedule = new $this->workScheduleImplementationClass;                       
        } catch (Exception $e) {
            $this->logger->error('Error constructing work schedule implementation ' . 
                    $this->workScheduleImplementationClass, $e);
            throw new ConfigurationException('Work schedule implementation not configured', 0, $e);
        }
        
        if (!$workSchedule instanceof WorkScheduleInterface) {
            throw new ConfigurationException('Invalid work schedule implemenentation class ' .
                        $this->workScheduleImplementationClass);
        }
        
        $workSchedule->setEmpNumber($empNumber);
        
        return $workSchedule;
    }
}
