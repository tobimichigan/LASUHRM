<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class TerminationReasonConfigurationDao extends BaseDao {

    public function saveTerminationReason(TerminationReason $terminationReason) {
        
        try {
            $terminationReason->save();
            return $terminationReason;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getTerminationReason($id) {
        
        try {
            return Doctrine::getTable('TerminationReason')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getTerminationReasonByName($name) {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('TerminationReason')
                                ->where('name = ?', trim($name));
            
            return $q->fetchOne();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }    
    
    public function getTerminationReasonList() {
        
        try {
            
            $q = Doctrine_Query::create()->from('TerminationReason')
                                         ->orderBy('name');
            
            return $q->execute(); 
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function deleteTerminationReasons($toDeleteIds) {
        
        try {
            
            $q = Doctrine_Query::create()->delete('TerminationReason')
                            ->whereIn('id', $toDeleteIds);

            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function isExistingTerminationReasonName($terminationReasonName) {
        
        try {
            
            $q = Doctrine_Query:: create()->from('TerminationReason rm')
                            ->where('rm.name = ?', trim($terminationReasonName));

            if ($q->count() > 0) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }       
        
    }
    
    public function isReasonInUse($idArray) {
        
        $q = Doctrine_Query::create()->from('Employee em')
                                     ->leftJoin('em.EmployeeTerminationRecord et')
                                     ->leftJoin('et.TerminationReason tr')
                                     ->whereIn('tr.id', $idArray);        
        
        $result = $q->fetchOne();
        
        if ($result instanceof Employee) {
            return true;
        }
        
        return false;
        
    }

}