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
class ReportableDaoTest extends PHPUnit_Framework_TestCase {

    private $reportableDao;

    /* Set up method */

    protected function setUp() {

        $this->reportableDao = new ReportableDao();
        TestDataService::truncateTables(array('SelectedCompositeDisplayField','CompositeDisplayField','DisplayField', 'SelectedGroupField', 'GroupField', 'SelectedDisplayField', 'SelectedFilterField', 'FilterField', 'Report', 'ReportGroup', 'ProjectActivity', 'Project', 'Customer'));
        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ReportableDao.yml');
    }

    /* Test case for getSelectedFilterFields method */

    public function testGetSelectedFilterFields() {

        $reportId = 1;
        $results = $this->reportableDao->getSelectedFilterFields($reportId);

        $this->assertTrue($results[0] instanceOf SelectedFilterField);
        $this->assertEquals(2, count($results));
        $this->assertEquals(1, $results[0]->getFilterFieldId());
        $this->assertEquals('3000', $results[0]->getValue1());
    }

    /* Test case for getSelectedDisplayFields method */

    public function testGetSelectedDisplayFields() {

        $reportId = 1;
        $results = $this->reportableDao->getSelectedDisplayFields($reportId);

        $this->assertTrue($results[0] instanceOf SelectedDisplayField);
        $this->assertEquals(2, count($results));
        $this->assertEquals(2, $results[1]->getDisplayFieldId());
        $this->assertEquals(1, $results[1]->getReportId());
        $this->assertEquals(2, $results[1]->getId());
    }

    /* Test case for getSelectedCompositeDisplayFields method */

    public function testGetSelectedCompositeDisplayFields() {

        $reportId = 1;
        $results = $this->reportableDao->getSelectedCompositeDisplayFields($reportId);

        $this->assertTrue($results[0] instanceOf SelectedCompositeDisplayField);
        $this->assertEquals(2, count($results));
        $this->assertEquals(2, $results[1]->getCompositeDisplayFieldId());
        $this->assertEquals(1, $results[1]->getReportId());
        $this->assertEquals(2, $results[1]->getId());
    }

    /* Test case for getMetaDisplayFields method */

    public function testGetMetaDisplayFields() {

        $reportGroupId = 1;
        $results = $this->reportableDao->getMetaDisplayFields($reportGroupId);

        $this->assertTrue($results[0] instanceOf DisplayField);
        $this->assertEquals(2, count($results));
    }

    /* Test case for getMetaDisplayFields for non existing reportId method */

    public function testGetMetaDisplayFieldsNonExistingReportGroupId() {

        $reportGroupId = 111;
        $results = $this->reportableDao->getMetaDisplayFields($reportId);

        $this->assertEquals(0, count($results));
    }

    /* Test case for getReport method */

    public function testGetReport() {

        $reportId = 1;
        $result = $this->reportableDao->getReport($reportId);

        $this->assertTrue($result instanceof Report);
        $this->assertEquals('project report', $result->getName());
    }

    /* Test case for getReportGroup method */

    public function testGetReportGroup() {

        $reportGroupId = 1;
        $result = $this->reportableDao->getReportGroup($reportGroupId);

        $this->assertTrue($result instanceof ReportGroup);
        $this->assertEquals('timesheet', $result->getName());
    }

    /* Tests getGroupField method */

    public function testGetGroupField() {

        $groupFieldId = 1;

        $groupField = $this->reportableDao->getGroupField($groupFieldId);

        $this->assertTrue($groupField instanceof GroupField);
        $this->assertEquals(1, $groupField->getGroupFieldId());
        $this->assertEquals("activity id", $groupField->getName());
        $this->assertEquals("GROUP BY ohrm_project_activity.activity_id", $groupField->getGroupByClause());
    }

    /* Tests getGroupField method */

    public function testGetGroupFieldForNonExistingGroupField() {

        $groupFieldId = 34;

        $groupField = $this->reportableDao->getGroupField($groupFieldId);

        $this->assertEquals(null, $groupField);
    }

    /* Tests getSelectedGroupField method */

    public function testGetSelectedGroupField() {

        $reportId = 1;

        $selectedGroupField = $this->reportableDao->getSelectedGroupField($reportId);

        $this->assertTrue($selectedGroupField instanceof SelectedGroupField);
        $this->assertEquals(1, $selectedGroupField->getGroupFieldId());
        $this->assertEquals(1, $selectedGroupField->getSummaryDisplayFieldId());
        $this->assertEquals(1, $selectedGroupField->getReportId());
    }

    /* Tests getSelectedGroupField method */

    public function testGetSelectedGroupFieldForNonExistingSelectedGroupField() {

        $reportId = 43;

        $selectedGroupField = $this->reportableDao->getSelectedGroupField($reportId);

        $this->assertEquals(null, $selectedGroupField);
    }

    /* Test executeSql method */

    public function testExecuteSql() {

        $sql = "SELECT * FROM ohrm_report";

        $result = $this->reportableDao->executeSql($sql);

        $this->assertEquals(2, count($result));
        $this->assertEquals("project report", $result[0]["name"]);
        $this->assertEquals(2, $result[1]["report_id"]);
    }

    /* Test getFilterFieldById when the existing id is given as parameter method */

    public function testGetFilterFieldByIdWithExistingId() {

        $filterFieldId = 1;

        $filterField = $this->reportableDao->getFilterFieldById($filterFieldId);

        $this->assertTrue($filterField instanceof FilterField);
        $this->assertEquals(1, $filterField->getFilterFieldId());
        $this->assertEquals("project_name", $filterField->getName());
    }

    /* Test getFilterFieldById when the non existing id is given as parameter method */

    public function testGetFilterFieldByIdWithNonExistingId() {

        $filterFieldId = 130;

        $filterField = $this->reportableDao->getFilterFieldById($filterFieldId);

        $this->assertEquals(null, $filterField);
    }

    /* Test getProjectActivityByActivityId method */

    public function testGetProjectActivityByActivityId() {

        $activityId = 1;

        $activity = $this->reportableDao->getProjectActivityByActivityId($activityId);

        $this->assertTrue($activity instanceof ProjectActivity);
        $this->assertEquals(1, $activity->getActivityId());
        $this->assertEquals("Create Schema", $activity->getName());
    }

}
