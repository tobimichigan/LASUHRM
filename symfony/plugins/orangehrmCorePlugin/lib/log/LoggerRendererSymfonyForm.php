<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Log4php renderer for sfForm classes.
 *
 */
class LoggerRendererSymfonyForm implements LoggerRendererObject {

    /**
     * Render a sfForm object.
     * 
     * @param sfForm $Object to render
     * @return string 
     */
    public function render($form) {
        
        $name = $form->getName();
        $class = get_class($form);
        
        $str = "Form: Class = $class, Name = $name\nFields:\n";
        
        // Render form fields values and errors
        foreach ($form->getFormFieldSchema() as $name => $formField) {
            
            $value = $formField->getValue();
            
             $str .= "Field: $name, Value = $value";
        
            if ($formField->getError() != "") {
               
                $str .= ", Error: " . $formField->getError();
            }
            
            $str .= "\n";
        } 
        
        if ($form->hasGlobalErrors()) {
            $str .= "Global Errors:\n";
            $globalErrors = $form->getGlobalErrors();
            
            foreach ($globalErrors as $error) {
                $str .= $error . "\n";
            }
        }

        return $str;
    }

}

