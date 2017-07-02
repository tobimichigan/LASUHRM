<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class OrganizationGeneralInformationForm extends BaseForm {

    private $organizationService;
    private $organization;

    public function getOrganizationService() {
        if (is_null($this->organizationService)) {
            $this->organizationService = new OrganizationService(new OrganizationDao());
        }
        return $this->organizationService;
    }

    public function configure() {

        $countries = $this->getCountryList();

        $this->setWidgets(array(
            'name' => new sfWidgetFormInputText(),
            'taxId' => new sfWidgetFormInputText(),
            'registraionNumber' => new sfWidgetFormInputText(),
            'phone' => new sfWidgetFormInputText(),
            'fax' => new sfWidgetFormInputText(),
            'email' => new sfWidgetFormInputText(),
            'country' => new sfWidgetFormSelect(array('choices' => $countries)),
            'province' => new sfWidgetFormInputText(),
            'city' => new sfWidgetFormInputText(),
            'zipCode' => new sfWidgetFormInputText(),
            'street1' => new sfWidgetFormInputText(),
            'street2' => new sfWidgetFormInputText(),
            'note' => new sfWidgetFormTextArea()
        ));

        $tempOrganization = $this->getOrganizationService()->getOrganizationGeneralInformation();
        $this->organization = (!empty($tempOrganization)) ? $tempOrganization : new Organization();
        $this->__setDefaultValues($this->organization);

        $this->setValidators(array(
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
            'taxId' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'registraionNumber' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'phone' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'fax' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'email' => new sfValidatorEmail(array('required' => false, 'max_length' => 30)),
            'country' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'province' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'city' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'zipCode' => new sfValidatorString(array('required' => false, 'max_length' => 30)),
            'street1' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'street2' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'note' => new sfValidatorString(array('required' => false, 'max_length' => 255))
        ));

        $this->widgetSchema->setNameFormat('organization[%s]');
    }

    public function save() {
        
        $this->organization->setName($this->getValue('name'));
        $this->organization->setTaxId($this->getValue('taxId'));
        $this->organization->setRegistraionNumber($this->getValue('registraionNumber'));
        $this->organization->setPhone($this->getValue('phone'));
        $this->organization->setFax($this->getValue('fax'));
        $this->organization->setEmail($this->getValue('email'));
        $this->organization->setCountry($this->getValue('country'));
        $this->organization->setProvince($this->getValue('province'));
        $this->organization->setCity($this->getValue('city'));
        $this->organization->setZipCode($this->getValue('zipCode'));
        $this->organization->setStreet1($this->getValue('street1'));
        $this->organization->setStreet2($this->getValue('street2'));
        $this->organization->setNote($this->getValue('note'));

        $this->organization->save();
    }

    private function __setDefaultValues(Organization $organization) {
        $this->setDefaults(array(
            'name' => $organization->getName(),
            'taxId' => $organization->getTaxId(),
            'registraionNumber' => $organization->getRegistraionNumber(),
            'phone' => $organization->getPhone(),
            'fax' => $organization->getFax(),
            'email' => $organization->getEmail(),
            'country' => $organization->getCountry(),
            'province' => $organization->getProvince(),
            'city' => $organization->getCity(),
            'zipCode' => $organization->getZipCode(),
            'street1' => $organization->getStreet1(),
            'street2' => $organization->getStreet2(),
            'note' => $organization->getNote()
        ));
    }

    /**
     * Returns Country Service
     * @returns CountryService
     */
    public function getCountryService() {
        if (is_null($this->countryService)) {
            $this->countryService = new CountryService();
        }
        return $this->countryService;
    }

    /**
     * Returns Country List
     * @return array
     */
    private function getCountryList() {
        $list = array(0 => "-- " . __('Select') . " --");
        $countries = $this->getCountryService()->getCountryList();
        foreach ($countries as $country) {
            $list[$country->cou_code] = $country->cou_name;
        }
        return $list;
    }

}