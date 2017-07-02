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
class LeavePeriodServiceGenerateEndDateTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {

        $this->leavePeriodService = new LeavePeriodService();

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'Yes'
     * nonLeapYearLeavePeriodStartDate = '02-01'
     * dateFormat = 'Y-m-d'
     */

    public function testGenerateEndDate() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2010-02-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2011-01-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate2() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2011-02-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-28', $leavePeriodEndDate);

    }

    public function testGenerateEndDate3() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2012-02-29');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2013-01-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate4() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2013-02-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2014-01-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate5() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2014-02-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2015-01-31', $leavePeriodEndDate);

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'Yes'
     * nonLeapYearLeavePeriodStartDate = '04-01'
     * dateFormat = 'Y-m-d'
     */

    public function testGenerateEndDate6() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2010-04-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2011-03-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate7() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2011-04-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-28', $leavePeriodEndDate);

    }

    public function testGenerateEndDate8() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2012-02-29');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2013-03-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate9() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2013-04-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2014-03-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate10() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2014-04-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2015-03-31', $leavePeriodEndDate);

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'Yes'
     * dateFormat = 'Y-m-d'
     *
     * These tests checks cases where current
     * leave period is changed and end date is
     * expanded
     */

    public function testGenerateEndDate11() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('02-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2010-01-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2011-01-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate12() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('Yes');
        $leavePeriodDataHolder->setNonLeapYearLeavePeriodStartDate('04-01');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2010-01-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2011-03-31', $leavePeriodEndDate);

    }

    /*
     * Following tests share these criteria
     * isLeavePeriodStartOnFeb29th = 'No'
     * dateFormat = 'Y-m-d'
     */

    public function testGenerateEndDate13() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2010-01-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2010-12-31', $leavePeriodEndDate);

    }

    public function testGenerateEndDate14() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2011-12-15');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2012-12-14', $leavePeriodEndDate);

    }

    public function testGenerateEndDate15() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2012-01-20');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2013-01-19', $leavePeriodEndDate);

    }

    public function testGenerateEndDate16() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2013-01-20');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2014-01-19', $leavePeriodEndDate);

    }

    /**
     * Testing end date falling into Feb 29th
     */
    public function testGenerateEndDate17() {

        $leavePeriodDataHolder = new LeavePeriodDataHolder();

        $leavePeriodDataHolder->setIsLeavePeriodStartOnFeb29th('No');
        $leavePeriodDataHolder->setDateFormat('Y-m-d');

        $leavePeriodDataHolder->setLeavePeriodStartDate('2011-03-01');

        $leavePeriodEndDate = $this->leavePeriodService->generateEndDate($leavePeriodDataHolder);
        $this->assertEquals('2012-02-29', $leavePeriodEndDate);

    }







}
