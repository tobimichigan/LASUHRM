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
 * delete holiday(s)
 */
class deleteHolidayAction extends sfAction {

    private $holidayService;

    /**
     * get Method for Holiday Service
     *
     * @return HolidayService $holidayService
     */
    public function getHolidayService() {
        if (is_null($this->holidayService)) {
            $this->holidayService = new HolidayService();
        }
        return $this->holidayService;
    }

    /**
     * Set HolidayService
     * @param HolidayService $holidayService
     */
    public function setHolidayService(HolidayService $holidayService) {
        $this->holidayService = $holidayService;
    }
    
    
    /**
     * view Holiday list
     * @param sfWebRequest $request
     */ 
    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true) ;
        $form->bind($request->getParameter($form->getName()));
        $holidayIds = $request->getPostParameter('chkSelectRow[]');

        if (!empty($holidayIds)) {

            foreach ($holidayIds as $key => $id) {
                if ($form->isValid()) {
                    $this->getHolidayService()->deleteHoliday($id);
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }

            $this->getUser()->setFlash('templateMessage', array('SUCCESS', __(TopLevelMessages::DELETE_SUCCESS)));
        } else {
            $this->getUser()->setFlash('templateMessage', array('NOTICE', __(TopLevelMessages::SELECT_RECORDS)));
        }


        $this->redirect('leave/viewHolidayList');
    }

}
