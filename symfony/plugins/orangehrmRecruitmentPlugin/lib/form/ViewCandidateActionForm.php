<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Form class for search candidates
 */
class ViewCandidateActionForm extends BaseForm {

    private $candidateService;
    public $candidateId;
    public $candidate;
    public $empNumber;
    private $isAdmin;

    /**
     * Get CandidateService
     * @returns CandidateService
     */
    public function getCandidateService() {
        if (is_null($this->candidateService)) {
            $this->candidateService = new CandidateService();
            $this->candidateService->setCandidateDao(new CandidateDao());
        }
        return $this->candidateService;
    }

    /**
     * Set CandidateService
     * @param CandidateService $candidateService
     */
    public function setCandidateService(CandidateService $candidateService) {
        $this->candidateService = $candidateService;
    }

    public function getInterviewService() {
        if (is_null($this->interviewService)) {
            $this->interviewService = new JobInterviewService();
            $this->interviewService->setJobInterviewDao(new JobInterviewDao());
        }
        return $this->interviewService;
    }

    /**
     *
     */
    public function configure() {

        $this->candidateId = $this->getOption('candidateId');
        $this->empNumber = $this->getOption('empNumber');
        $this->isAdmin = $this->getOption('isAdmin');
        if ($this->candidateId > 0) {
            $this->candidate = $this->getCandidateService()->getCandidateById($this->candidateId);
            $existingVacancyList = $this->candidate->getJobCandidateVacancy();
            if ($existingVacancyList[0]->getVacancyId() > 0) {
                $userObj = new User();
                $userRoleDecorator = new SimpleUserRoleFactory();
                $userRoleArray = array();
                foreach ($existingVacancyList as $candidateVacancy) {
                    $userRoleArray['isHiringManager'] = $this->getCandidateService()->isHiringManager($candidateVacancy->getId(), $this->empNumber);
                    $userRoleArray['isInterviewer'] = $this->getCandidateService()->isInterviewer($candidateVacancy->getId(), $this->empNumber);
                    if ($this->isAdmin) {
                        $userRoleArray['isAdmin'] = true;
                    }
                    $newlyDecoratedUserObj = $userRoleDecorator->decorateUserRole($userObj, $userRoleArray);
                    $choicesList = $this->getCandidateService()->getNextActionsForCandidateVacancy($candidateVacancy->getStatus(), $newlyDecoratedUserObj);
                    $interviewCount = count($this->getInterviewService()->getInterviewsByCandidateVacancyId($candidateVacancy->getId()));
                    if ($interviewCount == JobInterview::NO_OF_INTERVIEWS) {
                        unset($choicesList[WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW]);
                    }
                    if ($candidateVacancy->getJobVacancy()->getStatus() == JobVacancy::CLOSED) {
                        $choicesList = array("" => __("No Actions"));
                    }
                    $widgetName = $candidateVacancy->getId();
                    $this->setWidget($widgetName, new sfWidgetFormSelect(array('choices' => $choicesList)));
                    $this->setValidator($widgetName, new sfValidatorString(array('required' => false)));
                }
            }
        }
        $this->widgetSchema->setNameFormat('viewCandidateAction[%s]');
    }

}

