<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Test case for ohrmWidgetFormTimeRangeTest
 * @group core
 */
class ohrmWidgetFormTimeRangeTest extends PHPUnit_Framework_TestCase {
    
    private $widget;
    
    public function setup() {

        $this->widget = new ohrmWidgetFormTimeRange(array(
            'from_time' => '',
            'to_time' => ''));
    }
    
    public function testGetTimeDifference() {
        
        $this->assertEquals('', $this->widget->getTimeDifference('', ''));        
        $this->assertEquals('0.00', $this->widget->getTimeDifference('12:00', '12:00'));
        $this->assertEquals('-0.50', $this->widget->getTimeDifference('12:30', '12:00'));
        $this->assertEquals('1.17', $this->widget->getTimeDifference('11:00', '12:10'));
        $this->assertEquals('2.17', $this->widget->getTimeDifference('15:00', '17:10'));
    }
}

