<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * ohrmDateValidator validates dates in the current date format.
 */
class ohrmDateValidator extends sfValidatorBase {
    const OUTPUT_FORMAT = 'Y-m-d';

    /**
     * Configure validator.
     * Output format is always yyyy-mm-dd
     * 
     * @param <type> $options
     * @param <type> $messages
     */
    protected function configure($options = array(), $messages = array()) {

        $this->addMessage('bad_format', '"%value%" does not match the date format (%date_format%).');
        $this->addOption('date_format', null);
        $this->addOption('date_format_error');
        $this->addOption('min', null);
        $this->addOption('max', null);
    }

    /**
     * @see sfValidatorBase
     */
    protected function doClean($value) {

        $trimmedValue = trim($value);
        $pattern = $this->getOption('date_format');
        
        if (empty($pattern)) {
            $pattern = sfContext::getInstance()->getUser()->getDateFormat();
        }

        $required = $this->getOption('required');
        $isDefaultValue = strcasecmp(str_replace('yyyy', 'yy', $trimmedValue), get_datepicker_date_format($pattern)) == 0;
        
        if (($trimmedValue == '') || $isDefaultValue) {
            if (!$required) {
                // If not required and empty or the format pattern, return valid                
                return null;                
            } else {
                throw new sfValidatorError($this, 'required');                
            }
        }

        $localizationService = new LocalizationService();
        $result = $localizationService->convertPHPFormatDateToISOFormatDate($pattern, $trimmedValue);
        $valid = ($result == "Invalid date") ? false : true;
        if (!$valid) {
            throw new sfValidatorError($this, 'bad_format', array('value' => $value, 'date_format' => $this->getOption('date_format_error') ? $this->getOption('date_format_error') : get_datepicker_date_format($pattern)));
        }
        return $result;
    }

}
