<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * @group Leave 
 */
class WorkWeekDaoTest extends PHPUnit_Framework_TestCase {

    private $workWeekDao;
    private $testCases;

    protected function setUp() {

        $this->testCases = sfYaml::load(sfConfig::get('sf_plugins_dir') . '/orangehrmLeavePlugin/test/fixtures/WorkWeekDao.yml');
        $this->workWeekDao = new WorkWeekDao();

        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmLeavePlugin/test/fixtures/WorkWeekDao.yml');
    }

    /**
     *
     * @cover IsWeekend
     */
    public function testIsWeekend() {

        $result = $this->workWeekDao->isWeekend('2010-08-15');
        $this->assertTrue($result);
    }

    /* test whether half day weekend */

    public function testHalfDayIsWeekend() {

        $result = $this->workWeekDao->isWeekend('2010-08-14');
        $this->assertFalse($result);
    }

    /* test whether half day is weekend not full day */

    public function testHalfDayIsWeekendNotFullDay() {

        $result = $this->workWeekDao->isWeekend('2010-08-14', false);
        $this->assertTrue($result);
    }

    /* test whether weekend not full day */

    public function testIsWeekendNotFullDay() {

        $result = $this->workWeekDao->isWeekend('2010-08-15', false);
        $this->assertFalse($result);
    }

    /* Tests for getWorkWeekList() */

    public function testGetWorkWeekListType() {

        $daysList = $this->workWeekDao->getWorkWeekList();

        foreach ($daysList as $day) {
            $this->assertTrue($day instanceof WorkWeek);
        }
    }

    /* Tests for counts getWorkWeekList */

    public function testGetWorkWeekListCount() {
        $daysList = $this->workWeekDao->getWorkWeekList();
        $this->assertEquals(2, count($daysList));
    }

    public function testGetWorkWeekListValuesAndOrder() {
        $daysList = $this->workWeekDao->getWorkWeekList();

        $this->assertEquals(0, $daysList[0]->getLength(1));
        $this->assertEquals(8, $daysList[0]->getLength(7));
        $this->assertEquals(4, $daysList[0]->getLength(6));
    }

    /* Tests for saveWorkWeek */

    public function testSaveWorkWeek() {

        $day = 2;
        $length = 8;

        $workWeek = TestDataService::fetchObject('WorkWeek', $day);
        $workWeek->setTue($length);

        $this->workWeekDao->saveWorkWeek($workWeek);
        $savedWorkWeek = TestDataService::fetchObject('WorkWeek', $day);
        $this->assertEquals($length, $savedWorkWeek->getLength(2));
    }

    /**
     * @expectedException DaoException
     */
    public function testSaveWorkWeekException() {

        $workWeek = $this->getMock('WorkWeek', array('save'));
        $workWeek->expects($this->once())
                ->method('save')
                ->will($this->throwException(new Exception()));

        $this->workWeekDao->saveWorkWeek($workWeek);
    }

    /* Tests for readWorkWeek */

    public function testReadWorkWeek() {

        $workWeek = $this->workWeekDao->readWorkWeek($this->testCases['WorkWeek'][0]['id']);

        $this->assertTrue($workWeek instanceof WorkWeek);
        $this->assertEquals($this->testCases['WorkWeek'][0]['mon'], $workWeek->getLength(1));
    }

    /* Tests for deleteWorkWeek */

    public function testDeleteWorkWeek() {
        $this->assertTrue($this->workWeekDao->deleteWorkWeek(2));
        $this->assertFalse(TestDataService::fetchObject('WorkWeek', 2) instanceof WorkWeek);
    }
    
