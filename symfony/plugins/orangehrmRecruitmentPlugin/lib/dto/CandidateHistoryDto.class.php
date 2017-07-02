<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CandidateHistoryDto {

	private $id;
	private $performedDate;
	private $vacancyName;
	private $description;
	private $details;

	public function getId() {
		return $this->id;
	}

	public function getPerformedDate() {
		return $this->performedDate;
	}

	public function getVacancyName() {
		return $this->vacancyName;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getDetails() {
		return $this->details;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setPerformedDate($performedDate) {
		$this->performedDate = $performedDate;
	}

	public function setVacancyName($vacancyName) {
		$this->vacancyName = ($vacancyName == null) ? "" : $vacancyName;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function setDetails($details) {
		$this->details = $details;
	}

        public function getFormattedPerformedDateToDisplay(){
            return set_datepicker_date_format($this->getPerformedDate());
        }

}
