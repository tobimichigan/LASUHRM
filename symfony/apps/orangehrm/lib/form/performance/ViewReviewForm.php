<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Form class for Save Education
 */
class ViewReviewForm extends BaseForm {

    private $empJson = array();

    public function configure() {
        $this->empJson = $this->getOption('empJson');
        $this->widgetSchema->setNameFormat('viewReviewForm[%s]');
    }

    public function getEmployeeListAsJson() {
        return $this->empJson;
    }

}