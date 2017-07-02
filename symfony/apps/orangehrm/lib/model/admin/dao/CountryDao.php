<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 * 
 */

class CountryDao extends BaseDao {

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
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Fetch list of provinces
     *
     * @param String $countryCode Country code - defaults to null
     * @return Province
     */
    public function getProvinceList($countryCode = NULL) {
        try {
            $q = Doctrine_Query::create()
                    ->from('Province p');

            if (!empty($countryCode)) {
                $q->where('cou_code = ?', $countryCode);
            }

            $q->orderBy('p.province_name');

            $provinceList = $q->execute();

            return $provinceList;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function searchCountries(array $searchParams) {
        try {
            $query = Doctrine_Query::create()
                    ->from('Country c');
            
            foreach ($searchParams as $field => $filterValue) {
                $query->addWhere($field . ' = ?', $filterValue);
            }
            
            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}