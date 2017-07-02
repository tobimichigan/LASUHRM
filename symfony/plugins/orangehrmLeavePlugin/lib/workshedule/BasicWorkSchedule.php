<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Basic implementation of work schedule
 */
class BasicWorkSchedule implements WorkScheduleInterface {
    
    const DEFAULT_WORK_SHIFT_LENGTH = 8;
    
    protected $empNumber;
    
    protected $employeeService;
    protected $workWeekService;
    protected $holidayService;    
    protected $workShiftService;
    
    /**
     * 
     * @return WorkShiftService
     */
    public function getWorkShiftService() {
        if (!($this->workShiftService instanceof WorkShiftService)) {
            $this->workShiftService = new WorkShiftService();
        }             
        return $this->workShiftService;
    }

    public function setWorkShiftService(WorkShiftService$workShiftService) {
        $this->workShiftService = $workShiftService;
    }    
    
    protected function getEmployeeService() {
        if (!($this->employeeService instanceof EmployeeService)) {
            $this->employeeService = new EmployeeService();
        }        
        return $this->employeeService;
    }

    protected function setEmployeeService($employeeService) {
        $this->employeeService = $employeeService;
    }    
    
    /**
     *
     * @return WorkWeekService
     */
    public function getWorkWeekService() {
        if (!($this->workWeekService instanceof WorkWeekService)) {
            $this->workWeekService = new WorkWeekService();
        }
        return $this->workWeekService;
    }

    /**
     *
     * @param WorkWeekService $service 
     */
    public function setWorkWeekService(WorkWeekService $service) {
        $this->workWeekService = $service;
    }

    /**
     *
     * @return HolidayService
     */
    public function getHolidayService() {
        if (!($this->holidayService instanceof HolidayService)) {
            $this->holidayService = new HolidayService();
        }
        return $this->holidayService;
    }

    /**
     *
     * @param HolidayService $service 
     */
    public function setHolidayService(HolidayService $service) {
        $this->holidayService = $service;
    }
    
    public function setEmpNumber($empNumber) {
        $this->empNumber = $empNumber;
    }    
    
    public function getWorkShiftLength() {
        $workshift = $this->getEmployeeService()->getEmployeeWorkShift($this->empNumber);
        if ($workshift != null) {
            $workShiftLength = $workshift->getWorkShift()->getHoursPerDay();
        } else {
            // TODO
            // Use $definedDuration = sfConfig::get('app_orangehrm_core_leave_plugin_default_work_shift_length_hours');
            $workShiftLength = self::DEFAULT_WORK_SHIFT_LENGTH;
        }
        
        return $workShiftLength;
    }
    
    public function getWorkShiftStartEndTime() {
        $workshift = $this->getEmployeeService()->getEmployeeWorkShift($this->empNumber);
        if ($workshift == null) {
            $startEndTime = $this->getWorkShiftService()->getWorkShiftDefaultStartAndEndTime();
        } else {
            $workShift = $workshift->getWorkShift();
            $startEndTime = array(
                'start_time' => $workShift->getStartTime(),
                'end_time' => $workShift->getEndTime()
            );
        }
        
        return $startEndTime;
    }    
    
    public function isWeekend($day, $fullDay) {
        return $this->getWorkWeekService()->isWeekend($day, $fullDay);
    }
    
    public function isHalfDay($day) {
        return $this->getHolidayService()->isHalfDay($day);
    }
    
    public function isHoliday($day) {
        return $this->getHolidayService()->isHoliday($day);
    }
    
    public function isHalfdayHoliday($day) {
        return $this->getHolidayService()->isHalfdayHoliday($day);
    }

}
