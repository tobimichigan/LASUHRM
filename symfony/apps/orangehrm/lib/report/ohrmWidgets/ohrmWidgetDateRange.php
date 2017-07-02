<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmWidgetDateRange extends sfWidgetForm implements ohrmEmbeddableWidget {

    private $whereClauseCondition;
    private $id;

    public function configure($options = array(), $attributes = array()) {

        $this->id = $attributes['id'];
        $this->addOption($this->id . '_' . 'from_date', new ohrmWidgetDatePicker(array(), array('id' => $this->id . '_' . 'from_date')));
        $this->addOption($this->id . '_' . 'to_date', new ohrmWidgetDatePicker(array(), array('id' => $this->id . '_' . 'to_date')));


        $this->addOption('template', '<label class="sublabel1">'.__('From').'</label>%from_date%<label class="sublabel2">'.__('To').'</label>%to_date%');
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $values = array_merge(array('from' => '', 'to' => '', 'is_empty' => ''), is_array($value) ? $value : array());

        return strtr($this->translate($this->getOption('template')), array(
            '%from_date%' => $this->getOption($this->attributes['id'] . '_' . 'from_date')->render($name . '[from]', null, array('id' => $this->attributes['id'] . '_' . 'from_date')),
            '%to_date%' => $this->getOption($this->attributes['id'] . '_' . 'to_date')->render($name . '[to]', null, array('id' => $this->attributes['id'] . '_' . 'to_date')),
        ));
    }

    /**
     * Embeds this widget into the form. Sets label and validator for this widget.
     * @param sfForm $form
     */
    public function embedWidgetIntoForm(sfForm &$form) {


        $widgetSchema = $form->getWidgetSchema();
        $validatorSchema = $form->getValidatorSchema();

        $widgetSchema[$this->attributes['id']] = $this;
        $widgetSchema[$this->attributes['id']]->setLabel(__(ucwords(str_replace("_", " ", $this->attributes['id']))));

        $validatorSchema[$this->attributes['id']] = new ohrmValidatorDateRange(array(), array("invalid" => "Insert a correct date"));
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
            $setCondition = $this->whereClauseCondition;
            return $setCondition;
        } else {
            $defaultCondition = "BETWEEN";
            return $defaultCondition;
        }
    }

    /**
     * This method generates the where clause part.
     * @param string $fieldName
     * @param string $value
     * @return string
     */
    public function generateWhereClausePart($fieldName, $dateRanges) {

        $fromDate = "1970-01-01";
        $toDate = date("Y-m-d");
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();
        $datepickerDateFormat = get_datepicker_date_format($inputDatePattern);

        if (($dateRanges["from"] != $datepickerDateFormat) && ($dateRanges["to"] != $datepickerDateFormat)) {

            if (($dateRanges["to"] != "")) {
                $toDate = $dateRanges["to"];
            }
            if (($dateRanges["from"] != "")) {
                $fromDate = $dateRanges["from"];
            }
        } else if (($dateRanges["from"] == $datepickerDateFormat) && ($dateRanges["to"] != $datepickerDateFormat)) {
            if (($dateRanges["to"] != "")) {
                $toDate = $dateRanges["to"];
            }
        } else if (($dateRanges["from"] != $datepickerDateFormat) && ($dateRanges["to"] == $datepickerDateFormat)) {
            if (($dateRanges["from"] != "")) {
                $fromDate = $dateRanges["from"];
            }
        }


        return "( " . $fieldName . " " . $this->getWhereClauseCondition() . " '" . $fromDate . "' AND '" . $toDate . "' )";
    }
    
    public function getJavaScripts() {
        
        $parentJs = parent::getJavaScripts();
        
        $fromDateWidget = $this->getOption($this->attributes['id'] . '_' . 'from_date');                
        $fromWidgetJs = $fromDateWidget->getJavaScripts();       

        $javaScripts = array_merge($parentJs, $fromWidgetJs);
        
        return $javaScripts;        
    }
    
    public function getStylesheets() {
        $parentCss = parent::getStylesheets();
        
        $fromDateWidget = $this->getOption($this->attributes['id'] . '_' . 'from_date');
        $fromWidgetCss = $fromDateWidget->getStylesheets();
        
        $css = array_merge($parentCss, $fromWidgetCss);
        
        return $css;
    }    

}

