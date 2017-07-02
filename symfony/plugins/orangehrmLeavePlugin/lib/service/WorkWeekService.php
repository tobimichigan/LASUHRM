<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class WorkWeekService extends BaseService {

    protected $workWeekDao;

    /**
     * Get the WorkWeek Service
     * @return WorkWeekDao
     */
    public function getWorkWeekDao() {
        if (!($this->workWeekDao instanceof WorkWeekDao)) {
            $this->workWeekDao = new WorkWeekDao();
        }
        return $this->workWeekDao;
    }

    /**
     * Set the WorkWeek Service
     *
     * @param DayOffDao $DayOffDao
     * @return void
     */
    public function setWorkWeekDao(WorkWeekDao $workWeekDao) {
        $this->workWeekDao = $workWeekDao;
    }

    /**
     * Add, Update WorkWeek
     * @param DayOff $dayOff
     * @return boolean
     */
    public function saveWorkWeek(WorkWeek $workWeek) {
        return $this->getWorkWeekDao()->saveWorkWeek($workWeek);
    }

    /**
     * Delete WorkWeek
     * @param Integer $day
     * @return boolean
     */
    public function deleteWorkWeek($day) {
        return $this->getWorkWeekDao()->deleteWorkWeek($day);
    }

    /**
     * Read WorkWeek by given day
     * @param $day
     * @return $workWeek DayOff
     */
    public function readWorkWeek($day) {
        $workWeek = $this->getWorkWeekDao()->readWorkWeek($day);

        if (!$workWeek instanceof WorkWeek) {
            $workWeek = new WorkWeek();
        }

        return $workWeek;
    }

    /**
     *
     * @param integer $offset
     * @param integer $limit
     * @return attay Array of WorkWeek Objects
     */
    public function getWorkWeekList($offset = 0, $limit = 10) {
        $workWeekList = $this->getWorkWeekDao()->getWorkWeekList($offset, $limit);
        return $workWeekList;
    }

    /**
     *
     * @param $day
     * @return boolean
     */
    public function isWeekend($day, $fullDay, $operationalCountryId = null) {
        return $this->getWorkWeekDao()->isWeekend($day, $fullDay, $operationalCountryId);
    }
    
    /**
     *
     * @param int $workWeekId 
     * @return WorkWeek
     */
    public function getWorkWeekOfOperationalCountry($operationalCountryId = null) {
        try {
            return $this->getWorkWeekDao()->searchWorkWeek(array('operational_country_id' => $operationalCountryId))->getFirst();
        } catch (Exception $e) {
            throw new LeaveServiceException($e->getMessage());
        }
    }

}
