<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of EntitlementConsumptionStrategy
 */
interface EntitlementConsumptionStrategy {
    
    
    // Deprecated, no longer in use
    public function getAvailableEntitlements($empNumber, $leaveType, $leaveDates, $allowNoEntitlements = false);
    
    public function handleLeaveCreate($empNumber, $leaveType, $leaveDates, $allowNoEntitlements = false);
    
    public function handleLeaveCancel($leave);
    
    public function handleEntitlementStatusChange();
    
    public function handleLeavePeriodChange($leavePeriodForToday, $oldStartMonth, $oldStartDay, $newStartMonth, $newStartDay);
    
    /**
     * Get date limits for considering leave without entitlements in leave balance for the given start, end date.
     * 
     * @param String $balanceStartDate Date string for balance start date
     * @param String $balanceEndDate Date string for balance end date
     * 
     * @return Mixed Array with two dates giving period inside which leave without entitlements should count towards the leave balance.
     *               If false is returned, leave without entitlements are not considered for leave balance.
     * 
     */
    public function getLeaveWithoutEntitlementDateLimitsForLeaveBalance($balanceStartDate, $balanceEndDate);
    
    /**
     * Get leave period
     * 
     * @param string $date Date for which leave period is required
     * @param int $empNumber Employee Number
     * @param int $leaveTypeId Leave Type ID
     * @return array Array with start date at index 0 and end date at index 1
     */
    public function getLeavePeriod($date, $empNumber = null, $leaveTypeId = null);
}
