<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmListSummaryHelper {

    private static $collection = array();
    private static $count = array();

    /**
     *
     * @param mixed $value
     * @param string $function 
     */
    public static function collectValue($value, $function) {

        if (!isset(self::$collection[$function])) {
            self::$collection[$function] = 0;
            self::$count[$function] = 0;
        }

        self::$collection[$function] += $value;
        self::$count[$function]++;
    }

    /**
     *
     * @param string $function
     * @param mixed $decimals
     * @return mixed 
     */
    public static function getAggregateValue($function, $decimals) {
        $aggregateValue = null;

        switch ($function) {
            case 'SUM':
                if (isset(self::$collection['SUM'])) {
                    $aggregateValue = self::$collection['SUM'];
                }
                break;
            default:
                // TODO: Warn. Unsupported function
                break;
        }

        return number_format($aggregateValue, $decimals);
    }

}

