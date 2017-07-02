<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class PimCsvImportForm extends BaseForm {

	private $pimCsvDataImportService;
	
	public function getPimCsvDataImportService() {
		if (is_null($this->pimCsvDataImportService)) {
			$this->pimCsvDataImportService = new PimCsvDataImportService();
		}
		return $this->pimCsvDataImportService;
	}

	public function configure() {

		$this->setWidgets(array(
		    'csvFile' => new sfWidgetFormInputFile(),
		));

		$this->setValidators(array(
		    'csvFile' => new sfValidatorFile(array('required' => false)),
		));
		$this->widgetSchema->setNameFormat('pimCsvImport[%s]');
	}

	public function save() {

		$file = $this->getValue('csvFile');
		if (!empty($file)) {
			if (!($this->isValidResume($file))) {
				$resultArray['messageType'] = 'csvimport.warning';
				$resultArray['message'] = __('Failed to Import: File Type Not Allowed');
				return $resultArray;
			}
			return $this->getPimCsvDataImportService()->import($file);
		}
	}

	public function isValidResume($file) {

		$validFile = false;
		$originalName = $file->getOriginalName();
		$fileType = $file->getType();
		$allowedImageTypes[] = "text/csv";
		$allowedImageTypes[] = 'text/comma-separated-values';
		$allowedImageTypes[] = "application/csv";
		if (($file instanceof sfValidatedFile) && $originalName != "") {
			if (in_array($fileType, $allowedImageTypes)) {
				$validFile = true;
			} else if ($file->getOriginalExtension() == '.csv') {
				$validFile = true;
			}
		}

		return $validFile;
	}

}

?>
