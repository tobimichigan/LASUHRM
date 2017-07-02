<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * A widget that displays as a simple div (no input field).
 *
 */
class ohrmWidgetDiv extends sfWidgetForm {
    
    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        if (!isset($attributes['id'])) {
            $attributes['id'] = $this->generateId($name, $value);
        }
        $html = $this->renderContentTag('div', self::escapeOnce($value), $attributes);
        
        return $html;
    }
}

