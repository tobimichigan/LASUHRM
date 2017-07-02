<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of leaveListBalanceAjaxAction
 */
class leaveListBalanceAjaxAction extends sfAction {
    
    public function execute($request) {
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
        $postData = $request->getParameter('data');        

        $balances = $this->getLeaveBalances($postData);

        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);

        
        return $this->renderText(json_encode($balances)); 
               
    }
    
    function getLeaveBalances($postData) {
        $count = count($postData);
        
        $data = array();

            
        $leaveEntitlementService = new LeaveEntitlementService();
        $leaveStrategy = $leaveEntitlementService->getLeaveEntitlementStrategy();

        for ($i = 0; $i < $count; $i++) {
            $empNumber = $postData[$i][0];
            $leaveTypeId = $postData[$i][1];
            $startDate = $postData[$i][2];
            $endDate = $postData[$i][3];

            if ($startDate == $endDate) {
                $leaveBalance = $leaveEntitlementService->getLeaveBalance($empNumber, $leaveTypeId, $startDate);
            } else {

                $leavePeriodForStartDate = $leaveStrategy->getLeavePeriod($startDate, $empNumber, $leaveTypeId);
                $leavePeriodForEndDate = $leaveStrategy->getLeavePeriod($endDate, $empNumber, $leaveTypeId);

                if (($leavePeriodForStartDate[0] == $leavePeriodForEndDate[0]) && 
                        ($leavePeriodForStartDate[1] == $leavePeriodForEndDate[1])) {
                    $leaveBalance = $leaveEntitlementService->getLeaveBalance($empNumber, $leaveTypeId, $startDate);
                } else {
                    $startPeriodBalance = $leaveEntitlementService->getLeaveBalance($empNumber, $leaveTypeId, $startDate);
                    $endPeriodBalance = $leaveEntitlementService->getLeaveBalance($empNumber, $leaveTypeId, $endDate);

                    $leaveBalance = array(
                        array('start' => set_datepicker_date_format($leavePeriodForStartDate[0]), 
                              'end' => set_datepicker_date_format($leavePeriodForStartDate[1]), 
                              'balance' => $startPeriodBalance->getBalance()),
                        array('start' => set_datepicker_date_format($leavePeriodForEndDate[0]), 
                              'end' => set_datepicker_date_format($leavePeriodForEndDate[1]), 
                              'balance' => $endPeriodBalance->getBalance())
                    );
                }                     
            }
            
            if ($leaveBalance instanceof LeaveBalance) {
                $data[] = number_format($leaveBalance->getBalance(), 2);
            } else {
                $data[] = $leaveBalance;                
            }
        }
        
        return $data;
    }
}
