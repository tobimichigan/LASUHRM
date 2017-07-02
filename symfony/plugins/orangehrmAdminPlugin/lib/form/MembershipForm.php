<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class MembershipForm extends BaseForm {

    private $membershipService;

    public function getMembershipService() {
        if (is_null($this->membershipService)) {
            $this->membershipService = new MembershipService();
            $this->membershipService->setMembershipDao(new MembershipDao());
        }
        return $this->membershipService;
    }

    public function configure() {

        $this->setWidgets(array(
            'membershipId' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'membershipId' => new sfValidatorNumber(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 50))
        ));

        $this->widgetSchema->setNameFormat('membership[%s]');
    }

    public function save() {

        $membershipId = $this->getValue('membershipId');
        if (!empty($membershipId)) {
            $membership = $this->getMembershipService()->getMembershipById($membershipId);
        } else {
            $membership = new Membership();
        }
        $membership->setName($this->getValue('name'));
        $membership->save();
    }

    public function getMembershipListAsJson() {

        $list = array();
        $membershipList = $this->getMembershipService()->getMembershipList();
        foreach ($membershipList as $membership) {
            $list[] = array('id' => $membership->getId(), 'name' => $membership->getName());
        }
        return json_encode($list);
    }

}

