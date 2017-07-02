<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
/**
 * @group Leave 
 */
class LeavePeriodServiceGenerateStartDateTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {

        $this->leavePeriodService = new LeavePeriodService();

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'Yes'
     * nonLeapYearLeavePeriodStartDate = '02-01'
     * dateFormat = 'Y-m-d'
     */


    public function testGenerateStartDate() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2010-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2010-02-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate2() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2011-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2011-02-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate3() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2012-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-29', $leavePeriodStartDate);

    }

    public function testGenerateStartDate4() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2013-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2013-02-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate5() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2014-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2014-02-01', $leavePeriodStartDate);

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'Yes'
     * nonLeapYearLeavePeriodStartDate = '04-01'
     * dateFormat = 'Y-m-d'
     */

    public function testGenerateStartDate6() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2010-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2010-04-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate7() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2011-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2011-04-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate8() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2012-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-29', $leavePeriodStartDate);

    }

    public function testGenerateStartDate9() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2013-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2013-04-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate10() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2014-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2014-04-01', $leavePeriodStartDate);

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'No'
     * dateFormat = 'Y-m-d'
     */

    public function testGenerateStartDate11() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2010-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2010-04-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate12() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2010-01-20');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2009-04-01', $leavePeriodStartDate);

    }

    public function testGenerateStartDate13() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setStartDate('03-05');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2011-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2011-03-05', $leavePeriodStartDate);

    }

    public function testGenerateStartDate14() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setStartDate('01-15');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2012-10-04');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2012-01-15', $leavePeriodStartDate);

    }

    /* Testing margins */

    public function testGenerateStartDate15() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2012-02-29');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-29', $leavePeriodStartDate);

    }

    public function testGenerateStartDate16() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setCurrentDate('2014-04-01');

        $leavePeriodStartDate = $this->leavePeriodService->generateStartDate($leavePeriodDataHolder);
        $this->assertEquals('2014-04-01', $leavePeriodStartDate);

    }



}

