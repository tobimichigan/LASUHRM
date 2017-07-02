<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class addCandidateAction extends sfAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function getForm() {
        return $this->form;
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
     * @return <type>
     */
    public function getVacancyService() {
        if (is_null($this->vacancyService)) {
            $this->vacancyService = new VacancyService();
            $this->vacancyService->setVacancyDao(new VacancyDao());
        }
        return $this->vacancyService;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {
         /* For highlighting corresponding menu item */  
        $request->setParameter('initialActionName', 'viewCandidates');

        $userObj = $this->getUser()->getAttribute('user');
        $allowedVacancyList = $userObj->getAllowedVacancyList();
        $allowedCandidateListToDelete = $userObj->getAllowedCandidateListToDelete();
        $this->candidateId = $request->getParameter('id');
        $this->invalidFile = false;
        $reDirect = false;
        $this->edit = true;
        if ($this->candidateId > 0 && !(in_array($this->candidateId, $allowedCandidateListToDelete))) {
            $reDirect = true;
            $this->edit = false;
        }
        $param = array('candidateId' => $this->candidateId, 'allowedVacancyList' => $allowedVacancyList, 'empNumber' => $userObj->getEmployeeNumber(), 'isAdmin' => $userObj->isAdmin());
        $this->setForm(new AddCandidateForm(array(), $param, true));

       
        $vacancyProperties = array('name', 'id', 'status' );
        $this->jobVacancyList = $this->getVacancyService()->getVacancyPropertyList($vacancyProperties);
        
        $this->candidateStatus = JobCandidate::ACTIVE;
        
        if ($this->candidateId > 0) {
            $allowedCandidateList = $userObj->getAllowedCandidateList();
            if (!in_array($this->candidateId, $allowedCandidateList)) {
                $this->redirect('recruitment/viewCandidates');
            }
            $this->actionForm = new ViewCandidateActionForm(array(), $param, true);
            $allowedHistoryList = $userObj->getAllowedCandidateHistoryList($this->candidateId);

            $candidateHistory = $this->getCandidateService()->getCandidateHistoryForCandidateId($this->candidateId, $allowedHistoryList);
            $candidateHistoryService = new CandidateHistoryService();
            $this->_setListComponent($candidateHistoryService->getCandidateHistoryList($candidateHistory));
            $params = array();
            $this->parmetersForListCompoment = $params;
            $this->candidateStatus = $this->getCandidateService()->getCandidateById($this->candidateId)->getStatus();
        } else {
            if (!($userObj->isAdmin() || $userObj->isHiringManager())) {
                $this->redirect('recruitment/viewCandidates');
            }
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            $file = $request->getFiles($this->form->getName());

            if (($_FILES['addCandidate']['size']['resume'] > 1024000) || ($_FILES['addCandidate']['error']['resume'] && $_FILES['addCandidate']['name']['resume'])) {
                $title = ($this->candidateId > 0) ? __('Editing Candidate') : __('Adding Candidate');	 
                $this->getUser()->setFlash('addcandidate.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            } elseif ($_FILES == null) {
                $title = ($this->candidateId > 0) ? __('Editing Candidate') : __('Adding Candidate');
                $this->getUser()->setFlash('addcandidate.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
                $this->redirect('recruitment/addCandidate');
            } else {
                $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
                $file = $request->getFiles($this->form->getName());

                if ($this->form->isValid()) {

                    $result = $this->form->save();

                    if (isset($result['messageType'])) {
                        $this->messageType = $result['messageType'];
                        $this->message = $result['message'];
                        $this->invalidFile = true;
                    } else {
                        $this->candidateId = $result['candidateId'];
                        $this->getUser()->setFlash('addcandidate.success', __(TopLevelMessages::SAVE_SUCCESS));
                        $this->redirect('recruitment/addCandidate?id=' . $this->candidateId);
                    }
                }
            }
        }
    }

    /**
     *
     * @param <type> $candidateHistory
     */
    private function _setListComponent($candidateHistory) {
        $configurationFactory = new CandidateHistoryHeaderFactory();
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($candidateHistory);
    }

}
