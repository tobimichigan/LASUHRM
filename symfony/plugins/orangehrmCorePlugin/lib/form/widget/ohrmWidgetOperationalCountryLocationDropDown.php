<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Widget that displays countries and locations within the country
 * in a single drop down
 *
 */
class ohrmWidgetOperationalCountryLocationDropDown extends ohrmWidgetSelectableGroupDropDown {
    
    private $operationalCountryService;
    
    private $choices = null;
  
    protected function configure($options = array(), $attributes = array()) {
                
        parent::configure($options, $attributes);
        
        // Parent requires the 'choices' option.
        $this->addOption('choices', array());

    }
    
    /**
     * Get array of operational country and location choices
     */
    public function getChoices() {
        
        if (is_null($this->choices)) {
           
            $operationalCountries = $this->getOperationalCountryService()->getOperationalCountryList();
            
            $manager = UserRoleManagerFactory::getUserRoleManager();
            
            $accessibleCountryIds = $manager->getAccessibleEntityIds('OperationalCountry');
            
            $user = sfContext::getInstance()->getUser();
            
            // Special case for supervisor - can see all operational countries
            $showAll = false;
            if ($user->getAttribute('auth.isSupervisor')) {
                $showAll = true;
            }

            $choices = array();

            foreach ($operationalCountries as $operationalCountry) {

                $countryId = $operationalCountry->getId();
                
                if ($showAll || in_array($countryId, $accessibleCountryIds)) {
                    $country = $operationalCountry->getCountry();                

                    $locations = $country->getLocation();

                    if (count($locations) > 0) {
                        $locationChoices = array();
                        foreach ($locations as $location) {
                            $locationChoices[$location->getId()] = $location->getName();
                        }
                        asort($locationChoices);
                        $choices[$country->getCouName()] = $locationChoices;
                    }
                }

            }        
            $this->choices = $choices;            
        }
        
        return $this->choices;               
    }
    
    public function getValidValues() {
        $choices = $this->getChoices();
        return array_keys($choices);
    }
    
    
    /**
     *
     * @param OperationalCountryService $service 
     */
    public function setOperationalCountryService(OperationalCountryService $service) {
        $this->operationalCountryService = $service;
    }
    
    /**
     * 
     * @return OperationalCountryService
     */
    public function getOperationalCountryService() {
       if (!($this->operationalCountryService instanceof OperationalCountryService)) {
           $this->operationalCountryService = new OperationalCountryService();
       }
       return $this->operationalCountryService;
    }    
}

