<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmFormGenerator {

    public function generateForm($widgetNameList) {

        $form = new ReportForm();

        foreach ($widgetNameList as $widget) {
            $widgetName = $widget['widgetName'];
            $labelName = $widget['labelName'];
            $required = $widget['required'];

            if ($widget["required"] != null) {
                $ohrmWidget = new $widgetName(array(), array('id' => $labelName, 'required' => $required));
            }else{
                $ohrmWidget = new $widgetName(array(), array('id' => $labelName));
            }
            
            $ohrmWidget->embedWidgetIntoForm($form);
        }

        return $form;
    }

    public function generatePredefinedForm($filterFields, $displayFieldGroups, $reportId = null, $reportName = null) {
        
        $form = new DefineReportForm();

        $form->setWidget('report_name', new sfWidgetFormInputText(array('default' => $reportName)));
        $form->setValidator('report_name', new sfValidatorString(array('required' => true, 'max_length' => 250),
                array('required' => __('Required'), 'max_length' => __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 250)))));
        $form->setWidget('report_id', new sfWidgetFormInputHidden(array('default' => $reportId)));       
        $form->setValidator('report_id', new sfValidatorString(array('required' => false)));
        $criteriaChoices = array();
        
        // Add filter widgets
        foreach ($filterFields as $filterField) {
            
            $name = $filterField->getName();
            $required = $filterField->getRequired();
            $widgetClass = $filterField->getFilterFieldWidget();
            
            if (!empty($widgetClass)) {
                $attributes = array('id' => $name);

                if ($required != null) {
                    $attributes['required'] = $required;
                }
                
                //$attributes['disabled'] = 'disabled';
                
                $widget = new $widgetClass(array(), $attributes);
                $widget->embedWidgetIntoForm($form);
                
                $form->filterWidgets[$name] = $form->getWidgetSchema()->getLabel($name);
                if (!$required) {
                    $criteriaChoices[$name] = $form->getWidgetSchema()->getLabel($name);;
                }
                
            }
        }
        
        $criteriaSelectionWidget = new sfWidgetFormChoice(array('choices' => $criteriaChoices));
        $form->setWidget('criteria_list', $criteriaSelectionWidget);
        $form->setValidator('criteria_list', new sfValidatorString(array('required' => false)));
        
        // Add display fields
        $displayGroupChoices = array();
        foreach ($displayFieldGroups as $id => $groupInfo) {

            $group = $groupInfo[0];
            $displayFields = $groupInfo[1];
            
            if (count($displayFields) > 0) {
                
                // TODO: Check if $group->name is empty -> default group which should not be selectable.
                $groupId = 'display_group_' . $group->id;
                
                $widget = new ohrmWidgetReportDisplayGroup(array('label' => __($group->name) . ' (' . __('Include Header') . ') ',
                                                                 'value_attribute_value' => $group->id), 
                                                           array('id' => $groupId,
                                                                 'name' => 'display_groups[]'));
                $widget->embedWidgetIntoForm($form);

                $fields = array();

                foreach ($displayFields as $field) {
                    
                    if (!$field->getIsMeta()) {
                        $fieldId = 'display_field_' . $field->displayFieldId;

                        $filterWidget = new sfWidgetFormInputCheckbox(array('label' => $field->label,
                                                                     'value_attribute_value' => $field->displayFieldId), 
                                                                     array('id' => $fieldId, 
                                                                     'name' => 'display_fields[]'));

                        $form->setWidget($fieldId, $filterWidget);
                        $fields[] = $fieldId;
                    }
                }

                $form->displayFieldGroups[$groupId] = $fields;
                $displayGroupChoices[$groupId] = $group->name;
            }
            
         }        
         
        $displayGroupChoices = new sfWidgetFormChoice(array('choices' => $displayGroupChoices));
        $form->setWidget('display_groups', $displayGroupChoices);
        $form->setValidator('display_groups', new sfValidatorString(array('required' => false)));
        
        $displayFieldList = new sfWidgetFormChoice(array('choices' => array()));
        $form->setWidget('display_field_list', $displayFieldList);
        $form->setValidator('display_field_list', new sfValidatorString(array('required' => false))); 
        return $form;
        //
    }
}

