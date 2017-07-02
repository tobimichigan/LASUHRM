<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmWidgetDateInterval extends ohrmWidgetDateRange {
        /**
     * This method generates the where clause part.
     * @param string $fieldNames
     * @param string $value
     * @return string
     */
    public function generateWhereClausePart($fieldNames, $dateRanges) {

        $fromDate = "1970-01-01";
        $toDate = date("Y-m-d");

        $fieldArray = explode(",", $fieldNames);
        $field1 = $fieldArray[0];
        $field2 = $fieldArray[1];

        if (($dateRanges["from"] != "YYYY-MM-DD") && ($dateRanges["to"] != "YYYY-MM-DD")) {
            $fromDate = $dateRanges["from"];
            $toDate = $dateRanges["to"];
        } else if (($dateRanges["from"] == "YYYY-MM-DD") && ($dateRanges["to"] != "YYYY-MM-DD")) {
            $toDate = $dateRanges["to"];
        } else if (($dateRanges["from"] != "YYYY-MM-DD") && ($dateRanges["to"] == "YYYY-MM-DD")) {
            $fromDate = $dateRanges["from"];
        }

//        Case 1
        $sqlPartForField1 = "( " . $field1. " " . $this->getWhereClauseCondition() . " '" . $fromDate . "' AND '" . $toDate . "' )";
        $sqlPartForField2 = "( " . $field2. " " . $this->getWhereClauseCondition() . " '" . $fromDate . "' AND '" . $toDate . "' )";

        $sqlForCase1 = " ( " . $sqlPartForField1 . " AND " . $sqlPartForField2 . " ) ";

//        Case 2
        $sqlPartForField1 = " ( " . $field1 . " > '" . $fromDate . "' AND " . $field1 . " < '" . $toDate . "' ) " ;
        $sqlPartForField2 = " ( ".$field2 . " > '" . $toDate . "' ) ";

        $sqlForCase2 = " ( " .$sqlPartForField1 . " AND " . $sqlPartForField2 . " ) ";

//        Case 3
        $sqlPartForField1 = " ( " . $field1 . " < '" . $fromDate . "' ) ";
        $sqlPartForField2 = " ( " . $field2 . " > '" . $fromDate . "' AND " . $field2 . " < '" . $toDate . "' ) " ;

        $sqlForCase3 = " ( " .$sqlPartForField1 . " AND " . $sqlPartForField2 . " ) ";

        $sql = " ( " . $sqlForCase1 . " OR " . $sqlForCase2 . " OR " . $sqlForCase3 . " ) ";
        return $sql;
    }
}

