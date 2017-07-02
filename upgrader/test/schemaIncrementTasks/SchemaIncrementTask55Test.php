<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Test case for SchemaIncrementTask55
 *
 */
class SchemaIncrementTask55Test extends PHPUnit_Framework_TestCase {

    protected $schema;
    
    /**
     * Set up method
     */
    protected function setUp() {
        $this->schema = new SchemaIncrementTask55();
    }

    public function testGetLeavePeriodHistoryRecordsOnePeriodDefault() {
        $periods = array(
            array('leave_period_id' => 1, 'leave_period_start_date' => '2013-01-01', 
                'leave_period_end_date' => '2013-12-31')
        );

        $expected = array(
            array('1', '1', '2013-01-01')
        );

        $history = $this->schema->getLeavePeriodHistoryRecords($periods);
        $this->assertEquals($expected, $history);
    }
    
    public function testGetLeavePeriodHistoryRecordsOnePeriodCustom() {
        $periods = array(
            array('leave_period_id' => 1, 'leave_period_start_date' => '2013-03-07', 
                'leave_period_end_date' => '2014-03-06')
        );

        $expected = array(
            array('7', '3', '2013-03-07')
        );

        $history = $this->schema->getLeavePeriodHistoryRecords($periods);
        $this->assertEquals($expected, $history);
    }    

    public function testGetLeavePeriodHistoryRecordsManyPeriodsDefaultNoChange() {
        $periods = array(
            array('leave_period_id' => 1, 'leave_period_start_date' => '2013-01-01', 
                'leave_period_end_date' => '2013-12-31'),
            array('leave_period_id' => 1, 'leave_period_start_date' => '2014-01-01', 
                'leave_period_end_date' => '2014-12-31'),  
            array('leave_period_id' => 1, 'leave_period_start_date' => '2015-01-01', 
                'leave_period_end_date' => '2015-12-31'),              
        );

        $expected = array(
            array('1', '1', '2013-01-01')
        );

        $history = $this->schema->getLeavePeriodHistoryRecords($periods);
        $this->assertEquals($expected, $history);
    }   
    
    public function testGetLeavePeriodHistoryRecordsManyPeriodsCustomNoChange() {
        $periods = array(
            array('leave_period_id' => 1, 'leave_period_start_date' => '2013-04-21', 
                'leave_period_end_date' => '2014-04-20'),
            array('leave_period_id' => 1, 'leave_period_start_date' => '2014-04-21', 
                'leave_period_end_date' => '2015-04-20'),
            array('leave_period_id' => 1, 'leave_period_start_date' => '2015-04-21', 
                'leave_period_end_date' => '2016-04-20'),            
        );

        $expected = array(
            array('21', '4', '2013-04-21')
        );

        $history = $this->schema->getLeavePeriodHistoryRecords($periods);
        $this->assertEquals($expected, $history);
    }     
    
    public function testGetLeavePeriodHistoryRecordsManyWithOneChange() {
        $periods = array(
            array('leave_period_id' => 1, 'leave_period_start_date' => '2013-01-01', 
                'leave_period_end_date' => '2014-01-31'),
            array('leave_period_id' => 1, 'leave_period_start_date' => '2014-02-01', 
                'leave_period_end_date' => '2015-01-31')          
        );

        $expected = array(
            array('1', '1', '2013-01-01'),
            array('1', '2', '2013-12-30')
        );

        $history = $this->schema->getLeavePeriodHistoryRecords($periods);
        $this->assertEquals($expected, $history);
    }      
}

