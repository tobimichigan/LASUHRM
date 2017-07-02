<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
 
class EmployeeSearchParameterHolder extends SearchParameterHolder {
     
    const RETURN_TYPE_OBJECT = 1;
    const RETURN_TYPE_ARRAY = 2;
    
    protected $filters;
    protected $returnType = self::RETURN_TYPE_OBJECT;
    
    public function __construct() {
        $this->orderField = 'lastName';
    }


    public function setFilters($filters) {
        $this->filters = $filters;
    }

    public function getFilters() {
        return $this->filters;
    }    
    
    public function getReturnType() {
        return $this->returnType;
    }

    public function setReturnType($returnType) {
        $this->returnType = $returnType;
    }

    

} 