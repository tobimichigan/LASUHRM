<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class NationalityForm extends BaseForm {
    private $nationalityService;

    public function getNationalityService() {
        if (is_null($this->nationalityService)) {
            $this->nationalityService = new NationalityService();
            $this->nationalityService->setNationalityDao(new NationalityDao());
        }
        return $this->nationalityService;
    }

    public function configure() {

        $this->setWidgets(array(
            'nationalityId' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'nationalityId' => new sfValidatorNumber(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 100))
        ));

        $this->widgetSchema->setNameFormat('nationality[%s]');
    }

    public function save() {

        $nationalityId = $this->getValue('nationalityId');
        if (!empty($nationalityId)) {
            $nationality = $this->getNationalityService()->getNationalityById($nationalityId);
        } else {
            $nationality = new Nationality();
        }
        $nationality->setName($this->getValue('name'));
        $nationality->save();
    }

    public function getNationalityListAsJson() {

        $list = array();
        $nationalityList = $this->getNationalityService()->getNationalityList();
        foreach ($nationalityList as $nationality) {
            $list[] = array('id' => $nationality->getId(), 'name' => $nationality->getName());
        }
        return json_encode($list);
    }
}

