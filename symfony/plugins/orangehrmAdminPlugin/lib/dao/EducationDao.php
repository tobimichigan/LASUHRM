<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EducationDao extends BaseDao {

    public function saveEducation(Education $education) {
        
        try {
            $education->save();            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getEducationById($id) {
        
        try {
            return Doctrine::getTable('Education')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getEducationByName($name) {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('Education')
                                ->where('name = ?', trim($name));
            
            return $q->fetchOne();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }    
    
    public function getEducationList() {
        
        try {
            
            $q = Doctrine_Query::create()->from('Education')
                                         ->orderBy('name');
            
            return $q->execute(); 
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function deleteEducations($toDeleteIds) {
        
        try {
            
            $q = Doctrine_Query::create()->delete('Education')
                            ->whereIn('id', $toDeleteIds);

            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function isExistingEducationName($educationName) {
        
        try {
            
            $q = Doctrine_Query:: create()->from('Education l')
                            ->where('l.name = ?', trim($educationName));

            if ($q->count() > 0) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }       
        
    }

}