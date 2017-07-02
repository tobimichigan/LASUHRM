<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class SearchLocationForm extends BaseForm {

	private $countryService;

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

	public function configure() {

		$this->userObj = sfContext::getInstance()->getUser()->getAttribute('user');
		$countries = $this->getCountryList();

		$this->setWidgets(array(
		    'name' => new sfWidgetFormInputText(),
		    'city' => new sfWidgetFormInputText(),
		    'country' => new sfWidgetFormSelect(array('choices' => $countries)),
		));

		$this->setValidators(array(
		    'name' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
		    'city' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
		    'country' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
		));

        $this->getWidgetSchema()->setLabels($this->getFormLabels());
		$this->widgetSchema->setNameFormat('searchLocation[%s]');

	}

	public function setDefaultDataToWidgets($searchClues) {
		$this->setDefault('name', $searchClues['name']);
		$this->setDefault('city', $searchClues['city']);
		$this->setDefault('country', $searchClues['country']);
	}

	/**
	 * Returns Country List
	 * @return array
	 */
	private function getCountryList() {
		$list = array("" => "-- " . __('Select') . " --");
		$countries = $this->getCountryService()->getCountryList();
		foreach ($countries as $country) {
			$list[$country->cou_code] = $country->cou_name;
		}
		return $list;
	}
    
    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $labels = array(
            'name' => __('Location Name'),
            'city' => __('City'),
            'country' => __('Country')
        );
        return $labels;
    }

}

?>
