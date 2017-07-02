<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class OrangeI18NFilter extends sfFilter {

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

    public function execute($filterChain) {

        $languages = $this->getContext()->getRequest()->getLanguages();
        $userCulture = $this->getConfigService()->getAdminLocalizationDefaultLanguage();
        $localizationService = new LocalizationService();
        $languageToSet = (!empty($languages[0]) && $this->getConfigService()->getAdminLocalizationUseBrowserLanguage() == "Yes" && key_exists($languages[0], $localizationService->getSupportedLanguageListFromYML())) ? $languages[0] : $userCulture;
        $datePattern = $this->getContext()->getUser()->getDateFormat();
        $datePattern = isset($datePattern) ? $datePattern : $this->getConfigService()->getAdminLocalizationDefaultDateFormat();

        $user = $this->getContext()->getUser();
        $user->setCulture($languageToSet);
        $user->setDateFormat($datePattern);

        // Execute next filter in filter chain
        $filterChain->execute();
    }

}