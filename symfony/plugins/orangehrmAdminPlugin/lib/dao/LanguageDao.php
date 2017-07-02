<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class LanguageDao extends BaseDao {

    public function saveLanguage(Language $language) {
        
        try {
            $language->save();            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getLanguageById($id) {
        
        try {
            return Doctrine::getTable('Language')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getLanguageByName($name) {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('Language')
                                ->where('name = ?', trim($name));
            
            return $q->fetchOne();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }    
    
    public function getLanguageList() {
        
        try {
            
            $q = Doctrine_Query::create()->from('Language')
                                         ->orderBy('name');
            
            return $q->execute(); 
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function deleteLanguages($toDeleteIds) {
        
        try {
            
            $q = Doctrine_Query::create()->delete('Language')
                            ->whereIn('id', $toDeleteIds);

            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function isExistingLanguageName($languageName) {
        
        try {
            
            $q = Doctrine_Query:: create()->from('Language l')
                            ->where('l.name = ?', trim($languageName));

            if ($q->count() > 0) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }       
        
    }

}