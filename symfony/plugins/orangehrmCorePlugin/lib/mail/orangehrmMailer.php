<?php
/**
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
*/

abstract class orangehrmMailer {

    protected $mailer;
    protected $transport;
    protected $message;
    protected $logPath;

    public function getMailer() {
        return $this->mailer;
    }

    public function setMailer($mailer) {
        $this->mailer = $mailer;
    }

    public function getTransport() {
        return $this->transport;
    }

    public function setTransport($transport) {
        $this->transport = $transport;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getLogPath() {
        return $this->logPath;
    }

    public function setLogPath($logPath) {
        $this->logPath = $logPath;
    }

    public function  __construct() {

        $orangehrmMailTransport = new orangehrmMailTransport();
        $this->transport = $orangehrmMailTransport->getTransport();
        $this->mailer = empty($this->transport)?null:Swift_Mailer::newInstance($this->transport);
        $this->message = Swift_Message::newInstance();
        $this->logPath = ROOT_PATH . '/lib/logs/notification_mails.log';

    }

    public function getSystemFrom() {

        $emailConfigurationService = new EmailConfigurationService();
        $emailConfig = $emailConfigurationService->getEmailConfiguration();
        return array($emailConfig->getSentAs() => 'OrangeHRM');

    }

    public function logResult($type = '', $logMessage = '') {

        if (file_exists($this->logPath) && !is_writable($this->logPath)) {
            throw new Exception("Email Notifications : Log file is not writable");
        }

        $message = '========== Message Begins ==========';
        $message .= "\r\n\n";
        $message .= 'Time : '.date("F j, Y, g:i a");
        $message .= "\r\n";
        $message .= 'Message Type : '.$type;
        $message .= "\r\n";
        $message .= 'Message : '.$logMessage;
        $message .= "\r\n\n";
        $message .= '========== Message Ends ==========';
        $message .= "\r\n\n";

        file_put_contents($this->logPath, $message, FILE_APPEND);

    }


}

