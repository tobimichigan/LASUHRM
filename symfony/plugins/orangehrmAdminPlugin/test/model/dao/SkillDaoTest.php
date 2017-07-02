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
class SkillDaoTest extends PHPUnit_Framework_TestCase {

	private $skillDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->skillDao = new SkillDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/SkillDao.yml';
		TestDataService::populate($this->fixture);
	}

    public function testAddSkill() {
        
        $skill = new Skill();
        $skill->setName('Gardening');
        $skill->setDescription('Flower arts');
        
        $this->skillDao->saveSkill($skill);
        
        $savedSkill = TestDataService::fetchLastInsertedRecord('Skill', 'id');
        
        $this->assertTrue($savedSkill instanceof Skill);
        $this->assertEquals('Gardening', $savedSkill->getName());
        $this->assertEquals('Flower arts', $savedSkill->getDescription());
        
    }
    
    public function testEditSkill() {
        
        $skill = TestDataService::fetchObject('Skill', 3);
        $skill->setDescription('Ability to help disabled people');
        
        $this->skillDao->saveSkill($skill);
        
        $savedSkill = TestDataService::fetchLastInsertedRecord('Skill', 'id');
        
        $this->assertTrue($savedSkill instanceof Skill);
        $this->assertEquals('Sign Language', $savedSkill->getName());
        $this->assertEquals('Ability to help disabled people', $savedSkill->getDescription());
        
    }
    
    public function testGetSkillById() {
        
        $skill = $this->skillDao->getSkillById(1);
        
        $this->assertTrue($skill instanceof Skill);
        $this->assertEquals('Driving', $skill->getName());
        $this->assertEquals('Ability to drive', $skill->getDescription());     
        
    }
    
    public function testGetSkillList() {
        
        $skillList = $this->skillDao->getSkillList();
        
        foreach ($skillList as $skill) {
            $this->assertTrue($skill instanceof Skill);
        }
        
        $this->assertEquals(3, count($skillList));        
        
        /* Checking record order */
        $this->assertEquals('Driving', $skillList[0]->getName());
        $this->assertEquals('Skydiving', $skillList[2]->getName());
        
    }
    
    public function testDeleteSkills() {
        
        $result = $this->skillDao->deleteSkills(array(1, 2));
        
        $this->assertEquals(2, $result);
        $this->assertEquals(1, count($this->skillDao->getSkillList()));       
        
    }
    
    public function testDeleteWrongRecord() {
        
        $result = $this->skillDao->deleteSkills(array(4));
        
        $this->assertEquals(0, $result);
        
    }
    
    public function testIsExistingSkillName() {
        
        $this->assertTrue($this->skillDao->isExistingSkillName('Driving'));
        $this->assertTrue($this->skillDao->isExistingSkillName('DRIVING'));
        $this->assertTrue($this->skillDao->isExistingSkillName('driving'));
        $this->assertTrue($this->skillDao->isExistingSkillName('  Driving  '));
        
    }
    
    public function testGetSkillByName() {
        
        $object = $this->skillDao->getSkillByName('Driving');
        $this->assertTrue($object instanceof Skill);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->skillDao->getSkillByName('DRIVING');
        $this->assertTrue($object instanceof Skill);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->skillDao->getSkillByName('driving');
        $this->assertTrue($object instanceof Skill);
        $this->assertEquals(1, $object->getId());

        $object = $this->skillDao->getSkillByName('  Driving  ');
        $this->assertTrue($object instanceof Skill);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->skillDao->getSkillByName('Climbing');
        $this->assertFalse($object);        
        
    }    
    
}
