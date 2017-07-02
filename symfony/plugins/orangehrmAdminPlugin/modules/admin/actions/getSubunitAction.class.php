<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class getSubunitAction extends sfAction{

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
        $subunitId = (int) $request->getParameter('subunitId');

        $object = new stdClass();

        try {
            $subunit = $this->getCompanyStructureService()->getSubunitById($subunitId);
            $object->id = $subunit->getId();
            $object->name = $subunit->getName();
            $object->description = $subunit->getDescription();
            $object->unitId = $subunit->getUnitId();

        } catch (Exception $e) {
            $object->message = __('Failed to load subunit');
            $object->messageType = 'failure';
        }

        @ob_clean();
        return $this->renderText(json_encode($object));
    }

}

