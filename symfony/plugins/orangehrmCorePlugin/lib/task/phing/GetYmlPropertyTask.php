<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

require_once "phing/Task.php";

/**
 * Phing task to get given YML property from given file
 */
class GetYmlPropertyTask extends Task {
    
    private $ymlFile;    
    private $ymlProperty;
    private $returnProperty;
    private $symfonyDir;
    
    public function getYmlFile() {
        return $this->ymlFile;
    }

    public function setYmlFile($ymlFile) {
        $this->ymlFile = $ymlFile;
    }

    public function getYmlProperty() {
        return $this->ymlProperty;
    }

    public function setYmlProperty($ymlProperty) {
        $this->ymlProperty = $ymlProperty;
    }

    public function getReturnProperty() {
        return $this->returnProperty;
    }

    public function setReturnProperty($returnProperty) {
        $this->returnProperty = $returnProperty;
    }

    public function getSymfonyDir() {
        return $this->symfonyDir;
    }

    public function setSymfonyDir($symfonyDir) {
        $this->symfonyDir = $symfonyDir;
    }

    
    /**
     * The init method: Do init steps.
     */
    public function init() {
      // nothing to do here
    }

    /**
     * The main entry point method.
     */
    public function main() {
        
        require_once $this->symfonyDir . '/lib/vendor/symfony/lib/yaml/sfYaml.php'; 
        
        $properties = sfYaml::load($this->ymlFile);
        
        if (is_array($properties)) {
            $flattenedProperties = $this->flattenArray($properties);
            
            print_r($flattenedProperties);
            
            $returnValue = null;
            if (isset($flattenedProperties[$this->ymlProperty])) {
                $returnValue = $flattenedProperties[$this->ymlProperty];
            } else if (isset($this->default)) {
                $returnValue = $this->default;
            } else {
                throw new BuildException("property: $this->ymlProperty not found in $this->ymlFile and no default specified");
            }
        }

        $this->project->setProperty($this->returnProperty, $returnValue);
    }  
    
    protected function flattenArray($array, $prefix = '') {
        $flattenedArray = array();
        
        foreach($array as $key => $item) {
            if (is_array($item)) {
                $flattened = $this->flattenArray($item, $prefix . $key . '_');
                $flattenedArray = array_merge($flattenedArray, $flattened);
            } else {
                $flattenedArray[$prefix . $key] = $item;
            }
        }
        
        return $flattenedArray;
    }
}
