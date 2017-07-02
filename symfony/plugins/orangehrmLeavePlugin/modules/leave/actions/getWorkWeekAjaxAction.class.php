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
class getWorkWeekAjaxAction extends sfAction {

    /**
     * get Method for WorkWeek Service
     *
     * @return WorkWeekService $workWeekService
     */
    public function getWorkWeekService() {
        if (is_null($this->workWeekService)) {
            $this->workWeekService = new WorkWeekService();
            $this->workWeekService->setWorkWeekDao(new WorkWeekDao());
        }
        return $this->workWeekService;
    }

    /**
     * Set WorkWeekService
     * @param WorkWeekService $workWeekService
     */
    public function setWorkWeekService(WorkWeekService $workWeekService) {
        $this->workWeekService = $workWeekService;
    }
    
    public function execute( $request ){
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
        $workWeek = $this->getWorkWeekList();

        $dates = array();
        for ($day = 1; $day <= 7; $day++) {
            if ($workWeek->getLength($day) == 8) {
                $dates[] = array($day, 'w');
            } elseif ($workWeek->getLength($day) == 4) {
                $dates[] = array($day, 'h');
            } else {
                // TODO: Warn
            }
        }

        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);
            
        echo json_encode($dates);
        
        return sfView::NONE;
    }
    
    public function getWorkWeekList(){
        return $this->getWorkWeekService()->getWorkWeekOfOperationalCountry(null);
    }
    
    

}

?>
