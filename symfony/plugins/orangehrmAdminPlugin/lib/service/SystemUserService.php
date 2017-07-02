<?php


/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class SystemUserService extends BaseService{
    
    protected $systemUserDao = null;
    

    /**
     *
     * @return SystemUserDao
     */
    public function getSystemUserDao() {
        if (empty($this->systemUserDao)) {
            $this->systemUserDao = new SystemUserDao();
        }
        return $this->systemUserDao;
    }

    public function setSystemUserDao($systemUserDao) {
        $this->systemUserDao = $systemUserDao;
    }

    /**
     * Save System User
     * 
     * @param SystemUser $systemUser 
     * @return void
     */
    public function saveSystemUser(SystemUser $systemUser,$changePassword = false){
        
        try {
            
            if ($changePassword) {
                $systemUser->setUserPassword(md5($systemUser->getUserPassword()));
            }

            return $this->getSystemUserDao()->saveSystemUser($systemUser);
            
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
        
    }
    
    /**
     * Check is existing user according to user name
     * 
     * @param type $userName 
     * @param int $userId
     * @return mixed , false if user not exist  , otherwise it returns SystemUser object
     */
    public function isExistingSystemUser( $userName , $userId){
        try {
           return  $this->getSystemUserDao()->isExistingSystemUser( $userName , $userId);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Get System User for given User Id
     * 
     * @param type $userId
     * @return SystemUser  
     */
    public function getSystemUser( $userId ){
        try {
            return $this->getSystemUserDao()->getSystemUser( $userId );
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Get System Users
     * 
     * @return Doctrine_Collection 
     */
    public function getSystemUsers(){
        try {
            return $this->getSystemUserDao()->getSystemUsers();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Return an array of System User Ids
     * 
     * <pre>
     * 
     * The output will be an array like below.
     * 
     * array(
     *          0 => 1,
     *          1 => 2,
     *          2 => 3
     * )
     * </pre>
     * 
     * @version 2.7.1
     * @return Array of System User Ids
     */
    public function getSystemUserIdList(){
        return $this->getSystemUserDao()->getSystemUserIdList();
    }
    
   /**
     * Delete System Users
     * @param array $deletedIds 
     * 
     */
    public function deleteSystemUsers( array $deletedIds){
        try {
            $this->getSystemUserDao()->deleteSystemUsers($deletedIds);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Get Pre Defined User Roles
     * 
     * @return Doctrine_Collection UserRoles 
     */
    public function getAssignableUserRoles(){
        try {
           return $this->getSystemUserDao()->getAssignableUserRoles();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Get User role with given name
     * 
     * @param String $roleName Role Name
     * @return Doctrine_Collection UserRoles 
     */
    public function getUserRole($roleName){
        try {
           return $this->getSystemUserDao()->getUserRole($roleName);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }    
    
    public function getNonPredefinedUserRoles(){
        return$this->getSystemUserDao()->getNonPredefinedUserRoles();
    }    
    
   /**
     * Get Count of Search Query 
     * 
     * @param type $searchClues
     * @return int 
     */
    public function getSearchSystemUsersCount( $searchClues ){
        try {
           return $this->getSystemUserDao()->getSearchSystemUsersCount( $searchClues );
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
    }
    
    /**
     * Search System Users 
     * 
     * @param type $searchClues
     * @return type 
     */
     public function searchSystemUsers( $searchClues){
         try {
           return $this->getSystemUserDao()->searchSystemUsers( $searchClues );
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage(),$e->getCode(),$e);
        }
     }
     
     public function isCurrentPassword($userId, $password) {
         
         $systemUser = $this->getSystemUserDao()->getSystemUser($userId);
         
         if (!($systemUser instanceof SystemUser)) {
             return false;
         }
         
         if ($systemUser->getUserPassword() == md5($password)) {
             return true;
         }
         
         return false;
         
     }
     
     /**
      * Updates the password of given user
      * 
      * @param int $userId User ID of the user
      * @param string $password Non-encrypted password
      * @return int 
      */     
     public function updatePassword($userId, $password) {
         return $this->getSystemUserDao()->updatePassword($userId, md5($password));
     }
     
     public function getEmployeesByUserRole($roleName, $includeInactive = false, $includeTerminated = false) {
         return $this->getSystemUserDao()->getEmployeesByUserRole($roleName);
     }
    
}