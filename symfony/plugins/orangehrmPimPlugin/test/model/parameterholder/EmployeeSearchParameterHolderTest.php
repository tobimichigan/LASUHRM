<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
 
class EmployeeSearchParameterHolderTest extends PHPUnit_Framework_TestCase {
    
    private $parameterHolder;
    
    public function setup() {
        $this->parameterHolder = new EmployeeSearchParameterHolder();
    }

    public function testOrderBy() {
        
        $result = $this->parameterHolder->getOrderBy();
        $this->assertEquals('ASC', $result);
        
        $this->parameterHolder->setOrderBy('DESC');
        $result = $this->parameterHolder->getOrderBy();
        $this->assertEquals('DESC', $result);
        
    }
    
    
    
} 