<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class LocationService extends BaseService {

    private $locationDao;

    /**
     * Construct
     */
    public function __construct() {
        $this->locationDao = new LocationDao();
    }

    /**
     *
     * @return <type>
     */
    public function getLocationDao() {
        if (!($this->locationDao instanceof LocationDao)) {
            $this->locationDao = new LocationDao();
        }
        return $this->locationDao;
    }

    /**
     *
     * @param LocationDao $locationDao 
     */
    public function setLocationDao(LocationDao $locationDao) {
        $this->locationDao = $locationDao;
    }

    /**
     * Get Location by id
     * 
     * @param type $locationId
     * @return type 
     */
    public function getLocationById($locationId) {
        return $this->locationDao->getLocationById($locationId);
    }

    /**
     * 
     * Search location by project name, city and country.
     * 
     * @param type $srchClues
     * @return type 
     */
    public function searchLocations($srchClues) {
        return $this->locationDao->searchLocations($srchClues);
    }

    /**
     *
     * Get location count of the search results.
     *
     * @param type $srchClues
     * @return type 
     */
    public function getSearchLocationListCount($srchClues) {
        return $this->locationDao->getSearchLocationListCount($srchClues);
    }

    /**
     * Get total number of employees in a location.
     * 
     * @param type $locationId
     * @return type 
     */
    public function getNumberOfEmplyeesForLocation($locationId) {
        return $this->locationDao->getNumberOfEmplyeesForLocation($locationId);
    }

    /**
     * Get all locations
     * 
     * @return type 
     */
    public function getLocationList() {
        return $this->locationDao->getLocationList();
    }

}

?>
