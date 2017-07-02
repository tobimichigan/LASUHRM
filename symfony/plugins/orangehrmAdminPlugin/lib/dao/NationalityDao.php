<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class NationalityDao extends BaseDao {
    
    public function getNationalityList() {

        try {
            $q = Doctrine_Query :: create()
                            ->from('Nationality')
                            ->orderBy('name ASC');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getNationalityById($id) {

        try {
            return Doctrine :: getTable('Nationality')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deleteNationalities($nationalityList) {
        try {
            $q = Doctrine_Query::create()
                            ->delete('Nationality')
                            ->whereIn('id', $nationalityList);

            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
