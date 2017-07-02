<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class User {

	private $topMenuItemsArray = array();
	private $employeeList = array();
	private $activeProjectList = array();
	private $empNumber;
	private $allowedActions = array();
	private $nextState;
	private $userId;
	private $userTimeZoneOffset;
	private $canDefineTimesheetPeriod = false;
	private $actionableStates = array();
	private $previousStates = array();
	private $applicationStates = array();
	private $actionableTimesheets = null;
	private $candidateList = array();
	private $projectList = array();
	private $candidateListToDelete = array();
	private $vacancyList = array();
	private $candidateHistoryList = array();
	private $isAdmin = false;	
	private $isProjectAdmin = false;	
	private $isHiringManager = false;
	private $isInterviewer = false;
	private $employeeListForAttendanceTotalSummaryReport;
	private $employeeNameList = null;

	public function getEmployeeListForAttendanceTotalSummaryReport() {
		return $this->employeeListForAttendanceTotalSummaryReport;
	}

	public function getAccessibleTimeMenus() {

		return $this->topMenuItemsArray;
	}

	public function getActionableTimesheets() {

		return $this->actionableTimesheets;
	}
	
    public function getEmployeeNameList() {
        return $this->employeeNameList;
    }

	public function getAccessibleTimeSubMenus() {

		return $this->topMenuItemsArray;
	}

	public function getPreviousStates($workFlow, $state) {

		return $this->previousStates;
	}

	public function getAllAlowedRecruitmentApplicationStates($workFlow) {

		return $this->applicationStates;
	}

	public function getAccessibleConfigurationSubMenus() {
		return $this->topMenuItemsArray;
	}

	public function getAccessibleReportSubMenus() {
		return $this->topMenuItemsArray;
	}

	public function getAccessibleAttendanceSubMenus() {

		return $this->topMenuItemsArray;
	}

	public function getAccessibleRecruitmentMenus() {
		return $this->topMenuItemsArray;
	}

	/** Employee List depends on the decoration order * */
	public function getEmployeeList() {

		return $this->employeeList;
	}

	public function getEmployeeNumber() {

		return $this->empNumber;
	}

	public function setEmployeeNumber($empNumber) {

		$this->empNumber = $empNumber;
	}

	public function getAllowedActions($workFlow, $state) {

		return $this->allowedActions;
	}

	public function getNextState($workFlow, $state, $action) {

		return $this->nextState;
	}

	public function getUserId() {

		return $this->userId;
	}

	public function setUserId($userId) {

		$this->userId = $userId;
	}

	public function setUserTimeZoneOffset($timeZoneOffset) {
		$this->userTimeZoneOffset = $timeZoneOffset;
	}

	public function getUserTimeZoneOffset() {
		return $this->userTimeZoneOffset;
	}

	public function isAllowedToDefineTimeheetPeriod() {
		return $this->canDefineTimesheetPeriod;
	}

	public function getActiveProjectList() {
		return $this->projectList;
	}

	public function setActiveProjectList($activeProjectList) {
		$this->activeProjectList = $activeProjectList;
	}

	public function getActionableAttendanceStates($actions) {
		return $this->actionableStates;
	}

	public function getAllowedCandidateList() {
		return $this->candidateList;
	}
	
	public function getAllowedProjectList() {
		return $this->projectList;
	}

	public function getAllowedCandidateListToDelete() {
		return $this->candidateListToDelete;
	}

	public function getAllowedVacancyList() {
		return $this->vacancyList;
	}

	public function getAllowedCandidateHistoryList($candidateId) {
		return $this->candidateHistoryList;
	}

	public function isAdmin() {
		return $this->isAdmin;
	}

	public function isHiringManager() {
		return $this->isHiringManager;
	}

	public function isProjectAdmin() {
		return $this->isProjectAdmin;
	}

	public function isInterviewer() {
		return $this->isInterviewer;
	}

}