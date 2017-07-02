<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class CustomerForm extends BaseForm {

    private $updateMode = false;
    private $customerService;

    public function getCustomerService() {
        if (is_null($this->customerService)) {
            $this->customerService = new CustomerService();
            $this->customerService->setCustomerDao(new CustomerDao());
        }
        return $this->customerService;
    }

    public function configure() {

        $this->customerId = $this->getOption('customerId');
        if (isset($this->customerId)) {
            $customer = $this->getCustomerService()->getCustomerById($this->customerId);
        }

        $this->setWidgets(array(
            'customerId' => new sfWidgetFormInputHidden(),
            'customerName' => new sfWidgetFormInputText(),
            'hdnOriginalCustomerName' => new sfWidgetFormInputHidden(),
            'description' => new sfWidgetFormTextArea(),
        ));

        $this->setValidators(array(
            'customerId' => new sfValidatorNumber(array('required' => false)),
            'customerName' => new sfValidatorString(array('required' => true, 'max_length' => 52)),
            'hdnOriginalCustomerName' => new sfValidatorString(array('required' => false)),
            'description' => new sfValidatorString(array('required' => false, 'max_length' => 255)),
        ));

        $this->widgetSchema->setNameFormat('addCustomer[%s]');

        if (isset($customer) && $customer != null) {

            $this->setDefault('customerName', $customer->getName());
            $this->setDefault('description', $customer->getDescription());
            $this->setDefault('hdnOriginalCustomerName', $customer->getName());
        }
    }

    public function save() {

        $this->resultArray = array();
        $customerId = $this->getValue('customerId');
        if ($customerId > 0) {
            $service = $this->getCustomerService();
            $customer = $service->getCustomerById($customerId);
            $this->resultArray['messageType'] = 'success';
            $this->resultArray['message'] = __(TopLevelMessages::UPDATE_SUCCESS);
        } else {
            $customer = new Customer();
            $this->resultArray['messageType'] = 'success';
            $this->resultArray['message'] = __(TopLevelMessages::SAVE_SUCCESS);
        }

        $customer->setName(trim($this->getValue('customerName')));
        $customer->setDescription($this->getValue('description'));
        $customer->save();
        return $this->resultArray;
    }

    public function setUpdateMode() {
        $this->updateMode = true;
    }

    public function isUpdateMode() {
        return $this->updateMode;
    }

    public function getCustomerListAsJson() {

        $list = array();
        $customerList = $this->getCustomerService()->getAllCustomers();
        foreach ($customerList as $customer) {
            if (!$customer->getIsDeleted()) {
                $list[] = array('id' => $customer->getCustomerId(), 'name' => $customer->getName());
            }
        }
        return json_encode($list);
    }

    public function getDeletedCustomerListAsJson() {

        $list = array();
        $customerList = $this->getCustomerService()->getAllCustomers();
        foreach ($customerList as $customer) {
            if ($customer->getIsDeleted()) {
                $list[] = array('id' => $customer->getCustomerId(), 'name' => $customer->getName());
            }
        }
        return json_encode($list);
    }

}