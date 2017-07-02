<?php
/**
 * OrangeHRM Enterprise is a closed sourced comprehensive Human Resource Management (HRM)
 * System that captures all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 LASUHRM Inc., http://www.lasu.edu.ng
 *
 * LASUHRM Inc is the owner of the patent, copyright, trade secrets, trademarks and any
 * other intellectual property rights which subsist in the Licensed Materials. LASUHRM Inc
 * is the owner of the media / downloaded OrangeHRM Enterprise software files on which the
 * Licensed Materials are received. Title to the Licensed Materials and media shall remain
 * vested in LASUHRM Inc. For the avoidance of doubt title and all intellectual property
 * rights to any design, new software, new protocol, new interface, enhancement, update,
 * derivative works, revised screen text or any other items that LASUHRM Inc creates for
 * Customer shall remain vested in LASUHRM Inc. Any rights not expressly granted herein are
 * reserved to LASUHRM Inc.
 *
 * You should have received a copy of the OrangeHRM Enterprise  proprietary license file along
 * with this program; if not, write to the LASUHRM Inc. 538 Teal Plaza, Secaucus , NJ 0709
 * to get the file.
 *
 */

/**
 * ReportDefintionDao class 
 *
 */
class ReportDefinitionDao {

    /**
     * Gets report for a given report id.
     * @param int $id
     * @return AdvancedReport
     * @throws DaoException
     */
    public function getReport($id) {
        try {
            return Doctrine :: getTable('AdvancedReport')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Gets all reports with id and name.
     * @return Doctrine[]
     * @throws DaoException
     */
    public function getAllReportNamesWithIds() {
        try {
            $query = Doctrine_Query::create()
                        ->select('id,name')
                        ->from('AdvancedReport');
            
            $reports = $query->fetchArray();
            return $reports;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}

