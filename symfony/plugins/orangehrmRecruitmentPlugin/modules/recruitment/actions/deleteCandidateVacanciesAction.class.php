<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class deleteCandidateVacanciesAction extends sfAction {

    
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

    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $candidateVacancyIds = $request->getParameter("chkSelectRow");
        if ($form->isValid()) {
            $toBeDeletedCandiates = $this->getCandidateService()->processCandidatesVacancyArray($candidateVacancyIds);
            $isDeleteSuccess = $this->getCandidateService()->deleteCandidate($toBeDeletedCandiates);
        }
        if($isDeleteSuccess) {
            $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
        }
        $this->redirect('recruitment/viewCandidates');
    }

}
