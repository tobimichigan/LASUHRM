<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Test class for ohrmCellFilter abstract class
 * @group Core
 * @group ListComponent
 */
class EnumCellFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @var filter
     */
    protected $filter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->filter = new EnumCellFilter();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    /**
     * Test the filter() method.
     */
    public function testFilter() {
        
        // Without enum. Should return default 'default': ''
        $value = 4;
        $this->assertEquals('', $this->filter->filter($value));
        
        // With enum, but without that value
        $this->filter->setEnum(array(1 => "Xyz", 2 => "basic"));        
        $this->assertEquals('', $this->filter->filter($value));
        
        // With enum, without that value, with default defined.
        $default = "-";
        $this->filter->setDefault($default);
        $this->assertEquals($default, $this->filter->filter($value));
        
        // With enum which includes given value
        $this->filter->setEnum(array(1 => "Xyz", 2 => "basic", 4 => 'OK', 5 => 'NOK'));
        $this->assertEquals('OK', $this->filter->filter($value));
        
    }
    
    /**
     * Test the get/set methods
     */
    public function testGetSetMethods() {
        $filter = array('2' => "test", "4" => "xyz");
        $this->filter->setEnum($filter);
        $this->assertEquals($filter, $this->filter->getEnum());
        
        $default = 'Z1';
        $this->filter->setDefault($default);
        $this->assertEquals($default, $this->filter->getDefault());        
    }

}





