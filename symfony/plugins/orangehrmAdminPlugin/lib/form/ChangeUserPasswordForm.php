<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class ChangeUserPasswordForm extends BaseForm {

    public function configure() {

        $this->setWidgets(array(
            'userId' => new sfWidgetFormInputHidden(),
            'currentPassword' => new sfWidgetFormInputPassword(array(), array("class" => "formInputText", "maxlength" => 20)),
            'newPassword' => new sfWidgetFormInputPassword(array(), array("class" => "formInputText", "maxlength" => 20)),
            'confirmNewPassword' => new sfWidgetFormInputPassword(array(), array("class" => "formInputText", "maxlength" => 20))
        ));

        $this->setValidators(array(
            'userId' => new sfValidatorNumber(array('required' => false)),
            'currentPassword' => new sfValidatorString(array('required' => true, 'max_length' => 20)),
            'newPassword' => new sfValidatorString(array('required' => true, 'max_length' => 20)),
            'confirmNewPassword' => new sfValidatorString(array('required' => true, 'max_length' => 20))
        ));

        
        $this->widgetSchema->setNameFormat('changeUserPassword[%s]');

        $this->getWidgetSchema()->setLabels($this->getFormLabels());

        //merge secondary password
        $formExtension = PluginFormMergeManager::instance();
        $formExtension->mergeForms($this, 'changeUserPassword', 'ChangeUserPasswordForm');

    }

    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $requiredMarker = ' <em> *</em>';
        $labels = array(
            'userId' => false,
            'currentPassword' => __('Current Password')  . $requiredMarker,
            'newPassword' => __('New Password') . $requiredMarker,
            'confirmNewPassword' => __('Confirm New Password') . $requiredMarker,
            'currentPassword' => __('Current Password') . $requiredMarker,
        );

        return $labels;
    }

    public function save() {

        $userId = sfContext::getInstance()->getUser()->getAttribute('user')->getUserId();
        $systemUserService = new SystemUserService();
        $posts = $this->getValues();
        $systemUserService->updatePassword($userId, $posts['newPassword']);

        //save secondary password
        $formExtension = PluginFormMergeManager::instance();
        $formExtension->saveMergeForms($this, 'changeUserPassword', 'ChangeUserPasswordForm');
    }

}
