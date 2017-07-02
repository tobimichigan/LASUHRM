<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class isUniqueUserJsonAction extends sfAction {
	
	/**
	 *
	 * @param <type> $request
	 * @return <type>
	 */
	public function execute($request) {

		$this->setLayout(false);
		sfConfig::set('sf_web_debug', false);
		sfConfig::set('sf_debug', false);

		if ($this->getRequest()->isXmlHttpRequest()) {
			$this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
		}

		$systemUser = $request->getParameter('systemUser');
                $userId     = $request->getParameter('user_id');  
                
             
		 $systemUserService =   new SystemUserService();
                 $user              =   $systemUserService->isExistingSystemUser($systemUser['userName'],$userId);
                
                 $isExisting        =   ( $user instanceof SystemUser)?false:true;
                 

		return $this->renderText(json_encode( $isExisting));
	}

}

?>
