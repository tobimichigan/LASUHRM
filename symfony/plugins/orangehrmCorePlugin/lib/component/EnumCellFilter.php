<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of EnumCellFilter
 *
 */
class EnumCellFilter extends ohrmCellFilter {
    
    protected $enum = array();
    protected $default = "";
        
    public function setEnum($enum) {
        $this->enum = $enum;
    }
    
    public function getEnum() {
        return $this->enum;
    }
    
    public function setDefault($default) {
        $this->default = $default;
    }
    
    public function getDefault() {
        return $this->default;
    }
    
    public function filter($value) {

        if (isset($this->enum[$value])) {

            $value = $this->enum[$value];
        } else {
            $value = $this->default;
        }
        
        return $value;
    }
}
