<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 * 
 */

/**
 * Description of CompanyService
 *
 * @author orange
 */
class CurrencyService extends BaseService {

    private $currencyDao;

    /**
     * Set CurrencyDao
     * @param CurrencyDao $currencyDao
     */
    public function setCurrencyDao(CurrencyDao $currencyDao) {
        $this->currencyDao = $currencyDao;
    }

    /**
     * Return CurrencyDao
     * @returns $currencyDao
     */
    public function getCurrencyDao() {
        if (is_null($this->currencyDao)) {
            $this->currencyDao = new CurrencyDao();
        }

        return $this->currencyDao;
    }

    /**
     * Get Currency list
     * @param bool $asArray
     * @return Country
     */
    public function getCurrencyList($asArray = false) {
        try {
            return $this->getCurrencyDao()->getCurrencyList($asArray);
        } catch (Exception $e) {
            throw new AdminServiceException($e->getMessage());
        }
    }

}