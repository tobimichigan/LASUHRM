<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of PluginWorkflowStateMachineTest
 */
class PluginWorkflowStateMachineTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {

    }
    
    public function testGetRolesToNotifyAsArray() {
        $workFlow = new WorkflowStateMachine();
        
        $workFlow->setRolesToNotify(NULL);
        $result = $workFlow->getRolesToNotifyAsArray();        
        $this->assertEquals(0, count($result));
        
        $workFlow->setRolesToNotify('');
        $result = $workFlow->getRolesToNotifyAsArray();        
        $this->assertEquals(0, count($result));
        
        $workFlow->setRolesToNotify('ESS');
        $result = $workFlow->getRolesToNotifyAsArray();        
        $this->assertEquals(array('ESS'), $result);

        $workFlow->setRolesToNotify('Ess,Supervisor,Subscriber');
        $result = $workFlow->getRolesToNotifyAsArray();        
        $this->assertEquals(array('Ess', 'Supervisor', 'Subscriber'), $result);
        
        $workFlow->setRolesToNotify(',,,');
        $result = $workFlow->getRolesToNotifyAsArray();        
        $this->assertEquals(0, count($result));          
    }
    
}
