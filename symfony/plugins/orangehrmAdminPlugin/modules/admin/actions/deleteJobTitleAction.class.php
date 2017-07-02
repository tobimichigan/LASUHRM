<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteJobTitleAction extends sfAction {

    private $jobTitleService;

    public function getJobTitleService() {
        if (is_null($this->jobTitleService)) {
            $this->jobTitleService = new JobTitleService();
            $this->jobTitleService->setJobTitleDao(new JobTitleDao());
        }
        return $this->jobTitleService;
    }

    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $toBeDeletedJobTitleIds = $request->getParameter('chkSelectRow');

        if (!empty($toBeDeletedJobTitleIds)) {
            if ($form->isValid()) {
                $this->getJobTitleService()->deleteJobTitle($toBeDeletedJobTitleIds);
                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
            }
        }
        $this->redirect('admin/viewJobTitleList');
    }

}

