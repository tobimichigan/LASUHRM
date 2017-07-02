<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Leave Mail observer
 */
class LeaveMailer implements ohrmObserver {
    
    protected $emailService;
    
    /**
     * Get email service instance
     * @return EmailService
     */
    public function getEmailService() {
        if (empty($this->emailService)) {
            $this->emailService = new EmailService();
        }
        return $this->emailService;
    }

    public function setEmailService(EmailService $emailService) {
        $this->emailService = $emailService;
    }

    public function listen(sfEvent $event) {
                
        $logger = Logger::getLogger('leave.leavemailer');
        
        $eventData = $event->getParameters();
        
        if ($logger->isDebugEnabled()) {
            $logger->debug('Got event');
        }        
        
        if (isset($eventData['workFlow']) && 
                (($eventData['workFlow'] instanceof WorkflowStateMachine) 
                        || (is_array($eventData['workFlow']) && count($eventData['workFlow'])> 0))) {
            
            $recipientRoles = array();            
            $performerRole = null;
            $workFlow = $eventData['workFlow'];
            
            if (is_array($workFlow)) {
                
                // Multiple workflows
                if ($logger->isDebugEnabled()) {
                    $logger->debug("Multiple workflows in event");
                }                 
                
                $emailType = 'leave.change';
                
                $firstFlow = array_shift(array_values($workFlow));
                $performerRole = $firstFlow->getRole();
                
                foreach ($workFlow as $item) {
                    $roles = $item->getRolesToNotifyAsArray();
                    $recipientRoles = array_unique($recipientRoles + $roles);                    
                }
            } else {
                $recipientRoles = $workFlow->getRolesToNotifyAsArray();
                $performerRole = $workFlow->getRole();
                $emailType = 'leave.' . strtolower($workFlow->getAction());                                    
            }

            if ($logger->isDebugEnabled()) {
                $logger->debug("Email type: $emailType, Roles: " . print_r($recipientRoles, true));
            } 
            
            if (count($recipientRoles) > 0) {                 
                $this->getEmailService()->sendEmailNotifications($emailType, $recipientRoles, $eventData, 
                        strtolower($performerRole));                  
            } 
        } else {
            $logger->warn('event did not contain valid workFlow');
        }            
        
    }
}
