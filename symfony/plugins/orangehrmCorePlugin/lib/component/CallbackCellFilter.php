<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Filter cells by given callbacks.
 * 
 * Accepts parameter callback with array of callbacks to apply.
 * eg:
 * 
 *  'filters' => array('CallbackCellFilter' => array('callback' => array('strtolower','ucwords'))),
 */
class CallbackCellFilter extends ohrmCellFilter {
    
    protected $callback;
    public function getCallback() {
        return $this->callback;
    }

    public function setCallback($callback) {
        $this->callback = $callback;
    }
    
    public function filter($value) {
        
        if (empty($this->callback)) {
            throw new ListComponentException('callback property should be set');
        }
        
        if (!is_array($this->callback)) {
            throw new ListComponentException('callback property should be an array');
        }
        
        foreach ($this->callback as $callback) {
        
            if (!is_callable($callback)) {
                throw new ListComponentException('callback is not callable: ' . print_r($this->callback, false));
            }

            $value = call_user_func($callback, $value);
        }

        return $value;
    }
}
