<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Job Interview Service
 *
 */
class JobInterviewService extends BaseService {

	private $jobInterviewDao;

	/**
	 * Get $jobInterview Dao
	 * @return JobInterviewDao
	 */
	public function getJobInterviewDao() {
		return $this->jobInterviewDao;
	}

	/**
	 * Set $jobInterview Dao
	 * @param JobInterviewDao $jobInterviewDao
	 * @return void
	 */
	public function setJobInterviewDao(JobInterviewDao $jobInterviewDao) {
		$this->jobInterviewDao = $jobInterviewDao;
	}

	/**
	 * Construct
	 */
	public function __construct() {
		$this->jobInterviewDao = new JobInterviewDao();
	}

	public function getInterviewById($interviewId) {
		return $this->jobInterviewDao->getInterviewById($interviewId);
	}

	public function getInterviewersByInterviewId($interviewId) {
		return $this->jobInterviewDao->getInterviewersByInterviewId($interviewId);
	}

	public function getInterviewsByCandidateVacancyId($candidateVacancyId) {
		return $this->jobInterviewDao->getInterviewsByCandidateVacancyId($candidateVacancyId);
	}

	public function saveJobInterview(JobInterview $jobInterview) {
		return $this->jobInterviewDao->saveJobInterview($jobInterview);
	}

	public function updateJobInterview(JobInterview $jobInterview) {
		return $this->jobInterviewDao->updateJobInterview($jobInterview);
	}

	public function getInterviewScheduledHistoryByInterviewId($interviewId) {
		return $this->jobInterviewDao->getInterviewScheduledHistoryByInterviewId($interviewId);
	}
    
    /**
     * Get interviw objects for relevent candidate in specific date with one our time range near to the interview time
     * @param int $candidateId
     * @param dateISO $interviewDate
     * @param time $interviewTime (H:i:s)
     * @return boolean
     */
//    public function getInterviewListByCandidateIdAndInterviewDateAndTime($candidateId, $interviewDate, $interviewTime) {
//        
//        $d = explode(":", $interviewDate);
//        $t = explode("-", $interviewTime);
//        
//        $date = settype($d, "integer");
//        $time = settype($t, "integer");
//        
//        date_default_timezone_set('UTC');
//        
//        $currentTimestamp = date('c', mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]));
//        
//        
//        
//        $toTime = strtotime("+1 hours", $currentTimestamp);
//               
//    }

}

