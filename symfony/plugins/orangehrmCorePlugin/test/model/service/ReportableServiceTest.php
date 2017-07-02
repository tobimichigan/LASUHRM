<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * @group Core
 */
class ReportableServiceTest {

    private $reportableService;

    protected function setUp() {

        $this->reportableService = new ReportableService();
        TestDataService::truncateTables(array('Report', 'ReportGroup'));
        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ReportableService.yml');
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ReportableService.yml';
    }

    public function testSelectedFilterFields() {

        
    }

}

?>
