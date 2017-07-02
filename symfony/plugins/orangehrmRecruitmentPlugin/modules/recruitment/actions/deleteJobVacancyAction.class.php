<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteJobVacancyAction extends baseRecruitmentAction {

    private $vacancyService;

    /**
     * Get VacancyService
     * @returns vacancyService
     */
    protected function getVacancyService() {

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
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $toBeDeletedVacancyIds = $request->getParameter('chkSelectRow');
        if ($form->isValid()) {
            $isDeletionSucceeded = $this->getVacancyService()->deleteVacancies($toBeDeletedVacancyIds);

            $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
        }
        $this->redirect('recruitment/viewJobVacancy');
    }

}
