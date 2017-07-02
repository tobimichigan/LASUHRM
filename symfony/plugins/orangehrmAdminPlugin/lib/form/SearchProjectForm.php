<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class SearchProjectForm extends BaseForm {

	private $customerService;
	private $projectService;
	private $userObj;
    private $allowedProjectList;

	public function getProjectService() {
		if (is_null($this->projectService)) {
			$this->projectService = new ProjectService();
			$this->projectService->setProjectDao(new ProjectDao());
		}
		return $this->projectService;
	}

	public function getCustomerService() {
		if (is_null($this->customerService)) {
			$this->customerService = new CustomerService();
			$this->customerService->setCustomerDao(new CustomerDao());
		}
		return $this->customerService;
	}
	
    private function setAllowedProjectList() {
        $this->allowedProjectList = $this->userObj->getAllowedProjectList();
    }

	public function configure() {

		$this->userObj = sfContext::getInstance()->getUser()->getAttribute('user');

        $this->setAllowedProjectList();
		$this->setWidgets(array(
		    'customer' => new sfWidgetFormInputText(),
		    'project' => new sfWidgetFormInputText(),
		    'projectAdmin' => new sfWidgetFormInputText()
		));

		$this->setValidators(array(
		    'customer' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
		    'project' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
		    'projectAdmin' => new sfValidatorString(array('required' => false, 'max_length' => 100))
		));

        $this->getWidgetSchema()->setLabels($this->getFormLabels());
		$this->widgetSchema->setNameFormat('searchProject[%s]');

	}

	public function setDefaultDataToWidgets($searchClues) {
		$this->setDefault('customer', $searchClues['customer']);
		$this->setDefault('project', $searchClues['project']);
		$this->setDefault('projectAdmin', $searchClues['projectAdmin']);
	}

	public function getProjectAdminListAsJson() {

		$jsonArray = array();
		$employeeService = new EmployeeService();
		$employeeService->setEmployeeDao(new EmployeeDao());

        $properties = array("empNumber","firstName", "middleName", "lastName", 'termination_id');
        $employeeList = $employeeService->getEmployeePropertyList($properties, 'empNumber', 'ASC');

		foreach ($employeeList as $employee) {
            $name = trim(trim($employee['firstName'] . ' ' . $employee['middleName'],' ') . ' ' . $employee['lastName']);
            if ($employee['termination_id']) {
                $name = $name. ' ('.__('Past Employee') .')';
            }
            $jsonArray[] = array('name' => $name, 'id' => $employee['empNumber']);
		}

		$jsonString = json_encode($jsonArray);

		return $jsonString;
	}

	public function getCustomerListAsJson() {

	    $allowedProjectList = $this->allowedProjectList;
	    $allowedCustomerList = $this->getProjectService()->getCustomerIdListByProjectId($allowedProjectList);

	    $jsonArray = array();
	    $customerList = $this->getCustomerService()->getCustomerNameList($allowedCustomerList);
	    $allowedCustomerNames = array();


	    foreach ($customerList as $customer) {
	        $allowedCustomerNames[$customer['customerId']] = $customer['name'];
        }
        
        foreach ($allowedCustomerNames as $id => $customerName) {
            $jsonArray[] = array('name' => $customerName, 'id' => $id);
        }
        
		$jsonString = json_encode($jsonArray);
		return $jsonString;
	}

    public function getProjectListAsJson() {

        $allowedProjectIdList = $this->allowedProjectList;
        $jsonArray = array();
        $projectList = $this->getProjectService()->getProjectNameList($allowedProjectIdList);
        
        $allowedProjetNames = array();
        foreach ($projectList as $project) {
            $allowedProjetNames[$project['projectId']] = $project['name'];
        }
        
        foreach ($allowedProjetNames as $id => $projectName) {
            $jsonArray[] = array('name' => $projectName, 'id' => $id);
        }
        $jsonString = json_encode($jsonArray);
        return $jsonString;
    }
    
    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $labels = array(
            'customer' => __('Customer Name'),
		    'project' => __('Project'),
		    'projectAdmin' => __('Project Admin')
        );
        return $labels;
    }

}

