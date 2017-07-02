<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Pim
 */
class EmployeeListDaoTest extends PHPUnit_Framework_TestCase {
    private $testCase;
    private $employeeDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->employeeDao = new EmployeeDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmPimPlugin/test/fixtures/EmployeeDao.yml';
        TestDataService::populate($this->fixture);
    }
    
   
    public function testSearchEmployeeList() {
        $result = $this->employeeDao->searchEmployees($this->_getParameterHolder());
        
         $this->assertTrue( $result instanceof Doctrine_Collection);
    }
    
    public function testGetEmployeeCount(){
         $result = $this->employeeDao->getSearchEmployeeCount();
         $this->assertEquals(5,$result);
    }
    
    public function testSearchEmployeeListByFirstName(){
      
         $result = $this->employeeDao->searchEmployees($this->_getParameterHolder());
         $this->assertEquals( $result[0]->getFirstName(),'Kayla');
         $this->assertEquals(1,count($result));
    }
    
    private function _getParameterHolder() {
        
         $filters = array ( 
                        'employee_name' => 'Kayla',
                        'id'=>'',
                        'employee_status' => 0,
                        'termination' => 1,
                        'supervisor_name' => '',
                        'job_title' => 0,
                        'sub_unit' => 0
                        );
         
         $parameterHolder = new EmployeeSearchParameterHolder();
         $parameterHolder->setFilters($filters);
         $parameterHolder->setOrderField('empNumber');
         
         return $parameterHolder;
        
    }
    

}
?>
