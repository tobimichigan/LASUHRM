<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class TimesheetPeriodDao {

    protected $configDao;
    
    public function setConfigDao($configDao) {
        $this->configDao = $configDao;
    }
    
    public function getConfigDao() {
        
        if (is_null($this->configDao)) {
            $this->configDao = new ConfigDao();
        }
        
        return $this->configDao;
        
    }

	public function getDefinedTimesheetPeriod() {

		try {
            return $this->getConfigDao()->getValue(ConfigService::KEY_TIMESHEET_PERIOD_AND_START_DATE);
 		} catch (Exception $ex) {
			throw new DaoException($ex->getMessage());
		}
	}

	public function isTimesheetPeriodDefined() {

		try {
            return $this->getConfigDao()->getValue(ConfigService::KEY_TIMESHEET_PERIOD_SET);
		} catch (Exception $ex) {
			throw new DaoException($ex->getMessage());
		}
	}

	public function setTimesheetPeriod() {

		try {
			$query = Doctrine_Query::create()
					->update('Config')
					->set("`value`",'?','Yes')
					->where("`key` ='timesheet_period_set' ");
	
			$query->execute();
			return true;
			
		} catch (Exception $ex) {
			throw new DaoException($ex->getMessage());
		}
	}

	public function setTimesheetPeriodAndStartDate($xml) {

		try {
			$query = Doctrine_Query::create()
					->update('Config')
					->set('`value`', '?', $xml)
					->where("`key` ='timesheet_period_and_start_date' ");
			$query->execute();
			return true;
			
		} catch (Exception $ex) {
			throw new DaoException($ex->getMessage());
		}
	}

}

