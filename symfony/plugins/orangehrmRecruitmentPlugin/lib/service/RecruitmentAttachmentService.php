<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class RecruitmentAttachmentService extends BaseService {

	private $recruitmentAttachmentDao;

	/**
	 * Get recruitmentAttachmentDao Dao
	 * @return recruitmentAttachmentDao
	 */
	public function getRecruitmentAttachmentDao() {
		return $this->recruitmentAttachmentDao;
	}

	/**
	 * Set Candidate Dao
	 * @param CandidateDao $candidateDao
	 * @return void
	 */
	public function setRecruitmentAttachmentDao(RecruitmentAttachmentDao $recruitmentAttachmentDao) {
		$this->recruitmentAttachmentDao = $recruitmentAttachmentDao;
	}

	/**
	 * Construct
	 */
	public function __construct() {
		$this->recruitmentAttachmentDao = new RecruitmentAttachmentDao();
	}

	/**
	 *
	 * @param JobVacancyAttachment $resume
	 * @return <type>
	 */
	public function saveVacancyAttachment(JobVacancyAttachment $attachment) {
		return $this->recruitmentAttachmentDao->saveVacancyAttachment($attachment);
	}

	/**
	 *
	 * @param JobCandidateAttachment $resume
	 * @return <type>
	 */
	public function saveCandidateAttachment(JobCandidateAttachment $attachment) {
		return $this->recruitmentAttachmentDao->saveCandidateAttachment($attachment);
	}

	/**
	 *
	 * @param <type> $attachId
	 * @return <type>
	 */
	public function getVacancyAttachment($attachId) {
		return $this->recruitmentAttachmentDao->getVacancyAttachment($attachId);
	}

	/**
	 *
	 * @param <type> $attachId
	 * @return <type>
	 */
	public function getCandidateAttachment($attachId) {
		return $this->recruitmentAttachmentDao->getCandidateAttachment($attachId);
	}

	/**
	 *
	 * @param <type> $id
	 * @param <type> $screen 
	 */
	public function getAttachment($id, $screen){

		if($screen == JobCandidate::TYPE){
			return $this->recruitmentAttachmentDao->getCandidateAttachment($id);
		} elseif($screen == JobVacancy::TYPE){
			return $this->recruitmentAttachmentDao->getVacancyAttachment($id);
		} elseif($screen == JobInterview::TYPE){
			return $this->recruitmentAttachmentDao->getInterviewAttachment($id);
		} else return false;
	}

	/**
	 *
	 * @param <type> $id
	 * @param <type> $screen
	 */
	public function getAttachments($id, $screen){
		
		if($screen == JobVacancy::TYPE){
			return $this->recruitmentAttachmentDao->getVacancyAttachments($id);
		} elseif($screen == JobInterview::TYPE){
			return $this->recruitmentAttachmentDao->getInterviewAttachments($id);
		} else return false;	
	}

	public function getNewAttachment($screen, $id){

		if($screen == JobVacancy::TYPE){
			$attachment = new JobVacancyAttachment();
			$attachment->vacancyId = $id;
		} elseif($screen == JobInterview::TYPE){
			$attachment =  new JobInterviewAttachment();
			$attachment->interviewId = $id;
		}
		return $attachment;
	}

}

?>
