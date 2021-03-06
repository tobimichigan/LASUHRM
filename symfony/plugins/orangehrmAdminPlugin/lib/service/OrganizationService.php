<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class OrganizationService extends BaseService {

    private $organizationDao;
    
    public function __construct() {
        $this->organizationDao = new OrganizationDao();
    }

    public function getOrganizationDao() {
        return $this->organizationDao;
    }

    public function setOrganizationDao(OrganizationDao $organizationDao) {
        $this->organizationDao = $organizationDao;
    }


    /**
     * Get organization general information
     * 
     * @version
     * @return Organization $organization
     */
    public function getOrganizationGeneralInformation(){
        return $this->getOrganizationDao()->getOrganizationGeneralInformation();
    }

}

