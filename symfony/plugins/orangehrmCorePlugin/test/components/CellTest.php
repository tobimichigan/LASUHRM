<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Test class for Cell.
 * @group Core
 * @group ListComponent
 */
class CellTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ListHeader
     */
    protected $cell;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->cell = new TestConcreteCell();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /** 
     * Tests the setHeader and getHeader methods.
     */
    public function testSetHeader() {
        
        // Simple object
        $header = new ListHeader();
        
        $this->cell->setHeader($header);       
        $this->assertEquals($header, $this->cell->getHeader());
        
        // decorated with sfOutputEscaperObjectDecorator
        $header2 = new ListHeader();
        $header2->setName("Test Header");
        $decoratedHeader = new sfOutputEscaperObjectDecorator(null, $header2);
        
        $this->cell->setHeader($decoratedHeader);
        $this->assertEquals($header2, $this->cell->getHeader());        

    }

    /**
     * Test the filterValue() method.
     */
    public function testFilterValue() {
        
        $value = "Test Value";
        $filteredValue = "XYZ Test";
        
        $mockHeader = $this->getMock('ListHeader', array('filterValue'));
        $mockHeader->expects($this->once())
                     ->method('filterValue')
                     ->with($value)                
                     ->will($this->returnValue($filteredValue));
        
        $this->cell->setHeader($mockHeader); 
        $this->assertEquals($filteredValue, $this->cell->publicFilter($value));         
    }
    
}

class TestConcreteCell extends Cell {
    
    /**
     * Expose the filterValue method for testing
     */
    public function publicFilter($value) {
        return $this->filterValue($value);
    }
    
}

