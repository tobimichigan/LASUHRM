<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class applyVacancyAction extends sfAction {

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
     * @return ApplyVacancyForm 
     */
    public function getForm() {
        return $this->form;
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
        $param = null;
        $this->candidateId = null;

        $this->vacancyId = $request->getParameter('id');
        //$this->candidateId = $request->getParameter('candidateId');
        $this->getResponse()->setTitle(__("Vacancy Apply Form"));
        //$param = array('candidateId' => $this->candidateId);
        $this->setForm(new ApplyVacancyForm(array(), $param, true));

        if (!empty($this->vacancyId)) {
            $vacancy = $this->getVacancyService()->getVacancyById($this->vacancyId);
            if (empty($vacancy)) {
                $this->redirect('recruitmentApply/jobs.html');
            }
            $this->description = $vacancy->getDescription();
            $this->name = $vacancy->getName();
        } else {
            $this->redirect('recruitmentApply/jobs.html');
        }
        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            $file = $request->getFiles($this->form->getName());

            if ($_FILES['addCandidate']['size']['resume'] > 1024000) {
                $this->getUser()->setFlash('applyVacancy.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            } else if ($_FILES == null) {
                $this->getUser()->setFlash('applyVacancy.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
                $this->redirect('recruitmentApply/applyVacancy?id=' . $this->vacancyId);
            } else {

                if ($this->form->isValid()) {

                    $result = $this->form->save();
                    if (isset($result['messageType'])) {
                        $this->getUser()->setFlash('applyVacancy.' . $result['messageType'], $result['message']);
                    } else {
                        $this->candidateId = $result['candidateId'];
                        if (!empty($this->candidateId)) {
                            $this->getUser()->setFlash('applyVacancy.success', __('Application Received'));
                            $this->getUser()->setFlash('applyVacancy.warning', null);
                        }
                    }
                }
            }
        }
    }

}

