<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class changeCandidateVacancyStatusAction extends baseRecruitmentAction {

    private $performedAction;

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    /**
     *
     * @return <type>
     */
    public function getCandidateService() {
        if (is_null($this->candidateService)) {
            $this->candidateService = new CandidateService();
            $this->candidateService->setCandidateDao(new CandidateDao());
        }
        return $this->candidateService;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewCandidates');

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin() || $usrObj->isHiringManager() || $usrObj->isInterviewer())) {
            $this->redirect('pim/viewPersonalDetails');
        }
        $allowedCandidateList = $usrObj->getAllowedCandidateList();
        $allowedVacancyList = $usrObj->getAllowedVacancyList();
        $allowedCandidateListToDelete = $usrObj->getAllowedCandidateListToDelete();
        $this->enableEdit = true;
        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }
        
        $id = $request->getParameter('id');
        if (!empty($id)) {
            $history = $this->getCandidateService()->getCandidateHistoryById($id);
            $action = $history->getAction();
            $this->interviewId = $history->getInterviewId();
            if ($action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_INTERVIEW || $action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_SHEDULE_2ND_INTERVIEW) {
                if ($this->getUser()->hasFlash('templateMessage')) {
                    list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
                    $this->getUser()->setFlash($this->messageType, $this->message);
                }
                $this->redirect('recruitment/jobInterview?historyId=' . $id . '&interviewId=' . $this->interviewId);
            }
            $this->performedAction = $action;
            if ($this->getCandidateService()->isInterviewer($this->getCandidateService()->getCandidateVacancyByCandidateIdAndVacancyId($history->getCandidateId(), $history->getVacancyId()), $usrObj->getEmployeeNumber())) {
                $this->enableEdit = false;
                if ($action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_PASSED || $action == WorkflowStateMachine::RECRUITMENT_APPLICATION_ACTION_MARK_INTERVIEW_FAILED) {
                    $this->enableEdit = true;
                }
            }
        }
        $candidateVacancyId = $request->getParameter('candidateVacancyId');
        $this->selectedAction = $request->getParameter('selectedAction');
        $param = array();
        if ($id > 0) {
            $param = array('id' => $id);
        }
        if ($candidateVacancyId > 0 && $this->selectedAction != "") {
            $candidateVacancy = $this->getCandidateService()->getCandidateVacancyById($candidateVacancyId);
            $nextActionList = $this->getCandidateService()->getNextActionsForCandidateVacancy($candidateVacancy->getStatus(), $usrObj);
            if ($nextActionList[$this->selectedAction] == "" || !in_array($candidateVacancy->getCandidateId(), $allowedCandidateList)) {
                $this->redirect('recruitment/viewCandidates');
            }
            $param = array('candidateVacancyId' => $candidateVacancyId, 'selectedAction' => $this->selectedAction);
            $this->performedAction = $this->selectedAction;
        }

        $this->setForm(new CandidateVacancyStatusForm(array(), $param, true));
//        if (!in_array($this->form->candidateId, $allowedCandidateList) && !in_array($this->form->vacancyId, $allowedVacancyList)) {
//            $this->redirect('recruitment/viewCandidates');
//        }
//        if (!in_array($this->form->candidateId, $allowedCandidateListToDelete)) {
//            $this->enableEdit = false;
//        }
        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $result = $this->form->performAction();
                if (isset($result['messageType'])) {
                    $this->getUser()->setFlash($result['messageType'], $result['message']);
                } else {
                    $message = __(TopLevelMessages::UPDATE_SUCCESS);
                    $this->getUser()->setFlash('success', $message);
                }
                $this->redirect('recruitment/changeCandidateVacancyStatus?id=' . $this->form->historyId);
            }
        }
    }

}