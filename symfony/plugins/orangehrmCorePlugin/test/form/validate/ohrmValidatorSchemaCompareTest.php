<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Test class ohrmValidatorSchemaCompare
 * @group core
 */
class ohrmValidatorSchemaCompareTest extends PHPUnit_Framework_TestCase {
    
    public function testDoClean() {
        
        // Check default functionality (same as base class)
        $validator = new ohrmValidatorSchemaCompare('from', 
                        sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'to',
                        array('throw_global_error' => true));
        
        $values = array('from' => 100, 'to' => 200, 'a' => 100, 'toto' => 239);
        $cleaned = $validator->clean($values);
        $this->assertEquals($cleaned, $values);
        
        $values = array('from' => 201, 'to' => 200, 'a' => 100, 'toto' => 239);
        try {
            $cleaned = $validator->clean($values);
            $this->fail("Validation error expected");
        } catch (sfValidatorError $error) {
            // expected.
        }        
    }
    
    public function testDoCleanSkipIfOneEmpty() {
        // Check default functionality (same as base class)
        $validator = new ohrmValidatorSchemaCompare('from', 
                        sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'to',
                        array('throw_global_error' => true));
        
        $values = array('from' => 100, 'to' => '', 'a' => 100, 'toto' => 239);
        try {
            $cleaned = $validator->clean($values);
            $this->fail("Validation error expected");
        } catch (sfValidatorError $error) {
            // expected.
        }        
        
        $validator = new ohrmValidatorSchemaCompare('from', 
                        sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'to',
                        array('throw_global_error' => true,
                              'skip_if_one_empty' => true));
        $cleaned = $validator->clean($values);
        $this->assertEquals($cleaned, $values);                     
    }
    
    public function testDoCleanSkipIfBothEmpty() {
        
        // Check default functionality (same as base class)
        $validator = new ohrmValidatorSchemaCompare('from', 
                        sfValidatorSchemaCompare::IDENTICAL, 'to',
                        array('throw_global_error' => true));
        
        $values = array('to' => '', 'a' => 100, 'toto' => 239);
        try {
            $cleaned = $validator->clean($values);
            $this->fail("Validation error expected");
        } catch (sfValidatorError $error) {
            // expected.
        }        
        
        $validator = new ohrmValidatorSchemaCompare('from', 
                        sfValidatorSchemaCompare::IDENTICAL, 'to',
                        array('throw_global_error' => true,
                              'skip_if_both_empty' => true));
        $cleaned = $validator->clean($values);
        $this->assertEquals($cleaned, $values);         
    }
}

