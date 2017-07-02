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
class ProjectServiceTest extends PHPUnit_Framework_TestCase {

	private $projectService;
	private $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {
		$this->projectService = new ProjectService();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/ProjectDao.yml';
		TestDataService::populate($this->fixture);
	}

	public function testGetProjectCount() {

		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getProjectCount')
			->with(false)
			->will($this->returnValue(count($projectList)));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectCount(false);
		$this->assertEquals($result, count($projectList));
	}

	public function testDeleteProject() {

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('deleteProject')
			->with(1)
			->will($this->returnValue(true));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->deleteProject(1);
		$this->assertEquals($result, true);
	}

	public function testDeleteProjectActivities() {

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('deleteProjectActivities')
			->with(1)
			->will($this->returnValue(true));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->deleteProjectActivities(1);
		$this->assertEquals($result, true);
	}

	public function testGetProjectById() {

		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getProjectById')
			->with(1)
			->will($this->returnValue($projectList[0]));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectById(1);
		$this->assertEquals($result, $projectList[0]);
	}

	public function testGetProjectActivityById() {

		$projectActivityList = TestDataService::loadObjectList('ProjectActivity', $this->fixture, 'ProjectActivity');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getProjectActivityById')
			->with(1)
			->will($this->returnValue($projectActivityList[0]));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectActivityById(1);
		$this->assertEquals($result, $projectActivityList[0]);
	}

	public function testGetAllProjects() {

		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getAllProjects')
			->with(false)
			->will($this->returnValue($projectList));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getAllProjects(false);
		$this->assertEquals($result, $projectList);
	}

	public function testGetActivityListByProjectId() {

		$projectActivityList = TestDataService::loadObjectList('ProjectActivity', $this->fixture, 'ProjectActivity');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getActivityListByProjectId')
			->with(1)
			->will($this->returnValue($projectActivityList));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getActivityListByProjectId(1);
		$this->assertEquals($result, $projectActivityList);
	}

	public function testHasActivityGotTimesheetItems() {

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('hasActivityGotTimesheetItems')
			->with(1)
			->will($this->returnValue(true));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->hasActivityGotTimesheetItems(1);
		$this->assertEquals($result, true);
	}

	public function testHasProjectGotTimesheetItems() {

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('hasProjectGotTimesheetItems')
			->with(1)
			->will($this->returnValue(true));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->hasProjectGotTimesheetItems(1);
		$this->assertEquals($result, true);
	}

	public function testGetProjectsByCustomerId() {

		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');
		$projectList = array($projectList[0], $projectList[1]);

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getProjectsByCustomerId')
			->with(1)
			->will($this->returnValue($projectList));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectsByCustomerId(1);
		$this->assertEquals($result, $projectList);
	}

	public function testGetProjectListForUserRole() {

		$role = "ADMIN_USER";
		$empNumber = null;
		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');

		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getProjectListForUserRole')
			->with($role, $empNumber)
			->will($this->returnValue($projectList));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectListForUserRole($role, $empNumber);
		$this->assertEquals($result, $projectList);
	}

	public function testGetProjectNameWithCustomerName() {

		$projectName = "Xavier - development";
		$result = $this->projectService->getProjectNameWithCustomerName(1);
		$this->assertEquals($result, $projectName);
	}

	public function testGetActiveProjectList() {
		
		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');
		$projectList = array($projectList[0], $projectList[1]);
		
		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getActiveProjectList')
			->will($this->returnValue($projectList));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getActiveProjectList();
		$this->assertEquals($result, $projectList);
	}
	
	public function testGetProjectListByProjectAdmin() {
		
		$projectList = TestDataService::loadObjectList('Project', $this->fixture, 'Project');
		$employee = TestDataService::loadObjectList('ProjectAdmin', $this->fixture, 'ProjectAdmin');
		
		$projectId = array(1);
		
		$projectDao = $this->getMock('ProjectDao',array('getProjectAdminByEmpNumber', 'getProjectsByProjectIds'));
		$projectDao->expects($this->once())
			->method('getProjectAdminByEmpNumber')
			->with(1)
			->will($this->returnValue(array($employee[0])));
		
		$projectDao->expects($this->once())
			->method('getProjectsByProjectIds')
			->with($projectId)
			->will($this->returnValue(array($projectList[0])));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getProjectListByProjectAdmin(1);
		$this->assertEquals($result[0]->getProjectId(), $projectList[0]->getProjectId());
	}
	
