<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Form class for EmailConfigurationForm
 */
class EmailConfigurationForm extends BaseForm {

    private $emailConfigurationService;
    private $emailConfiguration;

    /**
     * 
     * @return EmailConfigurationService 
     */
    public function getEmailConfigurationService() {
        if (is_null($this->emailConfigurationService)) {
            $this->emailConfigurationService = new EmailConfigurationService();
        }
        return $this->emailConfigurationService;
    }

    public function configure() {

        /* Widgests */
        $this->setWidgets(array(
            'txtMailAddress' => new sfWidgetFormInputText(),
            'cmbMailSendingMethod' => new sfWidgetFormSelect(
                    array(
                        'choices' => array(
                            'sendmail' => 'Sendmail',
                            'smtp' => 'SMTP')
                        )),
            'txtSendmailPath' => new sfWidgetFormInputText(),
            'txtSmtpHost' => new sfWidgetFormInputText(),
            'txtSmtpPort' => new sfWidgetFormInputText(),
            'optAuth' => new sfWidgetFormChoice(
                    array(
                        'expanded' => true, 
                        'choices' => array(
                            'none' => 'No', 
                            'login' => 'Yes')
                        )),
            'txtSmtpUser' => new sfWidgetFormInputText(),
            'txtSmtpPass' => new sfWidgetFormInputPassword(),
            'optSecurity' => new sfWidgetFormChoice(
                    array(
                        'expanded' => true, 
                        'choices' => array(
                            'none' => 'No', 
                            'ssl' => 'SSL',
                            'tls'  => 'TLS')
                        )),            
            'chkSendTestEmail' => new sfWidgetFormInputCheckbox(),
            'txtTestEmail' => new sfWidgetFormInputText(),
        ));
        
        // validators
        $this->setValidators(array(
            'txtMailAddress' => new sfValidatorEmail(array('required' => true, 'max_length' => 100)),
            'cmbMailSendingMethod' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'txtSendmailPath' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'txtSmtpHost' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'txtSmtpPort' => new sfValidatorNumber(array('required' => false)),
            'optAuth' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'txtSmtpUser' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'txtSmtpPass' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'optSecurity' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'chkSendTestEmail' => new sfValidatorPass(array('required' => false)),
            'txtTestEmail' => new sfValidatorEmail(array('required' => false, 'max_length' => 100)),
        ));
        
        $this->widgetSchema['txtSmtpPass']->setOption('always_render_empty', false);

        // Set Default valuse
        $this->emailConfiguration= $this->getEmailConfigurationService()->getEmailConfiguration();
        $this->__setDefaultValues($this->emailConfiguration);
        
        $this->widgetSchema->setNameFormat('emailConfigurationForm[%s]');
        
     }
     
     private function __setDefaultValues(EmailConfiguration $emailConfiguration) {
         $this->setDefaults(array(
             'txtMailAddress' => $emailConfiguration->getSentAs(),
             'cmbMailSendingMethod' => $emailConfiguration->getMailType(),
             'txtSendmailPath' => $emailConfiguration->getSendmailPath(),
             'txtSmtpHost' => $emailConfiguration->getSmtpHost(),
             'txtSmtpPort' => $emailConfiguration->getSmtpPort(),
             'optAuth' => $emailConfiguration->getSmtpAuthType(),
             'txtSmtpUser' => $emailConfiguration->getSmtpUsername(),
             'txtSmtpPass' => $emailConfiguration->getSmtpPassword(),
             'optSecurity' => $emailConfiguration->getSmtpSecurityType(),
             'txtTestEmail' => '',
         ));
    }
    
    /**
     *  
     */
    public function save() {
        $this->emailConfiguration = (!empty($this->emailConfiguration)) ? $this->emailConfiguration : new EmailConfiguration();
        
        $stmpPort = $this->getValue('txtSmtpPort');
        $this->emailConfiguration->setSentAs($this->getValue('txtMailAddress'));
        $this->emailConfiguration->setMailType($this->getValue('cmbMailSendingMethod'));
        $this->emailConfiguration->setSendmailPath($this->getValue('txtSendmailPath'));
        $this->emailConfiguration->setSmtpHost($this->getValue('txtSmtpHost'));
        $this->emailConfiguration->setSmtpPort($stmpPort ? $stmpPort : NULL);
        $this->emailConfiguration->setSmtpAuthType($this->getValue('optAuth'));
        $this->emailConfiguration->setSmtpUsername($this->getValue('txtSmtpUser'));
        $this->emailConfiguration->setSmtpPassword($this->getValue('txtSmtpPass'));
        $this->emailConfiguration->setSmtpSecurityType($this->getValue('optSecurity'));
        $this->getEmailConfigurationService()->saveEmailConfiguration($this->emailConfiguration);
    }
    
}

?>