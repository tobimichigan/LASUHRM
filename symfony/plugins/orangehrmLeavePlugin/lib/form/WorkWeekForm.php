<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class WorkWeekForm extends sfForm {

    private $workWeekService;
    private $workWeekEntity;

    /**
     * Sets WorkWeekService
     * @param WorkWeekService $service
     */
    public function setWorkWeekService(WorkWeekService $service) {
        $this->workWeekService = $service;
    }

    /**
     * Getter for WorkWeekService
     * @return WorkWeekService
     */
    public function getWorkWeekService() {
        if (!($this->workWeekService instanceof WorkWeekService)) {
            $this->workWeekService = new WorkWeekService();
        }
        return $this->workWeekService;
    }

    /**
     * Getter method for WorkWeek Entity
     * @return WorkWeek
     */
    public function getWorkWeekEntity() {
        if (!($this->workWeekEntity instanceof WorkWeek)) {
            $this->workWeekEntity = new WorkWeek();
        }
        return $this->workWeekEntity;
    }

    /**
     * Sets the WorkWeek Entity
     * @param WorkWeek $workWeek
     */
    public function setWorkWeekEntity(WorkWeek $workWeek) {
        $this->workWeekEntity = $workWeek;
    }

    /**
     * Configuring WorkWeek form widget
     */
    public function configure() {

        $this->setWorkWeekEntity($this->getDefault('workWeekEntity'));

        $this->setValidators($this->getDayLengthValidators());
        $this->setWidgets($this->getDayLengthWidgets());
        $this->setDefaults($this->getDayLengthDefaults());

        $this->widgetSchema->setLabels($this->getDayLengthLabels());
        $this->widgetSchema->setNameFormat('WorkWeek[%s]');

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateWorkWeekValue'))));
        
    }

    /**
     * Read WorkWeek Objects
     * @param string $data
     * @return array Array of WorkWeek objects
     */
    public function getWorkWeekObjects($data) {

        $daysList = WorkWeek::getDaysList();
        
        $workWeekList = array();

        foreach ($data as $day => $length) {
            $fday = substr($day, -1); // strip "select_" in the day param
            if (array_key_exists($fday, $daysList)) {
                $workWeek = $this->getWorkWeekService()->readWorkWeek($fday);
                $workWeek->setLength($length);
                $workWeekList[] = $workWeek; // this will return only allowed work week objects
            } else {
                throw new LeaveServiceException("Invaid Day");
            }
        }
        return $workWeekList;
    }

    /**
     * Validate WorkWeek form elements passed by the view // prevent form element alteration
     *
     * @param sfValidator $validator
     * @param array $values
     * @return array $values Array of Values
     */
    public function validateWorkWeekValue($validator, $values) {

        $daysList = WorkWeek::getDaysList();
        $workWeekList = array();

        foreach ($values as $day => $length) {

            if (preg_match('/day_length_(Mon|Tues|Wednes|Thurs|Fri|Sat|Sun)day$/', $day)) {
                $dayTerm = str_replace('day_length_', '', $day);

                if (!in_array($dayTerm, $daysList)) {
                    $error = new sfValidatorError($validator, 'Invalid WorkWeek!');
                    throw new sfValidatorErrorSchema($validator, array($day => $error));
                }
            }
        }
        
        return $values;
    }

    /**
     *
     * @return sfWidgetFormSelect[]
     */
    protected final function getDayLengthWidgets() {
        $dayLengths = WorkWeek::getDaysLengthList();

        /* Making compatible with i18n */
        foreach ($dayLengths as $dayLength => $dayLengthTerm) {
            $dayLengths[$dayLength] = __($dayLengthTerm);
        }
        
        $formWidgets = array();
        $daysOfWeek = WorkWeek::getDaysList();

        foreach ($daysOfWeek as $day) {
            $formWidgets['day_length_' . $day] = new sfWidgetFormSelect(
                    array('choices' => $dayLengths)
            );
        }

        return $formWidgets;
    }

    protected final function getDayLengthLabels() {
        $formLabels = array();
        $daysOfWeek = WorkWeek::getDaysList();

        foreach ($daysOfWeek as $day) {
            $formLabels['day_length_' . $day] = __($day);
        }

        return $formLabels;
    }
    
    protected final function getDayLengthValidators() {
        $formValidators = array();
        
        $daysOfWeek = WorkWeek::getDaysList();
        $choices = array_keys(WorkWeek::getDaysLengthList());
        
        foreach ($daysOfWeek as $day) {

            $validator = new sfValidatorChoice(
                            array(
                                'choices' => $choices,
                            ),
                            array(
                                'invalid' => 'Invalid work week for ' . $day,
                                'required' => 'Value for ' . $day . ' is required',
                            )
            );
            
            $formValidators['day_length_' . $day] = $validator;
        }
        
        return $formValidators;
    }
    
    protected final function getDayLengthDefaults() {
        $formDefaults = array();
        $daysOfWeek = WorkWeek::getDaysList();

        foreach ($daysOfWeek as $isoValue => $day) {
            $formDefaults['day_length_' . $day] = $this->getWorkWeekEntity()->getLength($isoValue);
        }

        return $formDefaults;
    }
    
    public function getJavaScripts() {
        $javaScripts = parent::getJavaScripts();
        $javaScripts[] = plugin_web_path('orangehrmLeavePlugin', 'js/defineWorkWeekSuccess.js');
        $javaScripts[] = plugin_web_path('orangehrmLeavePlugin', 'js/defineWorkWeekSuccessValidate.js');

        return $javaScripts;
    }    

}
