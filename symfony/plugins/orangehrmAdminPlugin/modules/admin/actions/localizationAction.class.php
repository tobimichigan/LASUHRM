<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * this action is used to set languages and the different date formats for the OrangeHRM
 */
class localizationAction extends sfAction {

    private $configService;

    /**
     * to get confuguration service
     * @return <type>
     */
    public function getConfigService() {
        if (is_null($this->configService)) {
            $this->configService = new ConfigService();
            $this->configService->setConfigDao(new ConfigDao());
        }
        return $this->configService;
    }

    /**
     *  to set configuration service
     * @param ConfigService $configService
     */
    public function setConfigService(ConfigService $configService) {
        $this->configService = $configService;
    }

    /**
     * to set Localization form
     * @param sfForm $form
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    /**
     * execute function
     * @param <type> $request
     */
    public function execute($request) {
        
        $this->_checkAuthentication();

        $this->setForm(new LocalizationForm());
        $languages = $this->getRequest()->getLanguages();
        $this->browserLanguage = $languages[0];

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                
                // For reloading main menu (index.php)
                $_SESSION['load.admin.localization'] = true;

                $formValues = $this->form->getFormValues();               
                $defaultLanguage = $formValues['defaultLanguage'];
                $setBrowserLanguage = !empty($formValues['setBrowserLanguage']) ? "Yes" : "No";
                $supprotedLanguages = $this->form->getLanguages();
                if($setBrowserLanguage == "Yes" && in_array($languages[0], $supprotedLanguages)){
                   $defaultLanguage = $languages[0];
                }
                $this->getUser()->setCulture($defaultLanguage);
                $this->getConfigService()->setAdminLocalizationDefaultLanguage($formValues['defaultLanguage']);
                $this->getConfigService()->setAdminLocalizationUseBrowserLanguage($setBrowserLanguage);
                $this->getUser()->setDateFormat($formValues['defaultDateFormat']);
                $this->getConfigService()->setAdminLocalizationDefaultDateFormat($formValues['defaultDateFormat']);

                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                $this->redirect("admin/localization");
            }
        }
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('auth/login');
		}
        
    }      

}

