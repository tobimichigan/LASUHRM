<?php


/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Admin
 */
class LocalizationServiceTest extends PHPUnit_Framework_TestCase {

    private $localizationService;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->localizationService = new LocalizationService();
    }

    public function testConvertPHPFormatDateToISOFormatDate() {

       $this->assertEquals("1988-03-11", $this->localizationService->convertPHPFormatDateToISOFormatDate('d-m-Y', "11-03-1988"));
       $this->assertEquals("Invalid date", $this->localizationService->convertPHPFormatDateToISOFormatDate('d-m-Y', "1988-03-11"));

       $this->assertEquals("1988-03-11", $this->localizationService->convertPHPFormatDateToISOFormatDate('m-d-Y', "03-11-1988"));
       $this->assertEquals("Invalid date", $this->localizationService->convertPHPFormatDateToISOFormatDate('m-d-Y', "1988-00-11"));

       $this->assertEquals("1988-03-11", $this->localizationService->convertPHPFormatDateToISOFormatDate('Y-d-m', "1988-11-03"));
       $this->assertEquals("Invalid date", $this->localizationService->convertPHPFormatDateToISOFormatDate('Y-d-m', "1988-1223"));
    }

}
