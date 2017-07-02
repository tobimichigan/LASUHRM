<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of deleteLeaveEntitlementsAction
 */
class deleteLeaveEntitlementsAction extends sfAction {
    
    protected $leaveEntitlementService;
    
    public function getLeaveEntitlementService() {
        if (empty($this->leaveEntitlementService)) {
            $this->leaveEntitlementService = new LeaveEntitlementService();
        }
        return $this->leaveEntitlementService;
    }

    public function setLeaveEntitlementService($leaveEntitlementService) {
        $this->leaveEntitlementService = $leaveEntitlementService;
    }

    // protected by screen permissions.     
    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $ids = $request->getParameter('chkSelectRow');
        
        if (count($ids) > 0) {
            try{
                if ($form->isValid()) {
                    $this->getLeaveEntitlementService()->deleteLeaveEntitlements($ids);
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }catch(Exception $e){
                $this->getUser()->setFlash('warning.nofade',$e->getMessage());
            }
        } else {
            $this->getUser()->setFlash('warning', __(TopLevelMessages::SELECT_RECORDS));
            
        }
        
        $this->redirect('leave/viewLeaveEntitlements?savedsearch=1');
    }
}
