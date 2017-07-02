<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of NewLeaveTypeDao
 */
class LeaveTypeDao {
    
    public function getLeaveTypeList($operationalCountryId = null) {
        try {
            $q = Doctrine_Query::create()
                            ->from('LeaveType lt')
                            ->where('lt.deleted = 0')
                            ->orderBy('lt.name');
            
            if (!is_null($operationalCountryId)) {
                if (is_array($operationalCountryId)) {
                    $q->andWhereIn('lt.operational_country_id', $operationalCountryId);
                } else {
                    $q->andWhere('lt.operational_country_id = ? ', $operationalCountryId);
                }
            }
            $leaveTypeList = $q->execute();

            return $leaveTypeList;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in getLeaveTypeList:" . $e);
            throw new DaoException($e->getMessage(), 0, $e);
        }        
    }    
    
    /**
     * Get Leave Type by ID
     * @return LeaveType
     */
    public function readLeaveType($id) {
        try {
            return Doctrine::getTable('LeaveType')->find($id);
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in readLeaveType:" . $e);
            throw new DaoException($e->getMessage(), 0, $e);
        }
    }    
    
    /**
     * Get Logger instance. Creates if not already created.
     *
     * @return Logger
     */
    protected function getLogger() {
        if (is_null($this->logger)) {
            $this->logger = Logger::getLogger('leave.LeaveTypeDao');
        }

        return($this->logger);
    }    
    
    /**
     *
     * @param LeaveType $leaveType
     * @return boolean
     */
    public function saveLeaveType(LeaveType $leaveType) {
        try {
            $leaveType->save();

            return true;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in saveLeaveType:" . $e);
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Delete Leave Type
     * @param array leaveTypeList
     * @returns boolean
     * @throws DaoException
     */
    public function deleteLeaveType($leaveTypeList) {

        try {

            $q = Doctrine_Query::create()
                            ->update('LeaveType lt')
                            ->set('lt.deleted', '?', 1)
                            ->whereIn('lt.id', $leaveTypeList);
            $numDeleted = $q->execute();
            if ($numDeleted > 0) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in deleteLeaveType:" . $e);
            throw new DaoException($e->getMessage());
        }
    }



    public function getDeletedLeaveTypeList($operationalCountryId = null) {
        try {
            $q = Doctrine_Query::create()
                            ->from('LeaveType lt')
                            ->where('lt.deleted = 1')
                            ->orderBy('lt.id');

            if (!is_null($operationalCountryId)) {
                $q->andWhere('lt.operational_country_id = ? ', $operationalCountryId);
            }
            
            $leaveTypeList = $q->execute();

            return $leaveTypeList;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in getDeletedLeaveTypeList:" . $e);
            throw new DaoException($e->getMessage());
        }
    }

    public function readLeaveTypeByName($leaveTypeName) {
        try {
            $q = Doctrine_Query::create()
                            ->from('LeaveType lt')
                            ->where("lt.name = ?", $leaveTypeName)
                            ->andWhere('lt.deleted = 0');

            $leaveTypeCollection = $q->execute();

            return $leaveTypeCollection[0];
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in readLeaveTypeByName:" . $e);
            throw new DaoException($e->getMessage());
        }
    }

    public function undeleteLeaveType($leaveTypeId) {

        try {

            $q = Doctrine_Query::create()
                            ->update('LeaveType lt')
                            ->set('lt.deleted', 0)
                            ->where("lt.id = ?", $leaveTypeId);

            $numUpdated = $q->execute();

            if ($numUpdated > 0) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in undeleteLeaveType:" . $e);
            throw new DaoException($e->getMessage());
        }
    }    
}
