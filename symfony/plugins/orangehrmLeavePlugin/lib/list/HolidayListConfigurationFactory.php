<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of HolidayListConfigurationFactory
 *
 */
class HolidayListConfigurationFactory extends ohrmListConfigurationFactory {

    protected function init() {

        $header1 = new ListHeader();

        $header1->populateFromArray(array(
            'name' => 'Name',
            'width' => '40%',
            'isSortable' => false,
            'sortField' => null,
            'elementType' => 'link',
            'elementProperty' => array(
                'labelGetter' => 'getDescription',
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => 'index.php/leave/defineHoliday?hdnEditId={id}'),
        ));

        $header2 = new ListHeader();

        $header2->populateFromArray(array(
            'name' => 'Date',
            'width' => '25%',
            'isSortable' => false,
            'sortField' => null,
            'filters' => array('DateCellFilter' => array()),            
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getDate'),
        ));
        
        $header3 = new ListHeader();

        $header3->populateFromArray(array(
            'name' => 'Full Day/Half Day',
            'width' => '20%',
            'isSortable' => false,
            'sortField' => null,
            'filters' => array('EnumCellFilter' => array(
                                                    'enum' => PluginWorkWeek::getDaysLengthList(), 
                                                    'default' => ''),
                               'I18nCellFilter' => array()
                              ),
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getLength'),
        ));

        $header4 = new ListHeader();

        $header4->populateFromArray(array(
            'name' => 'Repeats Annually',
            'width' => '15%',
            'isSortable' => false,
            'sortField' => null,
            'filters' => array('EnumCellFilter' => array(
                                                    'enum' => PluginWorkWeek::getYesNoList(), 
                                                    'default' => ''),
                               'I18nCellFilter' => array()
                              ),            
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getRecurring'),
        ));
        
        $this->headers = array($header1, $header2, $header3, $header4);
    }

    public function getClassName() {
        return 'HolidayList';
    }

}

