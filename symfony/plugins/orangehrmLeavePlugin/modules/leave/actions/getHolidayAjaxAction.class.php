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
 * Displaying ApplyLeave UI and saving data
 *
 * @author Samantha Jayasinghe
 */
class getHolidayAjaxAction extends sfAction {

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
     *
     * @param type $request 
     */
    public function execute( $request ){
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        

        $holidayList = $this->getHolidayList();

        $dateList =  array();
        
        foreach ($holidayList as $holiday) {
            $htype = $holiday->getLength() == 0 ? 'f' : 'h';
            
            $dateList[] = array(date('Y',  strtotime($holiday->getdate())), date('m',  strtotime($holiday->getdate())),date('d',  strtotime($holiday->getdate())),$htype, $holiday->getRecurring() ) ;
        }

      
        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);
        
        
        
        echo json_encode($dateList);
        return sfView::NONE;
    }
    
    /**
     * 
     * @return Holiday List 
     */
    public function getHolidayList(){
        return $this->getHolidayService()->getFullHolidayList();
    }
    

}

?>
