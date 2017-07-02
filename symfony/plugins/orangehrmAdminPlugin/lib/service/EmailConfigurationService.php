<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmailConfigurationService extends BaseService {

    private $emailConfigurationDao;

    /**
     * Construct
     */
    public function __construct() {
        $this->emailConfigurationDao = new EmailConfigurationDao();
    }

    /**
     * @ignore
     */
    public function getEmailConfigurationDao() {
        return $this->emailConfigurationDao;
    }

    /**
     * @ignore
     */
    public function setEmailConfigurationDao(EmailConfigurationDao $emailConfigurationDao) {
        $this->emailConfigurationDao = $emailConfigurationDao;
    }

    /**
     * Retrieve EmailConfiguration
     * 
     * Fetch the existing email configuration or create a new one if not exists
     * 
     * @version 2.7 
     * @return Doctrine Collection 
     */
    public function getEmailConfiguration() {
        $emailConfiguration = $this->emailConfigurationDao->getEmailConfiguration();
        
        if (!$emailConfiguration) {
            $emailConfiguration = new EmailConfiguration();
            $emailConfiguration->setId(1);
            return $emailConfiguration;
        } else {
            return $emailConfiguration;
        }
    }
    
    /**
     * Save EmailConfiguration
     * 
     * Can be used for a new record or updating.
     * 
     * @version 2.7
     * @param EmailConfiguration $emailConfiguration
     * @return NULL Doesn't return a value
     */
    public function saveEmailConfiguration(EmailConfiguration $emailConfiguration) {
        $this->emailConfigurationDao->saveEmailConfiguration($emailConfiguration);
    }


}

?>
