<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class MembershipService extends BaseService {

    private $membershipDao;

    public function __construct() {
        $this->membershipDao = new MembershipDao();
    }

    public function getMembershipDao() {
        return $this->membershipDao;
    }

    public function setMembershipDao(MembershipDao $MembershipDao) {
        $this->membershipDao = $MembershipDao;
    }

    public function getMembershipList() {
        return $this->membershipDao->getMembershipList();
    }

    public function getMembershipById($id) {
        return $this->membershipDao->getMembershipById($id);
    }

    public function deleteMemberships($membershipList) {
        return $this->membershipDao->deleteMemberships($membershipList);
    }

}

