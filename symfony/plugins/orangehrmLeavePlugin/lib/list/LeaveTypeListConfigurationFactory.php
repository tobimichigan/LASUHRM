<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of LeaveTypeListConfigurationFactory
 *
 */
class LeaveTypeListConfigurationFactory extends ohrmListConfigurationFactory {

    protected function init() {

        $header = new ListHeader();

        $header->populateFromArray(array(
            'name' => 'Leave Type',
            'width' => '99%',
            'isSortable' => false,
            'sortField' => null,
            'elementType' => 'link',
            'elementProperty' => array(
                'labelGetter' => 'getName',
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => 'index.php/leave/defineLeaveType?id={id}'),
        ));


        $this->headers = array($header);
    }

    public function getClassName() {
        return 'LeaveTypeList';
    }

}

