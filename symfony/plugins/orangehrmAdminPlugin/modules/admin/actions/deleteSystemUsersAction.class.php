<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deleteProjectAction
 *
 * @author orangehrm
 */
class deleteSystemUsersAction extends sfAction {

	private $systemUserService ;
        
        public function getSystemUserService() {
            $this->systemUserService = new SystemUserService();
            return $this->systemUserService;
        }

        
	/**
	 *
	 * @param <type> $request
	 */
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedUserIds = $request->getParameter('chkSelectRow');
                
                

		if (!empty($toBeDeletedUserIds)) {
                    if ($form->isValid()) {
			$delete = true;
                        $this->getSystemUserService()->deleteSystemUsers($toBeDeletedUserIds);
                        $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                    }
			
		}else{
                    $this->getUser()->setFlash('warning', __(TopLevelMessages::SELECT_RECORDS));
                }

		$this->redirect('admin/viewSystemUsers');
	}

}

?>
