<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class locationAction extends sfAction {

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
        
        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewLocations');
		
		$usrObj = $this->getUser()->getAttribute('user');
		if (!$usrObj->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
		
		$this->locationId = $request->getParameter('locationId');
		$values = array('locationId' => $this->locationId);
		$this->setForm(new LocationForm(array(),$values));
		
		if ($request->isMethod('post')) {

			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid()) {
				$locationId = $this->form->save();
				if ($this->form->edited) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::UPDATE_SUCCESS));
				} else {
					$this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
				}
				$this->redirect('admin/viewLocations');
			}
		}
	}
}

?>
