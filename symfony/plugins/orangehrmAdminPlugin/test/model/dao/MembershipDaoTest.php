<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 *  @group Admin
 */
class MembershipDaoTest extends PHPUnit_Framework_TestCase {

    private $membershipDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->membershipDao = new MembershipDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/MembershipDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetMembershipList() {
        $result = $this->membershipDao->getMembershipList();
        $this->assertEquals(count($result), 3);
    }

    public function testGetMembershipById() {
        $result = $this->membershipDao->getMembershipById(1);
        $this->assertEquals($result->getName(), 'membership 1');
    }

    public function testDeleteMemberships() {
        $result = $this->membershipDao->deleteMemberships(array(1, 2, 3));
        $this->assertEquals($result, 3);
    }

}

