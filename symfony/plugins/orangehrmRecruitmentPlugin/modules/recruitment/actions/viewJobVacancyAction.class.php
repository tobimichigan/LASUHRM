<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewJobVacancyAction extends baseRecruitmentAction {

    private $vacancyService;

    /**
     * Get CandidateService
     * @returns CandidateService
     */
    public function getVacancyService() {
        if (is_null($this->vacancyService)) {
            $this->vacancyService = new VacancyService();
            $this->vacancyService->setVacancyDao(new VacancyDao());
        }
        return $this->vacancyService;
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

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');

        if (!$usrObj->isAdmin()) {
            $this->redirect('recruitment/viewCandidates');
        }
        $allowedVacancyList = $usrObj->getAllowedVacancyList();

        $isPaging = $request->getParameter('pageNo');
        $vacancyId = $request->getParameter('vacancyId');

        $pageNumber = $isPaging;
        if (!is_null($this->getUser()->getAttribute('vacancyPageNumber')) && !($pageNumber >= 1)) {
            $pageNumber = $this->getUser()->getAttribute('vacancyPageNumber');
        }
        $this->getUser()->setAttribute('vacancyPageNumber', $pageNumber);

        $sortField = $request->getParameter('sortField');
        $sortOrder = $request->getParameter('sortOrder');
        $noOfRecords = JobVacancy::NUMBER_OF_RECORDS_PER_PAGE;
        $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;

        $param = array('allowedVacancyList' => $allowedVacancyList);
        $this->setForm(new ViewJobVacancyForm(array(), $param, true));


        $srchParams = array('jobTitle' => "", 'jobVacancy' => "", 'hiringManager' => "", 'status' => "");
        $srchParams['noOfRecords'] = $noOfRecords;
        $srchParams['offset'] = $offset;

        if (!empty($sortField) && !empty($sortOrder) || $vacancyId > 0 || $isPaging > 0) {
            if ($this->getUser()->hasAttribute('searchParameters')) {
                $srchParams = $this->getUser()->getAttribute('searchParameters');
                $this->form->setDefaultDataToWidgets($srchParams);
            }
            $srchParams['orderField'] = $sortField;
            $srchParams['orderBy'] = $sortOrder;
        } else {
            $this->getUser()->setAttribute('searchParameters', $srchParams);
        }

        list($this->messageType, $this->message) = $this->getUser()->getFlash('vacancyDeletionMessageItems');
        $srchParams['offset'] = $offset;
        $vacancyList = $this->getVacancyService()->searchVacancies($srchParams);

        $this->_setListComponent($vacancyList, $noOfRecords, $srchParams, $pageNumber);
        $params = array();
        $this->parmetersForListCompoment = $params;
        if (empty($isPaging)) {
            if ($request->isMethod('post')) {

                $pageNumber = 1;
                $this->getUser()->setAttribute('vacancyPageNumber', $pageNumber);
                $this->form->bind($request->getParameter($this->form->getName()));

                if ($this->form->isValid()) {
                    $srchParams = $this->form->getSearchParamsBindwithFormData();
                    $srchParams['noOfRecords'] = $noOfRecords;
                    $srchParams['offset'] = 0;
                    $this->getUser()->setAttribute('searchParameters', $srchParams);
                    $vacancyList = $this->getVacancyService()->searchVacancies($srchParams);
                    $this->_setListComponent($vacancyList, $noOfRecords, $srchParams, $pageNumber);
                }
            }
        }
    }

    /**
     *
     * @param <type> $vacancyList
     * @param <type> $noOfRecords
     * @param <type> $srchParams
     */
    private function _setListComponent($vacancyList, $noOfRecords, $srchParams, $pageNumber) {
        $configurationFactory = new JobVacancyHeaderFactory();
        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($vacancyList);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords($this->getVacancyService()->searchVacanciesCount($srchParams));
    }

}
