<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class orangehrmAdminPluginAllTests {

    protected function setUp() {

    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('orangehrmCoreLeavePluginAllTest');

        /* Dao Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/SystemUserDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/SkillDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/OrganizationDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/CompanyStructureDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/ProjectDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/JobTitleDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/CustomerDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/LocationDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/OperationalCountryDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/CountryDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/EmploymentStatusDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/SkillDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/LanguageDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/LicenseDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/EducationDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/MembershipDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/NationalityDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/PayGradeDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/JobCategoryDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/EmailNotificationDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/WorkShiftDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/ModuleDaoTest.php');

        /* Service Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/service/LocalizationServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/PimCsvDataImportServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/CompanyStructureServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/JobTitleServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/CustomerServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/ProjectServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/LocationServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/OperationalCountryServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/CountryServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/EmploymentStatusServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/MembershipServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/NationalityServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/PayGradeServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/JobCategoryServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/WorkShiftServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/SystemUserServiceTest.php');
        
        return $suite;
    }

    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

}

if (PHPUnit_MAIN_METHOD == 'orangehrmAdminPluginAllTests::main') {
    orangehrmCoreLeavePluginAllTests::main();
}

?>
