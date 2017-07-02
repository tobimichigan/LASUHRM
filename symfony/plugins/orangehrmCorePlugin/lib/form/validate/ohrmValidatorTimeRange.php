<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmValidatorTimeRange extends sfValidatorBase {

    /**
     * Configures the current validator.
     *
     * Available options:
     *
     *  * from_time:   The from time validator (required)
     *  * to_time:     The to time validator (required)
     *  * from_field:  The name of the "from" date field (optional, default: from)
     *  * to_field:    The name of the "to" date field (optional, default: to)
     *
     * @param array $options    An array of options
     * @param array $messages   An array of error messages
     *
     * @see sfValidatorBase
     */
    protected function configure($options = array(), $messages = array()) {
        parent::configure($options, $messages);

        $this->setMessage('invalid', 'From time should be before to time.');

        $this->addRequiredOption('from_time');
        $this->addRequiredOption('to_time');
        $this->addOption('from_field', 'from');
        $this->addOption('to_field', 'to');
    }

    /**
     * @see sfValidatorBase
     */
    protected function doClean($value) {

        $fromField = $this->getOption('from_field');
        $toField = $this->getOption('to_field');

        $value[$fromField] = $this->getOption('from_time')->clean(isset($value[$fromField]) ? $value[$fromField] : null);
        $value[$toField] = $this->getOption('to_time')->clean(isset($value[$toField]) ? $value[$toField] : null);
        
        if ($value[$fromField] && $value[$toField]) {
            $fromTimeStamp = strtotime($value[$fromField]);
            $toTimeStamp = strtotime($value[$toField]);

            if ($toTimeStamp <= $fromTimeStamp) {
                throw new sfValidatorError($this, $this->getMessage('invalid') . '-' . $toTimeStamp . '-' . $fromTimeStamp . 
                        '-' . $value[$fromField] . '-' . $value[$toField]);
            }
        }

        return $value;
    }

}