	public function testIsProjectAdmin() {

		$result = $this->projectService->isProjectAdmin(1);
		$this->assertEquals($result, true);
	}
	
	public function testSearchProjects() {

		$project = TestDataService::loadObjectList('Project', $this->fixture, 'Project');
		$srchClues = array(
		    'project' => 'development'
		);
		$allowedProjectList = array(1);
		
		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('searchProjects')
			->with($srchClues, $allowedProjectList)
			->will($this->returnValue($project[0]));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->searchProjects($srchClues, $allowedProjectList);
		$this->assertEquals($result, $project[0]);
	}
	
	public function testGetSearchProjectListCount() {

		$project = TestDataService::loadObjectList('Project', $this->fixture, 'Project');
		$srchClues = array(
		    'project' => 'development'
		);
		$allowedProjectList = array(1);
		
		$projectDao = $this->getMock('ProjectDao');
		$projectDao->expects($this->once())
			->method('getSearchProjectListCount')
			->with($srchClues, $allowedProjectList)
			->will($this->returnValue(1));

		$this->projectService->setProjectDao($projectDao);

		$result = $this->projectService->getSearchProjectListCount($srchClues, $allowedProjectList);
		$this->assertEquals($result, 1);
	}
        
        public function testGetActiveProjectsOrderedByCustomer() {
            // Verify that service calls DAO and returns object returned by dao method.
            $project = new Project();
            $expected = array($project);

            $projectDao = $this->getMock('ProjectDao');
            $projectDao->expects($this->once())
                    ->method('getActiveProjectsOrderedByCustomer')
                    ->will($this->returnValue($expected));

            $this->projectService->setProjectDao($projectDao);

            $result = $this->projectService->getActiveProjectsOrderedByCustomer();
            $this->assertEquals($expected, $result);            
        }
        
    public function testGetCustomerIdListByProjectId() {
        
        $projectIdList = array(1, 2);
        $customerIds = array(1, 4);
        
        $projectDao = $this->getMock('ProjectDao');
        $projectDao->expects($this->once())
                ->method('getCustomerIdListByProjectId')
                ->with($projectIdList)
                ->will($this->returnValue($customerIds));
        
        $this->projectService->setProjectDao($projectDao);
        
        $result = $this->projectService->getCustomerIdListByProjectId($projectIdList);
        $this->assertEquals($customerIds, $result);
    }
    
    public function testGetProjectNameList() {
        
        $projectIdList = array(1, 2);
        
        $project1['projectId'] = 1;
        $project1['name'] = 'Development';
        
        $project2['projectId'] = 2;
        $project2['name'] = 'Engineering';
        
        $projects = array($project1, $project1);
        
        $projectDao = $this->getMock('ProjectDao');
        $projectDao->expects($this->once())
                ->method('getProjectNameList')
                ->with($projectIdList, true)
                ->will($this->returnValue($projects));
        
        $this->projectService->setProjectDao($projectDao);
        
        $result = $this->projectService->getProjectNameList($projectIdList, true);
        $this->assertEquals($projects, $result);
    }
    
    
    public function testGetProjectActivityCount() {
        $count = 34;
        
        $projectDao = $this->getMock('ProjectDao', array('getProjectActivityCount'));
        $projectDao->expects($this->once())
                ->method('getProjectActivityCount')
                ->with()
                ->will($this->returnValue($count));

        $this->projectService->setProjectDao($projectDao);
        $result = $this->projectService->getProjectActivityCount();
        
        $this->assertEquals($count, $result);      
    }
    
    public function testGetProjectActivityCountWithDeleted() {
        $count = 44;
        
        $projectDao = $this->getMock('ProjectDao', array('getProjectActivityCount'));
        $projectDao->expects($this->once())
                ->method('getProjectActivityCount')
                ->with(true)
                ->will($this->returnValue($count));

        $this->projectService->setProjectDao($projectDao);
        $result = $this->projectService->getProjectActivityCount(true);
        
        $this->assertEquals($count, $result);           
    }        
	
}

