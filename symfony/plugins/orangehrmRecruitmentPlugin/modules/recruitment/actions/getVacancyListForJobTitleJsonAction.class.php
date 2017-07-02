<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class getVacancyListForJobTitleJsonAction extends sfAction {

    /**
     *
     * @param <type> $request
     * @return <type>
     */
    public function execute($request) {

        $allowedVacancyList = $this->getUser()->getAttribute('user')->getAllowedVacancyList();

        $this->setLayout(false);
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);

        $vacancyList = array();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
        }

        $jobTitle = $request->getParameter('jobTitle');

        $vacancyService = new VacancyService();
        $vacancyList = $vacancyService->getVacancyListForJobTitle($jobTitle, $allowedVacancyList, true);
	$newVacancyList = array();
        foreach ($vacancyList as $vacancy) {
            if ($vacancy['status'] == JobVacancy::CLOSED) {
                $vacancy['name'] = $vacancy['name'] . " (Closed)";
            }
            $newVacancyList[] = $vacancy;
        }     
        return $this->renderText(json_encode($newVacancyList));
    }

}

