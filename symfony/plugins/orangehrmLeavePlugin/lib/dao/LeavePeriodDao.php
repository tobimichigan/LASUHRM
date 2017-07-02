<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class LeavePeriodDao extends BaseDao {



    /**
     * Save Leave Period History
     * 
     * @param LeavePeriodHistory $leavePeriodHistory
     * @return \LeavePeriodHistory
     * @throws DaoException
     */
    public function saveLeavePeriodHistory(LeavePeriodHistory $leavePeriodHistory) {
        try {

            $leavePeriodHistory->save();

            return $leavePeriodHistory;

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Return latest record of leave period history 
     * 
     * @return LeavePeriodHistory leavePeriodHistory
     * @throws DaoException
     */
    public function getCurrentLeavePeriodStartDateAndMonth() {
        try {
            $q = Doctrine_Query::create()
                    ->from("LeavePeriodHistory lph")
                    ->addOrderBy("lph.created_at DESC")
                    ->addOrderBy("id DESC");

            
            return $q->fetchOne();

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }
    
    /**
     * Get All Leave period list
     */
    public function getLeavePeriodHistoryList( ){
        try {
            $q = Doctrine_Query::create()
                    ->from("LeavePeriodHistory lph")
                    ->addOrderBy("lph.created_at")
                    ->addOrderBy("id ");

           
            return $q->execute();

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

}
