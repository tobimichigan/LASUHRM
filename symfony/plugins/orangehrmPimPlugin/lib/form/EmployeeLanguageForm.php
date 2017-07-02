<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmployeeLanguageForm extends sfForm {
    
    private $employeeService;
    public $fullName;
    private $widgets = array();
    public $empLanguageList;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if(is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }

    public function configure() {
        $this->languagePermissions = $this->getOption('languagePermissions');

        $empNumber = $this->getOption('empNumber');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $this->fullName = $employee->getFullName();

        $this->empLanguageList = $this->getEmployeeService()->getEmployeeLanguages($empNumber);
        
        $i18nHelper = sfContext::getInstance()->getI18N();
        
        $this->langTypeList = array("" => '-- ' . $i18nHelper->__('Select') . ' --',
                               1 => $i18nHelper->__('Writing'),
                               2 => $i18nHelper->__('Speaking'),
                               3 => $i18nHelper->__('Reading'));
        $this->competencyList = array("" => '-- ' . $i18nHelper->__('Select') . ' --',
                                 1 => $i18nHelper->__('Poor'),
                                 2 => $i18nHelper->__('Basic'),
                                 3 => $i18nHelper->__('Good'),
                                 4 => $i18nHelper->__('Mother Tongue'));
        
        $widgets = array('emp_number' => new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $validators = array('emp_number' => new sfValidatorString(array('required' => true)));
        
        if ($this->languagePermissions->canRead()) {

            $languageWidgets = $this->getLanguageWidgets();
            $languageValidators = $this->getLanguageValidators();

            if (!($this->languagePermissions->canUpdate() || $this->languagePermissions->canCreate()) ) {
                foreach ($languageWidgets as $widgetName => $widget) {
                    $widget->setAttribute('disabled', 'disabled');
                }
            }
            $widgets = array_merge($widgets, $languageWidgets);
            $validators = array_merge($validators, $languageValidators);
        }
        
        $this->setWidgets($widgets);
        $this->setValidators($validators);
        
        $this->widgetSchema->setNameFormat('language[%s]');
        $this->getWidgetSchema()->setLabels($this->getFormLabels());
       
    }
    
    /**
     *
     * @return \sfWidgetFormInputHidden 
     */
    private function getLanguageWidgets() {
        $availableLanguageList = $this->_getLanguageList();
        
        $widgets = array();
        $widgets['code'] = new sfWidgetFormSelect(array('choices' => $availableLanguageList));
        $widgets['lang_type'] = new sfWidgetFormSelect(array('choices' => $this->langTypeList));
        $widgets['competency'] = new sfWidgetFormSelect(array('choices' => $this->competencyList));
        $widgets['comments'] = new sfWidgetFormTextarea();
        return $widgets;
    }
    
    private function getLanguageValidators() {
        $availableLanguageList = $this->_getLanguageList();
        
        $validators = array(
            'code' => new sfValidatorChoice(array('choices' => array_keys($availableLanguageList))),
            'lang_type' => new sfValidatorChoice(array('choices' => array_keys($this->langTypeList))),
            'competency' => new sfValidatorChoice(array('choices' => array_keys($this->competencyList))),
            'comments' => new sfValidatorString(array('required' => false, 'max_length' => 100))
        );
        return $validators;
    }

    public function getLangTypeDesc($langType) {
        $langTypeDesc = "";
        if (isset($this->langTypeList[$langType])) {
            $langTypeDesc = $this->langTypeList[$langType];
        }    
        return $langTypeDesc;
    }
    
    public function getCompetencyDesc($competency) {
        $competencyDesc = "";
        if (isset($this->competencyList[$competency])) {
            $competencyDesc = $this->competencyList[$competency];
        }
        return $competencyDesc;
    }

    private function _getLanguageList() {
        $languageService = new LanguageService();
        $languageList = $languageService->getLanguageList();
        $list = array("" => "-- " . __('Select') . " --");

        foreach($languageList as $language) {
            $list[$language->getId()] = $language->getName();
        }

        return $list;
    }
    
    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $required = '<em> *</em>';
        $labels = array(
            'code' => __('Language') . $required,
            'lang_type' => __('Fluency') . $required,
            'competency' => __('Competency') . $required,
            'comments' => __('Comments'),
        );
        return $labels;
    }
}
?>