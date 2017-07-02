<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class UndeleteCustomerForm extends orangehrmForm {

    public function configure() {
        $fromAction = $this->getOption('fromAction');
        $projectId = $this->getOption('projectId');
        
        $this->setWidget('undeleteId', new sfWidgetFormInputHidden());
        $this->setValidator('undeleteId', new sfValidatorString(array('required' => true)));
        $this->setWidget('fromAction', new sfWidgetFormInputHidden());
        $this->setValidator('fromAction', new sfValidatorString(array('required' => true)));
        $this->setWidget('projectId', new sfWidgetFormInputHidden());
        $this->setValidator('projectId', new sfValidatorString(array('required' => false)));
        
        $this->setDefault('fromAction', $fromAction);
        $this->setDefault('projectId', $projectId);
        
        $this->widgetSchema->setNameFormat('undeleteCustomer[%s]');
    }

}

