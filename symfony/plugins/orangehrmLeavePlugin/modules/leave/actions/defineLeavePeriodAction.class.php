<?php
/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
*/

/**
 * defineLeavePeriodAction
 */
class defineLeavePeriodAction extends baseLeaveAction {

    private $leavePeriodService;
    private $leaveRequestService;
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

    public function getLeavePeriodService() {

        if (is_null($this->leavePeriodService)) {
            $leavePeriodService = new LeavePeriodService();
            $leavePeriodService->setLeavePeriodDao(new LeavePeriodDao());
            $this->leavePeriodService = $leavePeriodService;
        }

        return $this->leavePeriodService;
    }

    /**
     * @return LeaveRequestService
     */
    public function getLeaveRequestService() {
        if(is_null($this->leaveRequestService)) {
            $this->leaveRequestService = new LeaveRequestService();
            $this->leaveRequestService->setLeaveRequestDao(new LeaveRequestDao());
        }
        return $this->leaveRequestService;
    }

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if(is_null($this->form)) {
            $this->form	= $form;
        }
    }

    public function execute($request) {
        
        if (!Auth::instance()->hasRole(Auth::ADMIN_ROLE)) {
            $this->forward('leave', 'showLeavePeriodNotDefinedWarning');
        }

        $this->setForm(new LeavePeriodForm(array(), array(), true));
        $this->isLeavePeriodDefined = OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_LEAVE_PERIOD_DEFINED);
        $this->latestSatrtDate = $this->getLeavePeriodService()->getCurrentLeavePeriodStartDateAndMonth();
        if ($this->isLeavePeriodDefined) {
            $this->currentLeavePeriod = $this->getLeavePeriodService()->getCurrentLeavePeriodByDate(date('Y-m-d'));
            $endDate = date('F d',  strtotime($this->currentLeavePeriod[1]));
            $startMonthValue = $this->latestSatrtDate->getLeavePeriodStartMonth();
            $startDateValue = $this->latestSatrtDate->getLeavePeriodStartDay();
        } else {
            $endDate = '-';
            $startMonthValue = 0;
            $startDateValue = 0;
        }

        $this->endDate = $endDate;
        $this->startMonthValue = $startMonthValue;
        $this->startDateValue = $startDateValue;

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        // this section is for saving leave period
        if ($request->isMethod('post')) {
            $leavePeriodService = $this->getLeavePeriodService();

            $this->form->bind($request->getParameter($this->form->getName()));
            if($this->form->isValid()) {

                $leavePeriodHistory = new LeavePeriodHistory();
                $leavePeriodHistory->setLeavePeriodStartMonth($this->form->getValue('cmbStartMonth'));
                $leavePeriodHistory->setLeavePeriodStartDay($this->form->getValue('cmbStartDate'));
                $leavePeriodHistory->setCreatedAt(date('Y-m-d'));
                
                $this->getLeavePeriodService()->saveLeavePeriodHistory($leavePeriodHistory);
                
                $this->getMenuService()->enableModuleMenuItems('leave');
                $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
                
                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));

                $this->redirect('leave/defineLeavePeriod');
            }
        }
    }

    
}
?>
