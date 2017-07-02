<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Config Dao: Manages configuration entries in hs_hr_config
 *
 */
class ConfigDao extends BaseDao {

    private $logger;
    
    /**
     * Get Logger instance. Creates if not already created.
     *
     * @return Logger
     */
    protected function getLogger() {
        if (is_null($this->logger)) {
            $this->logger = Logger::getLogger('core.ConfigDao');
        }

        return($this->logger);
    }
    
    /**
     * Set $key to given $value
     * @param type $key Key
     * @param type $value Value
     */
    public function setValue($key, $value) {
        try {
            $config = new Config();
            $config->key = $key;
            $config->value = $value;
            $config->replace();

        } catch (Exception $e) {
            $this->getLogger()->error("Exception in setValue:" . $e);
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }        
    }
    
    /**
     * Get value corresponding to given $key
     * @param type $key Key
     * @return String value
     */
    public function getValue($key) {
        try {
            $q = Doctrine_Query::create()
                 ->select('c.value')
                 ->from('Config c')
                 ->where('c.key = ?', $key);
            $value = $q->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
      
            return $value;
        } catch (Exception $e) {
            $this->getLogger()->error("Exception in getValue:" . $e);
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
       
    }
}