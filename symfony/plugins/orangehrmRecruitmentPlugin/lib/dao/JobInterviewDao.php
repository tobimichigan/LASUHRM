<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * CandidateDao for CRUD operation
 *
 */
class JobInterviewDao extends BaseDao {

	/**
	 *
	 * @param <type> $interviewId
	 * @return <type> 
	 */
	public function getInterviewById($interviewId) {
		try {
			return Doctrine :: getTable('JobInterview')->find($interviewId);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getInterviewersByInterviewId($interviewId) {

		try {
			$q = Doctrine_Query :: create()
					->from('JobInterviewInterviewer')
					->where('interview_id =?', $interviewId);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getInterviewsByCandidateVacancyId($candidateVacancyId) {

		try {
			$q = Doctrine_Query :: create()
					->from('JobInterview')
					->where('candidate_vacancy_id =?', $candidateVacancyId);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getInterviewScheduledHistoryByInterviewId($interviewId) {

		try {
			$q = Doctrine_Query :: create()
					->from('CandidateHistory')
					->where('interview_id =?', $interviewId)
					->andWhere('action =?', WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW);
			return $q->fetchOne();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

    public function saveJobInterview(JobInterview $jobInterview) {
		try {
			if ($jobInterview->getId() == "") {
				$idGenService = new IDGeneratorService();
				$idGenService->setEntity($jobInterview);
				$jobInterview->setId($idGenService->getNextID());
			}
			$jobInterview->save();
			return true;
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
    
    /**
     * Get interviw objects for relevent candidate in specific date
     * @param int $candidateId
     * @param dateISO $interviewDate
     * @param time $fromTime (actual interview time - 01:00:00)
     * @param time $toTime (actual interview time + 01:00:00)
     * @return array JobInterview Doctrine Objects
     */
    public function getInterviewListByCandidateIdAndInterviewDateAndTime($candidateId, $interviewDate, $fromTime, $toTime) {
        
        try {
            
            $query = Doctrine_Query::create()
                    ->from('JobInterview ji')
                    ->leftJoin('ji.JobCandidateVacancy jcv')
                    ->where('jcv.candidateId = ?', $candidateId)
                    ->andWhere('ji.interviewDate = ?', $interviewDate)
                    ->andWhere('ji.interviewTime > ?', $fromTime)
                    ->andWhere('ji.interviewTime < ?', $toTime);
            
            return $query->execute();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
        
    }

	public function updateJobInterview(JobInterview $jobInterview) {
		try {
			$q = Doctrine_Query:: create()->update('JobInterview')
					->set('candidateVacancyId', '?', $jobInterview->candidateVacancyId)
					->set('candidateId', '?', $jobInterview->candidateId)
					->set('interviewName', '?', $jobInterview->interviewName)
					->set('interviewDate', '?', $jobInterview->interviewDate)
					->set('interviewTime', '?', $jobInterview->interviewTime)
					->set('note', '?', $jobInterview->note)
					->where('id = ?', $jobInterview->id);

			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

}