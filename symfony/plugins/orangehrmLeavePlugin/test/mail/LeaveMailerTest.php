<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of LeaveMailerTest
 */
class LeaveMailerTest extends PHPUnit_Framework_TestCase {
    protected $mailer;
    
    protected function setUp() {
        $this->mailer = new LeaveMailer();
    }
    
    public function testListenOneWorkflow() {
        
        $workFlow = new WorkflowStateMachine();
        $workFlow->setAction('apply');
        $workFlow->setRolesToNotify('ESS,Supervisor,ABC');
        $workFlow->setRole('ess');
        
        $eventData = array('workFlow' => $workFlow);
        $emailType = 'leave.apply';
        
        $recipientRoles = array('ESS', 'Supervisor', 'ABC');
        
        $mockService = $this->getMock('EmailService', array('sendEmailNotifications'));
        $mockService->expects($this->once())
                ->method('sendEmailNotifications')
                ->with($emailType, $recipientRoles, $eventData, 'ess');
        
        $this->mailer->setEmailService($mockService);
        $sfEvent = new sfEvent($this, 'test', $eventData);
        $this->mailer->listen($sfEvent);
    }  
}
