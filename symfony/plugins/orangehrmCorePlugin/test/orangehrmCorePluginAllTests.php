<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class orangehrmCorePluginAllTests {

    protected function setUp() {

    }

    public static function suite() {

        $suite = new PHPUnit_Framework_TestSuite('orangehrmCorePluginAllTest');

        /* Component Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/components/ListHeaderTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/PropertyPopulatorTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/LinkCellTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/ButtonTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/LabelCellTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/SortableHeaderCellTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/ListHeaderTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/CheckboxTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/HeaderCellTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/ohrmCellFilterTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/EnumCellFilterTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/components/CellTest.php');
        
        /* Dao Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/dao/ConfigDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/dao/EmailDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/dao/HomePageDaoTest.php');
 
        /* Service Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/service/ConfigServiceTest.php');

        /* Factory Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/factory/SimpleUserRoleFactoryTest.php');

        /* AccessFlowStateMachine Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/AccessFlowStateMachineDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/AccessFlowStateMachineServiceTest.php');

        /* ReportGenerator Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/ReportableDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/ReportableServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/ReportGeneratorServiceTest.php');

        /* BaseService Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/service/BaseServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/BaseServiceDataTest.php');
        
        /* form validators */
        $suite->addTestFile(dirname(__FILE__) . '/form/validate/ohrmValidatorSchemaCompareTest.php');
        
        /* form widgets */
        $suite->addTestFile(dirname(__FILE__) . '/form/widget/ohrmWidgetFormTimeRangeTest.php');

        /* Extensions to Doctrine Models */
        $suite->addTestFile(dirname(__FILE__) . '/model/doctrine/PluginWorkflowStateMachineTest.php');        

        /* Authorization */
        $suite->addTestFile(dirname(__FILE__) . '/authorization/service/UserRoleManagerServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/manager/BasicUserRoleManagerTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/dao/ScreenPermissionDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/service/ScreenPermissionServiceTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/dao/ScreenDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/userrole/AdminUserRoleTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/userrole/SupervisorUserRoleTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/dao/DataGroupDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/service/DataGroupServiceTest.php');
        
        $suite->addTestFile(dirname(__FILE__) . '/authorization/dao/MenuDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/authorization/service/MenuServiceTest.php');
        
        return $suite;
    }

    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

}

if (PHPUnit_MAIN_METHOD == 'orangehrmCorePluginAllTests::main') {
    orangehrmCorePluginAllTests::main();
}

