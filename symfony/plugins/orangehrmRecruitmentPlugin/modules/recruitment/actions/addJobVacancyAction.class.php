<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class addJobVacancyAction extends baseRecruitmentAction {

    private $vacancyService;

    /**
     * Get VacancyService
     * @returns VacncyService
     */
    public function getVacancyService() {
        if (is_null($this->vacancyService)) {
            $this->vacancyService = new VacancyService();
            $this->vacancyService->setVacancyDao(new VacancyDao());
        }
        return $this->vacancyService;
    }

    /**
     * Set VacancyService
     * @param VacancyService $vacancyService
     */
    public function setVacancyService(VacancyService $vacancyService) {
        $this->vacancyService = $vacancyService;
    }

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
        $this->form->request = $this->getRequest();
        return $this->form;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewJobVacancy');

        $usrObj = $this->getUser()->getAttribute('user');
        if (!$usrObj->isAdmin()) {
            $this->redirect('recruitment/viewCandidates');
        }

        $this->vacancyId = $request->getParameter('Id');
        $values = array('vacancyId' => $this->vacancyId);
        $this->setForm(new AddJobVacancyForm(array(), $values));

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
            MessageRegistry::instance()->addMessage($this->message, 'recruitment', 'addJobVacancy', MessageRegistry::PREPEND);
            $this->message = MessageRegistry::instance()->getMessage('recruitment', 'addJobVacancy');
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->vacancyId = $this->form->save();
                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                $this->redirect('recruitment/addJobVacancy?Id=' . $this->vacancyId);
            }
        }
    }

}

