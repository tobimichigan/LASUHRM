<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
;
/**
 * Formats cell value using php number_format() function
 */
class NumberFormatCellFilter extends ohrmCellFilter {
    
    protected $decimals = 2;
    protected $decimalPoint = '.';    
    protected $thousandsSeparator = ',';
    
    public function getDecimals() {
        return $this->decimals;
    }

    public function setDecimals($decimals) {
        $this->decimals = $decimals;
    }

    public function getDecimalPoint() {
        return $this->decimalPoint;
    }

    public function setDecimalPoint($decimalPoint) {
        $this->decimalPoint = $decimalPoint;
    }

    public function getThousandsSeparator() {
        return $this->thousandsSeparator;
    }

    public function setThousandsSeparator($thousandsSeparator) {
        $this->thousandsSeparator = $thousandsSeparator;
    }

    
    public function filter($value) {
        return number_format($value, $this->decimals, $this->decimalPoint, $this->thousandsSeparator);
    }
}
