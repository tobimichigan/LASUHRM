<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of LeaveDuration
 */
class LeaveDuration {
    const FULL_DAY = 'full_day';
    const HALF_DAY = 'half_day';
    const SPECIFY_TIME = 'specify_time';
    
    const HALF_DAY_AM = 'AM';
    const HALF_DAY_PM = 'PM';
    
    protected $type;
    protected $amPm;
    protected $fromTime;
    protected $toTime;
    
    function __construct($type = null, $amPm = null, $fromTime = null, $toTime = null) {
        $this->type = $type;
        $this->amPm = $amPm;
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getAmPm() {
        return $this->amPm;
    }

    public function setAmPm($amPm) {
        $this->amPm = $amPm;
    }

    public function getFromTime() {
        return $this->fromTime;
    }

    public function setFromTime($fromTime) {
        $this->fromTime = $fromTime;
    }

    public function getToTime() {
        return $this->toTime;
    }

    public function setToTime($toTime) {
        $this->toTime = $toTime;
    }


}
