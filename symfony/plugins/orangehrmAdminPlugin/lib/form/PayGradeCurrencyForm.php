<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class PayGradeCurrencyForm extends BaseForm {
	
	private $payGradeService;
	public $payGradeId;

	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}
	
	public function configure() {

		$this->payGradeId = $this->getOption('payGradeId');
		
		$this->setWidgets(array(
		    'currencyId' => new sfWidgetFormInputHidden(),
		    'payGradeId' => new sfWidgetFormInputHidden(),
		    'currencyName' => new sfWidgetFormInputText(),
		    'minSalary' => new sfWidgetFormInputText(),
		    'maxSalary' => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
		    'currencyId' => new sfValidatorString(array('required' => false)),
		    'payGradeId' => new sfValidatorNumber(array('required' => false)),
		    'currencyName' => new sfValidatorString(array('required' => true)),
		    'minSalary' => new sfValidatorNumber(array('required' => false)),
		    'maxSalary' => new sfValidatorNumber(array('required' => false)),
		));

		$this->widgetSchema->setNameFormat('payGradeCurrency[%s]');		
	}
	
	public function save(){
		
		$currencyId = $this->getValue('currencyId');
		$currencyName = $this->getValue('currencyName');
		$temp = explode(" - ", trim($currencyName));
		
		if(!empty ($currencyId)){
			$currency = $this->getPayGradeService()->getCurrencyByCurrencyIdAndPayGradeId($currencyId, $this->payGradeId);
		} else {
			$currency = new PayGradeCurrency();
		}
		
		$currency->setPayGradeId($this->payGradeId);
		$currency->setCurrencyId($temp[0]);
		$currency->setMinSalary(sprintf("%01.2f", $this->getValue('minSalary')));
		$currency->setMaxSalary(sprintf("%01.2f", $this->getValue('maxSalary')));
		$currency->save();
		return $this->payGradeId;
	}
	
}

?>