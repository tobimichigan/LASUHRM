<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class orangehrmTimePluginAllTests {

    protected function setUp() {

    }

    public static function suite() {

        $suite = new PHPUnit_Framework_TestSuite('orangehrmTimePluginAllTest');

        /* Dao Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/TimesheetDaoTest.php');

        /* Service Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/service/TimesheetServiceTest.php');

         /* TimesheetPeriodService Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/service/TimesheetPeriodServiceTest.php');

	/* TimesheetPeriodDao Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/TimesheetPeriodDaoTest.php');
        
        /* MonthlyTimesheetPeriodTest*/
         $suite->addTestFile(dirname(__FILE__) . '/timesheetPeriod/MonthlyTimesheetPeriodTest.php');
         
         /* WeeklyTimesheetPeriodTest*/
         $suite->addTestFile(dirname(__FILE__) . '/timesheetPeriod/WeeklyTimesheetPeriodTest.php');


        return $suite;
    }

    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

}

if (PHPUnit_MAIN_METHOD == 'orangehrmTimePluginAllTests::main') {
    orangehrmTimePluginAllTests::main();
}
?>
