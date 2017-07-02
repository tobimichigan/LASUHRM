<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of LeaveEntitlementBulkAssignFilterForm
 *
 */
class LeaveEntitlementBulkAssignFilterForm extends BaseForm {

    public function configure() {
        
        $labels = array();

        // Add employee filter checkbox and widgets
        $this->setWidget('bulk_assign', new sfWidgetFormInputCheckbox());
        //$this->setValidator('bulk_assign', new sfValidatorChoice(array('choices' => array(1), 'required' => false)));
        $this->setValidator('bulk_assign', new sfValidatorPass());
        $labels['bulk_assign'] = __('Add to Multiple Employees');
        
        $locationOptions = array('set_all_option_value' => true, 'all_option_value' => NULL);                
        $locationWidget = new ohrmReportWidgetOperationalCountryLocationDropDown($locationOptions);
        $this->setWidget('location', $locationWidget);
        $labels['location'] = __('Location');
        //$locationChoices = $locationWidget->getValidValues();
        //$this->setValidator('location', new sfValidatorChoice(array('choices' => $locationChoices, 'required' => false)));
        $this->setValidator('location', new sfValidatorPass());

        $subUnitWidget = new ohrmWidgetSubUnitDropDown();
        $this->setWidget('subunit', $subUnitWidget);
        $labels['subunit'] = __('Sub Unit');
        $subUnitChoices = $subUnitWidget->getValidValues();
        $this->setValidator('subunit', new sfValidatorChoice(array('choices' => $subUnitChoices, 'required' => false)));

        $this->getWidgetSchema()->setLabels($labels);

        $formExtension = PluginFormMergeManager::instance();
        $formExtension->mergeForms($this, 'viewLeaveEntitlements', 'LeaveEntitlementBulkAssignFilterForm');

        $this->widgetSchema->setNameFormat('entitlement_filter[%s]');

    }

}

