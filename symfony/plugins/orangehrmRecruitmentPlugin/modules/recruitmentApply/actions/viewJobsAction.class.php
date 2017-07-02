<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class viewJobsAction extends sfAction {
    
    private $vacancyService;
    
    /**
     *
     * @return <type>
     */
    public function getVacancyService() {
        if (is_null($this->vacancyService)) {
            $this->vacancyService = new VacancyService();
            $this->vacancyService->setVacancyDao(new VacancyDao());
        }
        return $this->vacancyService;
    }
    
    /**
     * Execute Action. Has optional request parameter 'extension'
     * Set in plugin routing.yml.
     * 
     * @param type $request 
     */
    public function execute($request) {
        
//        $this->setLayout(false);        
        $this->publishedVacancies = $this->getVacancyService()->getPublishedVacancies();
        
        $extension = $this->getRequestParameter('extension');   
        
        if ($extension == 'rss') {
            $response = $this->getResponse();
            $response->setContentType('text/xml');
        }
        return sfView::SUCCESS . '.' . $extension;
        
    }
    
}