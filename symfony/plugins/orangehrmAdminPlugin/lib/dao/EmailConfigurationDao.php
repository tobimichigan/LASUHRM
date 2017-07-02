<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmailConfigurationDao extends BaseDao {

    public function getEmailConfiguration() {
        try {
            $q = Doctrine_Query::create()->from('EmailConfiguration')->fetchOne();
            return $q;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function saveEmailConfiguration(EmailConfiguration $emailConfiguration) {
        try {
            $emailConfiguration->save();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}
