<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class NationalityService extends BaseService{
  private $nationalityDao;

    public function __construct() {
        $this->nationalityDao = new NationalityDao();
    }

    public function getNationalityDao() {
        return $this->nationalityDao;
    }

    public function setNationalityDao(NationalityDao $nationalityDao) {
        $this->nationalityDao = $nationalityDao;
    }

    public function getNationalityList() {
        return $this->nationalityDao->getNationalityList();
    }

    public function getNationalityById($id) {
        return $this->nationalityDao->getNationalityById($id);
    }

    public function deleteNationalities($nationalityList) {
        return $this->nationalityDao->deleteNationalities($nationalityList);
    }

}

