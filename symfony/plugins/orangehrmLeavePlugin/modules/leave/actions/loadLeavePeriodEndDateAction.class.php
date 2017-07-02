<?php

/**
 * OrangeHRM Enterprise is a closed sourced comprehensive Human Resource Management (HRM)
 * System that captures all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 LASUHRM Inc., http://www.lasu.edu.ng
 *
 * LASUHRM Inc is the owner of the patent, copyright, trade secrets, trademarks and any
 * other intellectual property rights which subsist in the Licensed Materials. LASUHRM Inc
 * is the owner of the media / downloaded OrangeHRM Enterprise software files on which the
 * Licensed Materials are received. Title to the Licensed Materials and media shall remain
 * vested in LASUHRM Inc. For the avoidance of doubt title and all intellectual property
 * rights to any design, new software, new protocol, new interface, enhancement, update,
 * derivative works, revised screen text or any other items that LASUHRM Inc creates for
 * Customer shall remain vested in LASUHRM Inc. Any rights not expressly granted herein are
 * reserved to LASUHRM Inc.
 *
 * You should have received a copy of the OrangeHRM Enterprise  proprietary license file along
 * with this program; if not, write to the LASUHRM Inc. 538 Teal Plaza, Secaucus , NJ 0709
 * to get the file.
 *
 */

/**
 * loadLeavePeriodEndDate
 */
class loadLeavePeriodEndDateAction extends baseCoreLeaveAction {

    public function execute($request) {

        $month = (int) $request->getParameter('month');
        $date = (int) $request->getParameter('date');
        $format = $request->getParameter('format', 'F d');

        $endDateElements = explode(' ', $this->getLeavePeriodService()->calculateEndDate($month, $date, null, $format));
        $endDate = __($endDateElements[0]) . ' ' . $endDateElements[1];

        return $this->renderText($endDate);
    }

}