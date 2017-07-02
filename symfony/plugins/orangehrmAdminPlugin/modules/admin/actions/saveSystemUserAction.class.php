<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveSystemUserAction extends sfAction {

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
     * @return sfForm 
     */
    public function getForm() {
        return $this->form;
    }

    public function execute($request) {
        
        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewSystemUsers');

        $this->userId = $request->getParameter('userId');
        $values = array('userId' => $this->userId, 'sessionUser' => $this->getUser()->getAttribute('user'));
        $this->setForm(new SystemUserForm(array(), $values));

        if ($request->getParameter('userId')) {
            $userRoleManager = $this->getContext()->getUserRoleManager();
            $accessible = $userRoleManager->isEntityAccessible('SystemUser', $request->getParameter('userId'));

            if (!$accessible) {
                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            }
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $savedUser = $this->form->save();

                if ($this->form->edited) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::UPDATE_SUCCESS));
                } else {
                    if ($savedUser instanceof SystemUser) { // sets flash values for admin/viewSystemUsers pre filter for further actions if needed
                        $this->getUser()->setFlash("new.user.id", $savedUser->getId()); //
                        $this->getUser()->setFlash("new.user.role.id", $savedUser->getUserRoleId());
                    }
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                }
                $this->redirect('admin/viewSystemUsers');
            }
        }
    }

}