    public function testSearchWorkWeek_AllResults() {
        $result = $this->workWeekDao->searchWorkWeek();
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(2, $result->count());
        
        foreach ($result as $index => $workWeek) {
            $this->assertTrue($workWeek instanceof WorkWeek);
            $this->assertEquals($this->testCases['WorkWeek'][$index]['id'], $workWeek->getId());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['operational_country_id'], $workWeek->getOperationalCountryId());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['mon'], $workWeek->getMon());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['tue'], $workWeek->getTue());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['wed'], $workWeek->getWed());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['thu'], $workWeek->getThu());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['fri'], $workWeek->getFri());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['sat'], $workWeek->getSat());
            $this->assertEquals($this->testCases['WorkWeek'][$index]['sun'], $workWeek->getSun());
        }
    }
    
    public function testSearchWorkWeek_SearchByWorkWeekId() {
        $result = $this->workWeekDao->searchWorkWeek(array('id' => 2));
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(1, $result->count());
        
        $workWeek = $result->getFirst();
        $this->assertTrue($workWeek instanceof WorkWeek);
        $this->assertEquals($this->testCases['WorkWeek'][1]['id'], $workWeek->getId());
        $this->assertEquals($this->testCases['WorkWeek'][1]['operational_country_id'], $workWeek->getOperationalCountryId());
        $this->assertEquals($this->testCases['WorkWeek'][1]['mon'], $workWeek->getMon());
        $this->assertEquals($this->testCases['WorkWeek'][1]['tue'], $workWeek->getTue());
        $this->assertEquals($this->testCases['WorkWeek'][1]['wed'], $workWeek->getWed());
        $this->assertEquals($this->testCases['WorkWeek'][1]['thu'], $workWeek->getThu());
        $this->assertEquals($this->testCases['WorkWeek'][1]['fri'], $workWeek->getFri());
        $this->assertEquals($this->testCases['WorkWeek'][1]['sat'], $workWeek->getSat());
        $this->assertEquals($this->testCases['WorkWeek'][1]['sun'], $workWeek->getSun());
        
        $result = $this->workWeekDao->searchWorkWeek(array('id' => -1));
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(0, $result->count());
    }
    
    public function testSearchWorkWeek_SearchByOperationalCountry_DefaultResultset() {
        $result = $this->workWeekDao->searchWorkWeek(array('operational_country_id' => null));
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(1, $result->count());
        
        $workWeek = $result->getFirst();
        $this->assertTrue($workWeek instanceof WorkWeek);
        $this->assertEquals($this->testCases['WorkWeek'][0]['id'], $workWeek->getId());
        $this->assertEquals($this->testCases['WorkWeek'][0]['operational_country_id'], $workWeek->getOperationalCountryId());
        $this->assertEquals($this->testCases['WorkWeek'][0]['mon'], $workWeek->getMon());
        $this->assertEquals($this->testCases['WorkWeek'][0]['tue'], $workWeek->getTue());
        $this->assertEquals($this->testCases['WorkWeek'][0]['wed'], $workWeek->getWed());
        $this->assertEquals($this->testCases['WorkWeek'][0]['thu'], $workWeek->getThu());
        $this->assertEquals($this->testCases['WorkWeek'][0]['fri'], $workWeek->getFri());
        $this->assertEquals($this->testCases['WorkWeek'][0]['sat'], $workWeek->getSat());
        $this->assertEquals($this->testCases['WorkWeek'][0]['sun'], $workWeek->getSun());
    }
    
    public function testSearchWorkWeek_SearchByOperationalCountry_ExactMatch() {
        $result = $this->workWeekDao->searchWorkWeek(array('operational_country_id' => 2));
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(1, $result->count());
        
        $workWeek = $result->getFirst();
        $this->assertTrue($workWeek instanceof WorkWeek);
        $this->assertEquals($this->testCases['WorkWeek'][1]['id'], $workWeek->getId());
        $this->assertEquals($this->testCases['WorkWeek'][1]['operational_country_id'], $workWeek->getOperationalCountryId());
        $this->assertEquals($this->testCases['WorkWeek'][1]['mon'], $workWeek->getMon());
        $this->assertEquals($this->testCases['WorkWeek'][1]['tue'], $workWeek->getTue());
        $this->assertEquals($this->testCases['WorkWeek'][1]['wed'], $workWeek->getWed());
        $this->assertEquals($this->testCases['WorkWeek'][1]['thu'], $workWeek->getThu());
        $this->assertEquals($this->testCases['WorkWeek'][1]['fri'], $workWeek->getFri());
        $this->assertEquals($this->testCases['WorkWeek'][1]['sat'], $workWeek->getSat());
        $this->assertEquals($this->testCases['WorkWeek'][1]['sun'], $workWeek->getSun());
    }
    
    public function testSearchWorkWeek_SearchByOperationalCountry_NoMatch() {
        $result = $this->workWeekDao->searchWorkWeek(array('operational_country_id' => 3));
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(0, $result->count());
    }

}
