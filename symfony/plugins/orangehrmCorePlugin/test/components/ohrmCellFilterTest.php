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
class ohrmCellFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @var filter
     */
    protected $filter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->filter = new TestCellFilter();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    /**
     * Test the populateFromArray() method.
     */
    public function testPopulateFromArray() {
        $this->filter->populateFromArray(array('value' => 'xyz', 'name' => 'test'));
        $this->assertEquals('xyz', $this->filter->getValue());
        $this->assertEquals('test', $this->filter->getName());
    }

}

class TestCellFilter extends ohrmCellFilter {
    
    private $value;
    
    private $name;
    
    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    public function filter($value) {}
}




