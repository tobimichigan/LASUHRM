<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteWorkShiftsAction extends sfAction {
	
	private $workShiftService;

	public function getWorkShiftService() {
		if (is_null($this->workShiftService)) {
			$this->workShiftService = new WorkShiftService();
			$this->workShiftService->setWorkShiftDao(new WorkShiftDao());
		}
		return $this->workShiftService;
	}
	
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName())); 
		$toBeDeletedShiftIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedShiftIds)) {

			foreach ($toBeDeletedShiftIds as $toBeDeletedShiftId) {
                                if ($form->isValid()) {
                                    $shift = $this->getWorkShiftService()->getWorkShiftById($toBeDeletedShiftId);
                                    
                if ($shift instanceof WorkShift) {
                    $shift->delete();
                }
			
			$this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                                }
                        }
		}

		$this->redirect('admin/workShift');
	}
}

?>
