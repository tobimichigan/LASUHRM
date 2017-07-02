<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class TimesheetPeriodService {

	private $timesheetPeriodDao;

	/**
	 * Get the TimesheetPeriod Data Access Object
	 * @return TimesheetPeriodDao
	 */
	public function getTimesheetPeriodDao() {


		if (is_null($this->timesheetPeriodDao)) {
			$this->timesheetPeriodDao = new TimesheetPeriodDao();
		}

		return $this->timesheetPeriodDao;
	}

	public function setTimesheetPeriodDao(TimesheetPeriodDao $timesheetPeriodDao) {

		$this->timesheetPeriodDao = $timesheetPeriodDao;
	}

	public function getDefinedTimesheetPeriod($currentDate) {

		$xmlString = $this->getTimesheetPeriodDao()->getDefinedTimesheetPeriod();
		$xml = simplexml_load_String($xmlString);
       

		return $this->getDaysOfTheTimesheetPeriod($xml, $currentDate);
	}

	public function getDaysOfTheTimesheetPeriod($xml, $currentDate) {

		$timesheetPeriodFactory = new TimesheetPeriodFactory();
		$timesheetPeriodObject = $timesheetPeriodFactory->createTimesheetPeriod($xml);
		return $timesheetPeriodObject->calculateDaysInTheTimesheetPeriod($currentDate, $xml);
	}

	public function isTimesheetPeriodDefined() {
		return $this->getTimesheetPeriodDao()->isTimesheetPeriodDefined();
	}

	public function setTimesheetPeriod($startDay) {

		$timesheetPeriodFactory = new TimesheetPeriodFactory();
		$timesheetPeriodObject = $timesheetPeriodFactory->setTimesheetPeriod();
		$xml = $timesheetPeriodObject->setTimesheetPeriodAndStartDate($startDay);
		$this->getTimesheetPeriodDao()->setTimesheetPeriod();
		return $this->getTimesheetPeriodDao()->setTimesheetPeriodAndStartDate($xml);
	}

    public function getTimesheetHeading(){
        
        $xmlString = $this->getTimesheetPeriodDao()->getDefinedTimesheetPeriod();
		$xml = simplexml_load_String($xmlString);
        
        return $xml->Heading;
       
        
    }


}

?>
