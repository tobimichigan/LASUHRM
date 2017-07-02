<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
 
abstract class SearchParameterHolder {
     
    protected $orderBy = 'ASC';
    protected $orderField;
    protected $limit = 50;
    protected $offset = 0;
    
    public function setOrderBy($orderBy) {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy() {
        return $this->orderBy;
    }    
    
    public function setOrderField($orderField) {
        $this->orderField = $orderField;
    }

    public function getOrderField() {
        return $this->orderField;
    }
    
    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function getLimit() {
        return $this->limit;
    }
    
    public function setOffset($offset) {
        $this->offset = $offset;
    }

    public function getOffset() {
        return $this->offset;
    }    
     
} 