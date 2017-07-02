<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of LeaveBalance
 *
 */
class LeaveBalance {
    public $entitled;
    public $used;
    public $scheduled;
    public $pending;
    public $notLinked;
    public $taken;
    public $adjustment ;
    
    

        
    public function __construct($entitled = 0, $used = 0, $scheduled = 0, $pending = 0, $notLinked = 0, $taken = 0 ,$adjustment =0 ) {
        $this->entitled = $entitled;
        $this->used = $used;
        $this->scheduled = $scheduled;
        $this->pending = $pending;
        $this->notLinked = $notLinked;
        $this->taken = $taken;
        $this->adjustment = $adjustment;
        $this->updateBalance();
    }
    
    public function updateBalance() {
        $balance = ($this->entitled + $this->adjustment) - ( $this->scheduled + $this->taken );
        
        $configService = new LeaveConfigurationService();
        $includePending = $configService->includePendingLeaveInBalance();
        
        if ($includePending) {
            $balance = $balance - $this->pending;
        }
        
        $this->balance = $balance;
    }
    
    public function getAdjustment() {
        return $this->adjustment;
    }

    public function setAdjustment($adjustment) {
        $this->adjustment = $adjustment;
    }
    
    public function getBalance() {

        return $this->balance;
    }
    
    public function getEntitled() {
        return $this->entitled;
    }

    public function setEntitled($entitled) {
        $this->entitled = $entitled;
    }

    public function getUsed() {
        return $this->used;
    }

    public function setUsed($used) {
        $this->used = $used;
    }

    public function getScheduled() {
        return $this->scheduled;
    }

    public function setScheduled($scheduled) {
        $this->scheduled = $scheduled;
    }

    public function getPending() {
        return $this->pending;
    }

    public function setPending($pending) {
        $this->pending = $pending;
    }

    public function getNotLinked() {
        return $this->notLinked;
    }

    public function setNotLinked($notLinked) {
        $this->notLinked = $notLinked;
    }

    public function getTaken() {
        return $this->taken;
    }

    public function setTaken($taken) {
        $this->taken = $taken;
    }

    

}

