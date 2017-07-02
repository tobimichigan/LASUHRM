<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveJobTitleAction extends sfAction {

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        
        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewJobTitleList');

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin())) {
            $this->redirect('pim/viewPersonalDetails');
        }
        $this->getUser()->setAttribute('addScreen', true);
        $jobTitleId = $request->getParameter('jobTitleId');
        $values = array('jobTitleId' => $jobTitleId);

        $this->setForm(new JobTitleForm(array(), $values));

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            $file = $request->getFiles($this->form->getName());
           
            if ($_FILES['jobTitle']['size']['jobSpec'] > 1024000) {
                 
                $this->getUser()->setFlash('jobtitle.warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE));
            }
            if ($this->form->isValid()) {
                $result = $this->form->save();
                $this->getUser()->setFlash($result['messageType'], $result['message']);
                $this->redirect('admin/viewJobTitleList');
            }
        }
    }

}

