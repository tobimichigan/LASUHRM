<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class SkillDao extends BaseDao {

    public function saveSkill(Skill $skill) {
        
        try {
            $skill->save();            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getSkillById($id) {
        
        try {
            return Doctrine::getTable('Skill')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }
    
    public function getSkillByName($name) {
        
        try {
            
            $q = Doctrine_Query::create()
                                ->from('Skill')
                                ->where('name = ?', trim($name));
            
            return $q->fetchOne();
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        
    }    
    
    public function getSkillList() {
        
        try {
            
            $q = Doctrine_Query::create()->from('Skill')
                                         ->orderBy('name');
            
            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function deleteSkills($toDeleteIds) {
        
        try {
            
            $q = Doctrine_Query::create()->delete('Skill')
                            ->whereIn('id', $toDeleteIds);

            return $q->execute();            
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
        
    }
    
    public function isExistingSkillName($skillName) {
        
        try {
            
            $q = Doctrine_Query:: create()->from('Skill s')
                            ->where('s.name = ?', trim($skillName));

            if ($q->count() > 0) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }       
        
    }

}