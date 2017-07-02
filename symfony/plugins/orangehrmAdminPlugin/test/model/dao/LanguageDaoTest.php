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
class LanguageDaoTest extends PHPUnit_Framework_TestCase {

	private $languageDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->languageDao = new LanguageDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/LanguageDao.yml';
		TestDataService::populate($this->fixture);
	}

    public function testAddLanguage() {
        
        $language = new Language();
        $language->setName('Tamil');
        
        $this->languageDao->saveLanguage($language);
        
        $savedLanguage = TestDataService::fetchLastInsertedRecord('Language', 'id');
        
        $this->assertTrue($savedLanguage instanceof Language);
        $this->assertEquals('Tamil', $savedLanguage->getName());
        
    }
    
    public function testEditLanguage() {
        
        $language = TestDataService::fetchObject('Language', 3);
        $language->setName('Canadian French');
        
        $this->languageDao->saveLanguage($language);
        
        $savedLanguage = TestDataService::fetchLastInsertedRecord('Language', 'id');
        
        $this->assertTrue($savedLanguage instanceof Language);
        $this->assertEquals('Canadian French', $savedLanguage->getName());
        
    }
    
    public function testGetLanguageById() {
        
        $language = $this->languageDao->getLanguageById(1);
        
        $this->assertTrue($language instanceof Language);
        $this->assertEquals('Spanish', $language->getName());
        
    }
    
    public function testGetLanguageList() {
        
        $languageList = $this->languageDao->getLanguageList();
        
        foreach ($languageList as $language) {
            $this->assertTrue($language instanceof Language);
        }
        
        $this->assertEquals(3, count($languageList));        
        
        /* Checking record order */
        $this->assertEquals('English', $languageList[0]->getName());
        $this->assertEquals('Spanish', $languageList[2]->getName());
        
    }
    
    public function testDeleteLanguages() {
        
        $result = $this->languageDao->deleteLanguages(array(1, 2));
        
        $this->assertEquals(2, $result);
        $this->assertEquals(1, count($this->languageDao->getLanguageList()));       
        
    }
    
    public function testDeleteWrongRecord() {
        
        $result = $this->languageDao->deleteLanguages(array(4));
        
        $this->assertEquals(0, $result);
        
    }
    
    public function testIsExistingLanguageName() {
        
        $this->assertTrue($this->languageDao->isExistingLanguageName('Spanish'));
        $this->assertTrue($this->languageDao->isExistingLanguageName('SPANISH'));
        $this->assertTrue($this->languageDao->isExistingLanguageName('spanish'));
        $this->assertTrue($this->languageDao->isExistingLanguageName('  Spanish  '));
        
    }
    
    public function testGetLanguageByName() {
        
        $object = $this->languageDao->getLanguageByName('Spanish');
        $this->assertTrue($object instanceof Language);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->languageDao->getLanguageByName('SPANISH');
        $this->assertTrue($object instanceof Language);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->languageDao->getLanguageByName('spanish');
        $this->assertTrue($object instanceof Language);
        $this->assertEquals(1, $object->getId());

        $object = $this->languageDao->getLanguageByName('  Spanish  ');
        $this->assertTrue($object instanceof Language);
        $this->assertEquals(1, $object->getId());
        
        $object = $this->languageDao->getLanguageByName('Hindi');
        $this->assertFalse($object);        
        
    }        
    
}
