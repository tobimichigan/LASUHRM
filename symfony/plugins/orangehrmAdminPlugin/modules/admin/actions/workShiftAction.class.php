<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class workShiftAction extends sfAction {

    private $workShiftService;

    public function getWorkShiftService() {
        if (is_null($this->workShiftService)) {
            $this->workShiftService = new WorkShiftService();
            $this->workShiftService->setWorkShiftDao(new WorkShiftDao());
        }
        return $this->workShiftService;
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

    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
        if (!$usrObj->isAdmin()) {
            $this->redirect('pim/viewPersonalDetails');
        }

        $this->setForm(new WorkShiftForm());

        $workShiftList = $this->getWorkShiftService()->getWorkShiftList();
        $this->_setListComponent($workShiftList);
        $params = array();
        $this->parmetersForListCompoment = $params;
        $hideForm = true;

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->save();
                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                $this->redirect('admin/workShift');
            } else {
                $hideForm = false;
            }
        }

        $this->hideForm = $hideForm;
        $this->default = $this->getWorkShiftService()->getWorkShiftDefaultStartAndEndTime();
    }

    private function _setListComponent($workShiftList) {

        $configurationFactory = new WorkShiftHeaderFactory();
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($workShiftList);
    }

}

