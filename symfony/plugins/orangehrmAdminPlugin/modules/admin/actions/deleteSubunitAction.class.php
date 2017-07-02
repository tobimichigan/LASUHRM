<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class deleteSubunitAction extends sfAction {

    private $companyStructureService;

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
        $id = trim($request->getParameter('subunitId'));

        try {
            $form = new DefaultListForm(array(), array(), true);
            $form->bind($request->getParameter($form->getName()));
            
            if ($form->isValid()) {
                $subunit = $this->getCompanyStructureService()->getSubunitById($id);
                $result = $this->getCompanyStructureService()->deleteSubunit($subunit);
            }
            
            if ($result) {
                $object->messageType = 'success';
                $object->message = __(TopLevelMessages::DELETE_SUCCESS);
            } else {
                $object->messageType = 'failure';
                $object->message = __('Failed to Delete Subunit');
            }
        } catch (Exception $e) {
            $object->messageType = 'failure';
            $object->message = __('Failed to Delete Subunit');
        }

        @ob_clean();
        return $this->renderText(json_encode($object));
    }

}

