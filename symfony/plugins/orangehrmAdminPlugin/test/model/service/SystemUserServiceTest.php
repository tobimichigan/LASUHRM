<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of SystemUserServiceTest
 *
 */
class SystemUserServiceTest extends PHPUnit_Framework_TestCase {
    
    /** @property SystemUserService $systemUserService */
    private $systemUserService;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->systemUserService = new SystemUserService();
    }
    
    /**
     * @covers SystemUserService::getNonPredefinedUserRoles
     */  
    public function testGetNonPredefinedUserRoles() {
        $userRoles = new Doctrine_Collection('UserRole');

        for ($i = 0; $i < 2; $i++) {
            $userRole = new UserRole();
            $userRole->setId($i+1);
            $userRole->setName("test name".$i+1);
            $userRole->setIsAssignable(1);
            $userRole->setIsPredefined(0);
            $userRoles->add($userRole);
        }
        
        $dao = $this->getMock('SystemUserDao');
        
        $dao->expects($this->once())
             ->method('getNonPredefinedUserRoles')
             ->will($this->returnValue($userRoles));
        
        $this->systemUserService->setSystemUserDao($dao);
        $result = $this->systemUserService->getNonPredefinedUserRoles();
        
         $this->assertEquals($userRoles, $result);
    }
}

