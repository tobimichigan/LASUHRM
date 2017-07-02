<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewJobTitleListAction extends sfAction {

    private $jobTitleService;

    public function getJobTitleService() {
        if (is_null($this->jobTitleService)) {
            $this->jobTitleService = new JobTitleService();
            $this->jobTitleService->setJobTitleDao(new JobTitleDao());
        }
        return $this->jobTitleService;
    }

    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin())) {
            $this->redirect('pim/viewPersonalDetails');
        }

        $jobTitleId = $request->getParameter('jobTitleId');
        $isPaging = $request->getParameter('pageNo');

        $pageNumber = $isPaging;
        if (!empty($jobTitleId) && $this->getUser()->hasAttribute('pageNumber')) {
            $pageNumber = $this->getUser()->getAttribute('pageNumber');
        }

        $sortField = $request->getParameter('sortField');
        $sortOrder = $request->getParameter('sortOrder');

        $noOfRecords = JobTitle::NO_OF_RECORDS_PER_PAGE;
        $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;

        $JobTitleList = $this->getJobTitleService()->getJobTitleList($sortField, $sortOrder, true, $noOfRecords, $offset);
        $this->_setListComponent($JobTitleList, $noOfRecords, $pageNumber);
        $this->getUser()->setAttribute('pageNumber', $pageNumber);
        $params = array();
        $this->parmetersForListCompoment = $params;
    }

    private function _setListComponent($JobTitleList, $noOfRecords, $pageNumber) {

        $configurationFactory = new JobTitleHeaderFactory();
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($JobTitleList);
        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords(count($this->getJobTitleService()->getJobTitleList()));
    }

}