<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmWidgetInputCheckbox extends sfWidgetFormInputCheckbox implements ohrmEmbeddableWidget {

    protected $whereClauseCondition;

    public function configure($options = array(), $attributes = array()) {
        parent::configure($options, $attributes);
    }

    /**
     * Embeds this widget into the form.
     * @param sfForm $form
     */
    public function embedWidgetIntoForm(sfForm &$form) {

        $widgetSchema = $form->getWidgetSchema();
        $widgetSchema[$this->attributes['id']] = $this;
        $label = ucwords(str_replace("_", " ", $this->attributes['id']));
        $widgetSchema[$this->attributes['id']]->setLabel($label);
        $form->setValidator($this->attributes['id'], new sfValidatorPass());
    }

    /**
     * Sets whereClauseCondition.
     * @param string $condition
     */
    public function setWhereClauseCondition($condition) {

        $this->whereClauseCondition = $condition;
    }

    /**
     * Gets whereClauseCondition. ( if whereClauseCondition is set returns that, else returns default condition )
     * @return string ( a condition )
     */
    public function getWhereClauseCondition() {

        if (isset($this->whereClauseCondition)) {
            return $this->whereClauseCondition;
        } else {
            return "=";
        }
    }

    /**
     * This method generates the where clause part. ( returns null if checkbox is on, otherwise returns where cluase part )
     * @param string $fieldName
     * @param string $value
     * @return string or null
     */
    public function generateWhereClausePart($fieldName, $value) {

        if ($value == 'on') {
            return null;
        } else {

            return $fieldName . " " . $this->getWhereClauseCondition() . " " . "0";
        }
    }

}