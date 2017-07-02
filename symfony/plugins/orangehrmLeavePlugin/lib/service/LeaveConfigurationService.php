<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of LeaveConfigurationService
 */
class LeaveConfigurationService extends ConfigService {
    
    const KEY_LEAVE_ENTITLEMENT_CONSUMPTION_STRATEGY = "leave.entitlement_consumption_algorithm";
    const KEY_LEAVE_WORK_SCHEDULE_IMPLEMENTATION = "leave.work_schedule_implementation";
    const KEY_INCLUDE_PENDING_LEAVE_IN_BALANCE = 'leave.include_pending_leave_in_balance';
    
    protected static $includePendingLeaveInBalance = null;
    
    protected static $leaveConsumptionStrategy = null;
    
    public function getLeaveEntitlementConsumptionStrategy($forceReload = false) {
        if ($forceReload || is_null(self::$leaveConsumptionStrategy)) {
            self::$leaveConsumptionStrategy = $this->_getConfigValue(self::KEY_LEAVE_ENTITLEMENT_CONSUMPTION_STRATEGY);
        }
        
        return self::$leaveConsumptionStrategy;        
    }
    
    public function getWorkScheduleImplementation() {
        return $this->_getConfigValue(self::KEY_LEAVE_WORK_SCHEDULE_IMPLEMENTATION);
    }
    
    public function includePendingLeaveInBalance($forceReload = false) {
        $include = true;
        
        if ($forceReload || is_null(self::$includePendingLeaveInBalance)) {
            self::$includePendingLeaveInBalance = $this->_getConfigValue(self::KEY_INCLUDE_PENDING_LEAVE_IN_BALANCE);
        }
        
        if (self::$includePendingLeaveInBalance == 0) {
            $include = false;
        }
        
        return $include;
    }
}
