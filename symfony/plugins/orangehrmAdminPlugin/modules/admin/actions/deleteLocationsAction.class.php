<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteLocationsAction extends sfAction {

	public function getLocationService() {
		if (is_null($this->locationService)) {
			$this->locationService = new LocationService();
			$this->locationService->setLocationDao(new LocationDao());
		}
		return $this->locationService;
	}

	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedLocationIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedLocationIds)) {

			foreach ($toBeDeletedLocationIds as $toBeDeletedLocationId) {
                            if ($form->isValid()) {
				$location = $this->getLocationService()->getLocationById($toBeDeletedLocationId);
				$location->delete();
                                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                            }
			}
		}

		$this->redirect('admin/viewLocations');
	}

}

?>
