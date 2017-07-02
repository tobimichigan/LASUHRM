<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CustomerService extends BaseService {

    private $customerDao;

    /**
     * Construct
     */
    public function __construct() {
        $this->customerDao = new CustomerDao();
    }

    /**
     *
     * @return <type>
     */
    public function getCustomerDao() {
        return $this->customerDao;
    }

    /**
     *
     * @param CustomerDao $customerDao 
     */
    public function setCustomerDao(CustomerDao $customerDao) {
        $this->customerDao = $customerDao;
    }

    /**
     * Get Customer List
     * 
     * Get Customer List with pagination.
     * 
     * @param type $noOfRecords
     * @param type $offset
     * @param type $sortField
     * @param type $sortOrder
     * @param type $activeOnly
     * @return type 
     */
    public function getCustomerList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $activeOnly = true) {
        return $this->customerDao->getCustomerList($limit, $offset, $sortField, $sortOrder, $activeOnly);
    }

    /**
     * Get Active customer cout.
     *
     * Get the total number of active customers for list component.
     * 
     * @param type $activeOnly
     * @return type 
     */
    public function getCustomerCount($activeOnly = true) {
        return $this->customerDao->getCustomerCount($activeOnly);
    }

    /**
     * Get customer by id
     * 
     * @param type $customerId
     * @return type 
     */
    public function getCustomerById($customerId) {
        return $this->customerDao->getCustomerById($customerId);
    }

    /**
     * Delete customer
     * 
     * Set customer 'is_deleted' parameter to 1.
     * 
     * @param type $customerId
     * @return type 
     */
    public function deleteCustomer($customerId) {
        return $this->customerDao->deleteCustomer($customerId);
    }

    /**
     * Undelete customer
     * 
     * Set customer 'is_deleted' parameter to 0.
     * 
     * @param type $customerId
     * @return type 
     */
    public function undeleteCustomer($customerId) {
        return $this->customerDao->undeleteCustomer($customerId);
    }

    /**
     * 
     * Get all customer list
     * 
     * Get all active customers
     * 
     * @param type $activeOnly
     * @return type 
     */
    public function getAllCustomers($activeOnly = true) {
        return $this->customerDao->getAllCustomers($activeOnly);
    }

    /**
     * Return an array of Customer Names
     * 
     * <pre>
     * Ex: $customerIdList = array(1, 2);
     * 
     * For above $customerIdList parameter there will be an array like below as the response.
     * 
     * array(
     *          0 => array('customerId' => 1, 'name' => 'Xavier'),
     *          1 => array('customerId' => 2, 'name' => 'ACME')
     * )
     * </pre>
     * 
     * @version 2.7.1
     * @param Array $customerIdList List of Customer Ids
     * @param Boolean $excludeDeletedCustomers Exclude deleted Customers or not
     * @return Array of Customer Names
     */
    public function getCustomerNameList($customerIdList, $excludeDeletedCustomers = true) {
        return $this->customerDao->getCustomerNameList($customerIdList, $excludeDeletedCustomers);
    }

    /**
     * Check wheather the customer has any timesheet records
     * 
     * @param type $customerId
     * @return type 
     */
    public function hasCustomerGotTimesheetItems($customerId) {
        return $this->customerDao->hasCustomerGotTimesheetItems($customerId);
    }

}

?>
