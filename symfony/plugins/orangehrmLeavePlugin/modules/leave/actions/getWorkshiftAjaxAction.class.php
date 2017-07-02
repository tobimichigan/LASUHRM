<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Get workshift for a given employee
 */
class getWorkshiftAjaxAction extends sfAction {

    private $workScheduleService;
    
    /**
     * Get work schedule service
     * @return WorkScheduleService
     */
    public function getWorkScheduleService() {
        if (!($this->workScheduleService instanceof WorkScheduleService)) {
            $this->workScheduleService = new WorkScheduleService();
        }
        return $this->workScheduleService;
    }

    /**
     *
     * @param WorkScheduleService $service 
     */
    public function setWorkScheduleService(WorkScheduleService $service) {
        $this->workScheduleService = $service;
    }  
    
    public function execute( $request ){
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
        $empNumber = $request->getParameter('empNumber');
        
        $workSchedule = $this->getWorkScheduleService()->getWorkSchedule($empNumber);        
        $workShiftLength = $workSchedule->getWorkShiftLength();
        $startEndTime = $workSchedule->getWorkShiftStartEndTime();

        $result = array('workshift' => $workShiftLength,
                        'start_time' => date('H:i', strtotime($startEndTime['start_time'])),
                        'end_time' => date('H:i', strtotime($startEndTime['end_time']))
            );
        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);
            
        echo json_encode($result);
        
        return sfView::NONE;
    }
    
    public function getWorkWeekList(){
        return $this->getWorkWeekService()->getWorkWeekOfOperationalCountry(null);
    }
    
    

}

?>
