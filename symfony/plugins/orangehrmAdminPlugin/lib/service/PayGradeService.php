<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class PayGradeService extends BaseService {
	
	private $payGradeDao;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->payGradeDao = new PayGradeDao();
	}

	/**
	 *
	 * @return <type>
	 */
	public function getPayGradeDao() {
		return $this->payGradeDao;
	}

	/**
	 *
	 * @param CustomerDao $customerDao 
	 */
	public function setPayGradeDao(PayGradeDao $payGradeDao) {
		$this->payGradeDao = $payGradeDao;
	}
	
	public function getPayGradeById($payGradeId){
		return $this->payGradeDao->getPayGradeById($payGradeId);
	}
	
	public function getPayGradeList($sortField='name', $sortOrder='ASC'){
		return $this->payGradeDao->getPayGradeList($sortField, $sortOrder);
	}
	
	public function getCurrencyListByPayGradeId($payGradeId){
		return $this->payGradeDao->getCurrencyListByPayGradeId($payGradeId);
	}
	
	public function getCurrencyByCurrencyIdAndPayGradeId($currencyId, $payGradeId){
		return $this->payGradeDao->getCurrencyByCurrencyIdAndPayGradeId($currencyId, $payGradeId);
	}

}

?>
