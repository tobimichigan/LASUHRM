<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of orangehrmLeavePluginConfiguration
 *
 */
class orangehrmLeavePluginConfiguration extends sfPluginConfiguration {

    protected static $eventsBound = false;
    
    public function initialize() {
        
        // plugin configuration can be instantiated twice when running symfony command line tasks
        if (!self::$eventsBound) {
            
            $this->dispatcher->connect(LeaveEvents::LEAVE_CHANGE, array(new LeaveMailer(), 'listen'));            
            self::$eventsBound = true;
        }
    }
}