<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Formats a time 
 *
 */
class TimeFormatCellFilter extends ohrmCellFilter {

    protected $format = "H:i";
    protected $default = "";

    public function getFormat() {
        return $this->format;
    }

    public function setFormat($format) {
        $this->format = $format;
    }
    public function getDefault() {
        return $this->default;
    }

    public function setDefault($default) {
        $this->default = $default;
    }

    public function filter($value) {

        $valid = false;
        
        if (!empty($value)) {
            $time = strtotime($value);
            $valid = $time !== FALSE;
        }
        
        if ($valid) {
            return date($this->getFormat(), $time);
        } else {
            return $this->getDefault();
        }

    }

}
