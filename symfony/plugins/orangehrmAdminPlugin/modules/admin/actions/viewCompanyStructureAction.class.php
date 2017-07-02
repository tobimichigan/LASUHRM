<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class viewCompanyStructureAction extends sfAction {

    private $companyStructureService;

    /**
     * 
     * @return CompanyStructureService 
     */
    public function getCompanyStructureService() {
        if (is_null($this->companyStructureService)) {
            $this->companyStructureService = new CompanyStructureService();
            $this->companyStructureService->setCompanyStructureDao(new CompanyStructureDao());
        }
        return $this->companyStructureService;
    }

    public function setCompanyStructureService(CompanyStructureService $companyStructureService) {
        $this->companyStructureService = $companyStructureService;
    }

    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin())) {
            $this->redirect('pim/viewPersonalDetails');
        }
        
        $treeObject = $this->getCompanyStructureService()->getSubunitTreeObject();
        $tree = new ohrmTreeViewComponent();
        $tree->getPropertyObject()->setTreeObject($treeObject);
        $this->tree = $tree;

        $this->form = new SubunitForm(array(),array(),true);
        
        $this->listForm = new DefaultListForm( array(),array(),true);
    }

}

