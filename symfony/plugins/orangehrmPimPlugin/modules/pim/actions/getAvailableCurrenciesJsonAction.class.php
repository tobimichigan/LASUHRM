<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * getAvailableCurrenciesJsonAction action
 */
class getAvailableCurrenciesJsonAction extends basePimAction {

    private $currencyService;
    

    /**
     * Get CurrencyService
     * @returns CurrencyService
     */
    public function getCurrencyService() {
        if(is_null($this->currencyService)) {
            $this->currencyService = new CurrencyService();
        }
        return $this->currencyService;
    }

    /**
     * Set CurrencyService
     * @param CurrencyService $currencyService
     */
    public function setCurrencyService(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }
    
    /**
     * List unassigned currencies for given employee and pay grade
     * @param sfWebRequest $request
     * @return void
     */
    public function execute($request) {
       $this->setLayout(false);
       sfConfig::set('sf_web_debug', false);
       sfConfig::set('sf_debug', false);

       $currencies = array();

       if ($this->getRequest()->isXmlHttpRequest()) {
           $this->getResponse()->setHttpHeader('Content-Type','application/json; charset=utf-8');
       }

       $payGrade = $request->getParameter('paygrade');
       $empNumber = $request->getParameter('empNumber');

       if (!empty($payGrade) && !empty($empNumber)) {

           $employeeService = $this->getEmployeeService();

           // TODO: call method that returns data in array format (or pass parameter)
           $currencies = $employeeService->getAssignedCurrencyList($payGrade, true);
       } else {
           
           // 
           // Return full currency list
           //
           $currencyService = $this->getCurrencyService();
           $currencies = $currencyService->getCurrencyList(true);           
       }
       $currencyArray = array();
       foreach ($currencies as $currency) {
           $currency['currency_name'] = __($currency['currency_name']);
           $currencyArray[] = $currency;
       }
       return $this->renderText(json_encode($currencyArray));
    }

}