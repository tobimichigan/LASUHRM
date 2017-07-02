<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class isValidEntitlemnetAjaxAction extends sfAction {
	
	/**
	 *
	 * @param <type> $request
	 * @return <type>
	 */
	public function execute($request) {
        
         sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
       $isValidEntitlement = true;

		if ($this->getRequest()->isXmlHttpRequest()) {
			$this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
		}
        $id                 = $request->getParameter('id');
       
        if( $id > 0){
            $entitlementValue = $request->getParameter('entitlements');
          
            $entitlmentService = new LeaveEntitlementService();
             $entitlment = $entitlmentService->getLeaveEntitlement( $id );
             if( $entitlment->getDaysUsed() > $entitlementValue['entitlement']){
                 $isValidEntitlement = false;
             }
        }


        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);

        
        return $this->renderText(json_encode($isValidEntitlement))  ;
        
        

		
	}

}

?>
