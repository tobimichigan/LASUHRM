<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 * 
 */

class CountryService extends BaseService {

    protected $countryDao;

    /**
     * 
     * @return CountryDao
     */
    public function getCountryDao() {
        if (!($this->countryDao instanceof CountryDao)) {
            $this->countryDao = new CountryDao();
        }
        return $this->countryDao;
    }

    /**
     *
     * @param CountryDao $dao 
     */
    public function setCountryDao(CountryDao $dao) {
        $this->countryDao = $dao;
    }

    /**
     * Get Country list
     * @return Country
     */
    public function getCountryList() {
        try {
            $q = Doctrine_Query::create()
                    ->from('Country c')
                    ->orderBy('c.name');

            $countryList = $q->execute();

            return $countryList;
        } catch (Exception $e) {
            throw new AdminServiceException($e->getMessage());
        }
    }

    /**
     * 
     * @return Province
     */
    public function getProvinceList() {
        try {
            $q = Doctrine_Query::create()
                    ->from('Province p')
                    ->orderBy('p.province_name');

            $provinceList = $q->execute();

            return $provinceList;
        } catch (Exception $e) {
            throw new AdminServiceException($e->getMessage());
        }
    }

    /**
     *
     * @param array $searchParams 
     */
    public function searchCountries(array $searchParams) {
        try {
            return $this->getCountryDao()->searchCountries($searchParams);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

}