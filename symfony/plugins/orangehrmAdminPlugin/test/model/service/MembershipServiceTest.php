<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Admin
 */
class MembershipServiceTest extends PHPUnit_Framework_TestCase {

    private $membershipService;
    private $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->membershipService = new MembershipService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/MembershipDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetMembershipList() {

        $membershipList = TestDataService::loadObjectList('Membership', $this->fixture, 'Membership');

        $membershipDao = $this->getMock('MembershipDao');
        $membershipDao->expects($this->once())
                ->method('getMembershipList')
                ->will($this->returnValue($membershipList));

        $this->membershipService->setMembershipDao($membershipDao);

        $result = $this->membershipService->getMembershipList();
        $this->assertEquals($result, $membershipList);
    }

    public function testGetMembershipById() {

        $membershipList = TestDataService::loadObjectList('Membership', $this->fixture, 'Membership');

        $membershipDao = $this->getMock('MembershipDao');
        $membershipDao->expects($this->once())
                ->method('getMembershipById')
                ->with(1)
                ->will($this->returnValue($membershipList[0]));

        $this->membershipService->setMembershipDao($membershipDao);

        $result = $this->membershipService->getMembershipById(1);
        $this->assertEquals($result, $membershipList[0]);
    }

    public function testDeleteMemberships() {

        $membershipList = array(1, 2, 3);

        $membershipDao = $this->getMock('MembershipDao');
        $membershipDao->expects($this->once())
                ->method('deleteMemberships')
                ->with($membershipList)
                ->will($this->returnValue(3));

        $this->membershipService->setMembershipDao($membershipDao);

        $result = $this->membershipService->deleteMemberships($membershipList);
        $this->assertEquals($result, 3);
    }

}

