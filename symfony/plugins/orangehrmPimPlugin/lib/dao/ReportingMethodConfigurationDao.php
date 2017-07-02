<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ReportingMethodConfigurationDao extends BaseDao {

    public function saveReportingMethod(ReportingMethod $reportingMethod) {
        
        try {
            $reportingMethod->save();
            return $reportingMethod;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getReportingMethod($id) {
        
        try {
            return Doctrine::getTable('ReportingMethod')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getReportingMethodByName($name) {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('ReportingMethod')
                                ->where('name = ?', trim($name));
            
            return $q->fetchOne();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }    
    
    public function getReportingMethodList() {
        
        try {
            
            $q = Doctrine_Query::create()->from('ReportingMethod')
                                         ->orderBy('name');
            
            return $q->execute(); 
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function deleteReportingMethods($toDeleteIds) {
        
        try {
            
            $q = Doctrine_Query::create()->delete('ReportingMethod')
                            ->whereIn('id', $toDeleteIds);

            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function isExistingReportingMethodName($reportingMethodName) {
        
        try {
            
            $q = Doctrine_Query:: create()->from('ReportingMethod rm')
                            ->where('rm.name = ?', trim($reportingMethodName));

            if ($q->count() > 0) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }       
        
    }
    
    }
