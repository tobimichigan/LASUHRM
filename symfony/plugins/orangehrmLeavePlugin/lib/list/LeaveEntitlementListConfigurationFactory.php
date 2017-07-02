<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of LeaveEntitlementListConfigurationFactory
 */
class LeaveEntitlementListConfigurationFactory extends ohrmListConfigurationFactory {
    
    protected $allowEdit;
    
    public static $displayLeaveType = false;
    
    public function init() {
        sfContext::getInstance()->getConfiguration()->loadHelpers('OrangeDate');
        
        $headers = array();
        
        $header1 = new ListHeader();
        $header2 = new ListHeader();
        $header3 = new ListHeader();
        $header4 = new ListHeader();
        
        $widthPercentages = self::$displayLeaveType ? array('20%', '35%', '20%', '20%', '5%') :           
                array('45%', '25%', '25%', '5%');
        
        if (self::$displayLeaveType) {
            
            $leaveTypeHeader = new ListHeader();
            $leaveTypeHeader->populateFromArray(array(
                'name' => 'Leave Type',
                'width' => array_shift($widthPercentages),
                'isSortable' => false,
                'elementType' => 'label',
                'textAlignmentStyle' => 'left',
                'elementProperty' => array('getter' => array('getLeaveType', 'getDescriptiveLeaveTypeName'))
            ));
            
            $headers[] = $leaveTypeHeader;            
        } else {
            $widthPercentages = array('45%', '25%', '25%', '5%');
        }       
            
        $header1->populateFromArray(array(
            'name' => 'Entitlement Type',
            'width' => array_shift($widthPercentages),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => array('getLeaveEntitlementType', 'getName')) 
        ));
        $headers[] = $header1;        

        $header2->populateFromArray(array(
            'name' => 'Valid From',
            'width' => array_shift($widthPercentages),
            'isSortable' => false,
            'elementType' => 'linkDate',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'linkable' => $this->allowEdit,
                'labelGetter' => 'getFromDate',
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => public_path('index.php/leave/addLeaveEntitlement/id/{id}')                
            )
        ));
        $headers[] = $header2;

        $header3->populateFromArray(array(
            'name' => 'Valid To',
            'width' => array_shift($widthPercentages),
            'isSortable' => false,
            'elementType' => 'linkDate',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'linkable' => $this->allowEdit,
                'labelGetter' => 'getToDate',
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => public_path('index.php/leave/addLeaveEntitlement/id/{id}'),                
            )
        ));
        $headers[] = $header3;
        
        $header4->populateFromArray(array(
            'name' => 'Days',
            'width' => array_shift($widthPercentages),
            'isSortable' => false,
            'elementType' => 'link',
            'textAlignmentStyle' => 'right',
            'filters' => array('NumberFormatCellFilter' => array()),              
            'elementProperty' => array(
                'linkable' => $this->allowEdit,
                'labelGetter' => array('getNoOfDays'),
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => public_path('index.php/leave/addLeaveEntitlement/id/{id}'),
            ),            
        ));
        $headers[] = $header4;

        $this->headers = $headers;       
    }
    
    public function getClassName() {
        return 'LeaveEntitlement';
    }
    
    public function getAllowEdit() {
        return $this->allowEdit;
    }

    public function setAllowEdit($allowEdit) {
        $this->allowEdit = $allowEdit;
    }

    
}
