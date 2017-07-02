<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class pimCsvImportAction extends baseCsvImportAction {

	/**
	 * @param sfForm $form
	 * @return
	 */
	public function setForm(sfForm $form) {
		if (is_null($this->form)) {
			$this->form = $form;
		}
	}

	public function execute($request) {
        
        $this->_checkAuthentication();

		$this->setForm(new PimCsvImportForm());

		if ($request->isMethod('post')) {

			$this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
			$file = $request->getFiles($this->form->getName());
			if ($_FILES['pimCsvImport']['size']['csvFile'] > 1024000 || $_FILES == null) {
                $this->getUser()->setFlash('warning', __('Failed to Import: File Size Exceeded'));
				$this->redirect('admin/pimCsvImport');
			}
			if ($this->form->isValid()) {
				$result = $this->form->save();

				if (isset($result['messageType'])) {
					$this->messageType = $result['messageType'];
					$this->message = $result['message'];
                    $this->getUser()->setFlash($result['messageType'], $result['message']);
				} else {
				    if($result != 0) {
                       $this->getUser()->setFlash('csvimport.success', __('Number of Records Imported').": ".$result);
				    } else {
                        $this->getUser()->setFlash('warning', __('Failed to Import: No Compatible Records'));
				    }
					$this->redirect('admin/pimCsvImport');
				}
			}
		}
	}
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('auth/login');
		}
        
    }    

}

?>
