<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class defineTimesheetPeriodAction extends sfAction {

    protected $menuService;
    
    public function getMenuService() {
        
        if (!$this->menuService instanceof MenuService) {
            $this->menuService = new MenuService();
        }
        
        return $this->menuService;
        
    }
    
    public function setMenuService(MenuService $menuService) {
        $this->menuService = $menuService;
    }    
    
    public function execute($request) {

        $this->userObj = $this->getContext()->getUser()->getAttribute('user');
        $this->isAllowed = $this->userObj->isAllowedToDefineTimeheetPeriod();
        $this->form = new DefineTimesheetPeriodForm(array(),array(),true);
        

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $results = $this->form->save();
                $this->getMenuService()->enableModuleMenuItems('time');
                $this->getMenuService()->enableModuleMenuItems('attendance');
                $this->getMenuService()->enableModuleMenuItems('admin', array('Project Info', 'Customers', 'Projects'));
                $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
                $this->redirect('time/viewEmployeeTimesheet');
            }
            
        }
    }

}
