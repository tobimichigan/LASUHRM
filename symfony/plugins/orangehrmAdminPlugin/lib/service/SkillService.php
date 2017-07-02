<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class SkillService extends BaseService {
    
    private $skillDao;
    
    /**
     * @ignore
     */
    public function getSkillDao() {
        
        if (!($this->skillDao instanceof SkillDao)) {
            $this->skillDao = new SkillDao();
        }
        
        return $this->skillDao;
    }

    /**
     * @ignore
     */
    public function setSkillDao($skillDao) {
        $this->skillDao = $skillDao;
    }
    
    /**
     * Saves a skill
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.6.12 
     * @param Skill $skill 
     * @return NULL Doesn't return a value
     */
    public function saveSkill(Skill $skill) {        
        $this->getSkillDao()->saveSkill($skill);        
    }
    
    /**
     * Retrieves a skill by ID
     * 
     * @version 2.6.12 
     * @param int $id 
     * @return Skill An instance of Skill or NULL
     */    
    public function getSkillById($id) {
        return $this->getSkillDao()->getSkillById($id);
    }
    
    /**
     * Retrieves a skill by name
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $name 
     * @return Skill An instance of Skill or false
     */    
    public function getSkillByName($name) {
        return $this->getSkillDao()->getSkillByName($name);
    }    
  
    /**
     * Retrieves all skills ordered by name
     * 
     * @version 2.6.12 
     * @return Doctrine_Collection A doctrine collection of Skill objects 
     */        
    public function getSkillList() {
        return $this->getSkillDao()->getSkillList();
    }
    
    /**
     * Deletes skills
     * 
     * @version 2.6.12 
     * @param array $toDeleteIds An array of IDs to be deleted
     * @return int Number of records deleted
     */    
    public function deleteSkills($toDeleteIds) {
        return $this->getSkillDao()->deleteSkills($toDeleteIds);
    }

    /**
     * Checks whether the given skill name exists
     * 
     * Case insensitive
     * 
     * @version 2.6.12 
     * @param string $skillName Skill name that needs to be checked
     * @return boolean
     */    
    public function isExistingSkillName($skillName) {
        return $this->getSkillDao()->isExistingSkillName($skillName);
    }
    

}