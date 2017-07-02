<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Form class for Depenent delete form
 */
class EmployeeDependentsDeleteForm extends BaseForm {

    public function configure() {

        $empNumber = $this->getOption('empNumber');
        
        $this->setWidgets(array(
            'empNumber' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)),
        ));

        $this->setValidators(array(
            'empNumber' => new sfValidatorNumber(array('required' => true, 'min' => 0))
        ));
        $this->widgetSchema->setNameFormat('dependentsDelete[%s]');
    }

}