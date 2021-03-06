<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of ohrmWidgetTimeDropDown
 */
class ohrmWidgetTimeDropDown extends sfWidgetForm {

    protected $choices;

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * format:                 The time format string (%hour%:%minute%)
     *  * hours:                  An array of hours for the hour select tag (optional)
     *  * minutes:                An array of minutes for the minute select tag (optional)
     *  * can_be_empty:           Whether the widget accept an empty value (true by default)
     *  * empty_value:            String to use as empty value
     *
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetForm
     */
    protected function configure($options = array(), $attributes = array()) {
        $this->addOption('format', '%hour%:%minute%');
        $this->addOption('hours', parent::generateTwoCharsRange(0, 23));
        $this->addOption('minutes', array('00', '15', '30', '45'));

        $this->addOption('can_be_empty', true);
        $this->addOption('empty_value', '');
    }

    /**
     * Renders the widget.
     *
     * @param  string $name        The element name
     * @param  string $value       The time displayed in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        
        if (array_key_exists('class', $attributes)) {
            $attributes['class'] .= ' timepicker';
        } else {
            $attributes['class'] = 'timepicker';
        }
        
        // convert value to an array
        $default = array('hour' => null, 'minute' => null);
        if (is_array($value)) {
            $value = array_merge($default, $value);
        } else {
            $value = ctype_digit($value) ? (integer) $value : strtotime($value);
            if (false === $value) {
                $value = $default;
            } else {
                // int cast required to get rid of leading zeros
                $value = array('hour' => (int) date('H', $value), 'minute' => (int) date('i', $value));
            }
        }
       
        $widget = new sfWidgetFormSelect(array('choices' => $this->getChoices(), 
            'id_format' => $this->getOption('id_format')), array_merge($this->attributes, $attributes));

        
        if (is_numeric($value['hour']) && is_numeric($value['minute'])) {
             $value = sprintf('%02d', $value['hour']) . ':' . sprintf('%02d', $value['minute']);
        } else {
            $value = '';
        }
        return $widget->render($name, $value);
    }

    public function getChoices() {

        if (empty($this->choices)) {
            
            $options = array();

            $hours = $this->getOption('hours');
            $minutes = $this->getOption('minutes');
            $format = $this->getOption('format');

            if ($this->getOption('can_be_empty')) {
                $options[''] = $this->getOption('empty_value');
            }

            foreach ($hours as $hour) {
                foreach ($minutes as $minute) {                    
                    $options[$hour . ':' . $minute] = strtr($format, array('%hour%' => $hour, '%minute%' => $minute));
                }
            }
            $this->choices = $options;
        }

        return $this->choices;
    }

}
