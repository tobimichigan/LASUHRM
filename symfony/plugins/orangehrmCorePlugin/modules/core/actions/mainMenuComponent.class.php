<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class mainMenuComponent extends sfComponent {

    const MAIN_MENU_USER_ATTRIBUTE = 'mainMenu.menuItemArray';
    
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

        $menuItemDetails = $this->_getMenuItemDetails();

        $this->menuItemArray = $menuItemDetails['menuItemArray'];

        $initialModule = $request->getParameter('initialModuleName', '');
        
        if (!empty($initialModule)) {
            $this->module = $initialModule;
        } else {
            $this->module = $this->getContext()->getModuleName();
        }        
        
        $initialAction = $request->getParameter('initialActionName', '');
        
        if (!empty($initialAction)) {
            $this->action = $initialAction;
        } else {
            $this->action = $this->getContext()->getActionName();
        }
        
        $details['module']          = $this->module;
        $details['action']          = $this->action;
        $details['actionArray']     = $menuItemDetails['actionArray'];
        $details['parentIdArray']   = $menuItemDetails['parentIdArray'];
        $details['levelArray']      = $menuItemDetails['levelArray'];       
        
        $this->currentItemDetails = $this->getMenuService()->getCurrentItemDetails($details);

    }

    protected function _getMenuItemDetails() {

        $menuItemArray = $this->getUser()->getAttribute(self::MAIN_MENU_USER_ATTRIBUTE);

        // If menu items not set or menu items are empty, recreate them.
        // We check if the menu items are empty, because in some scenarios, we can get an
        // empty menu item list when accessing some login related urls where user role manager
        // is not properly initialized yet, and does not have any user roles set.
        if (!isset($menuItemArray['menuItemArray']) || empty($menuItemArray['menuItemArray'])) {
            
            // $menuItemArray = $this->getContext()->getUserRoleManager()->getAccessibleMenuItemDetails();
            // Above leads to an internal error when ESS tries to access unauthorized URL
            // Try http://localhost/orangehrm/symfony/web/index.php/performance/saveReview as ESS
            $menuItemArray = UserRoleManagerFactory::getUserRoleManager()->getAccessibleMenuItemDetails();
            $this->getUser()->setAttribute(self::MAIN_MENU_USER_ATTRIBUTE, $menuItemArray);
            
    }

        return $menuItemArray;
        
}
    
    

}
