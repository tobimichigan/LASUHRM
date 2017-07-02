<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of upgradeLeaveModuleTask
 */
class upgradeLeaveModuleTask extends sfBaseTask {

    protected function configure() {


        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
        ));

        $this->namespace = '';
        $this->name = 'UpgradeLeaveModule';
        $this->briefDescription = 'This task will upgrade leave related database tables';
        $this->detailedDescription = <<<EOF
This task will upgrade leave related database tables

  [php symfony UpgradeLeaveModule|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {

        $databaseManager = new sfDatabaseManager($this->configuration);
        $pdo = $databaseManager->getDatabase(isset($options['connection']) ? $options['connection'] : null)->getConnection();
        
        try {
            $sqlString = file_get_contents(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'orangehrmLeavePlugin' . DIRECTORY_SEPARATOR .'install'. DIRECTORY_SEPARATOR . 'upgrade.sql');
            $queries = explode(';', $sqlString);
            
            foreach ($queries as $query) {
                $pdo->exec($query);
            }

        } catch (Exception $e) {

            return "<br>Exception: Tables already created or SQL error \n ";
        }
        
    }

}
