<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class LanguageService extends BaseService {
    
    private $languageDao;
    
    /**
     * @ignore
     */
    public function getLanguageDao() {
        
        if (!($this->languageDao instanceof LanguageDao)) {
            $this->languageDao = new LanguageDao();
        }
        
        return $this->languageDao;
    }

    /**
     * @ignore
     */
    public function setLanguageDao($languageDao) {
        $this->languageDao = $languageDao;
    }
    
    /**
     * Saves a language
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param Language $language 
     * @return NULL Doesn't return a value
     */
    public function saveLanguage(Language $language) {        
        $this->getLanguageDao()->saveLanguage($language);        
    }
    
    /**
     * Retrieves a language by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return Language An instance of Language or NULL
     */    
    public function getLanguageById($id) {
        return $this->getLanguageDao()->getLanguageById($id);
    }
    
    /**
     * Retrieves a language by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return Language An instance of Language or false
     */    
    public function getLanguageByName($name) {
        return $this->getLanguageDao()->getLanguageByName($name);
    }        
  
    /**
     * Retrieves all languages ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of Language objects 
     */        
    public function getLanguageList() {
        return $this->getLanguageDao()->getLanguageList();
    }
    
    /**
     * Deletes languages
     * 
     * @version 2.6.12 
     * @param array $toDeleteIds An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteLanguages($toDeleteIds) {
        return $this->getLanguageDao()->deleteLanguages($toDeleteIds);
    }

    /**
     * Checks whether the given language name exists
     *
     * Case insensitive
     *
     * @version 2.6.12
     * @param string $languageName Language name that needs to be checked
     * @return boolean
     */
    public function isExistingLanguageName($languageName) {
        return $this->getLanguageDao()->isExistingLanguageName($languageName);
    }
    
}