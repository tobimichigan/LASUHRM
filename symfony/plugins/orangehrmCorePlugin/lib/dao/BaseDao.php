<?php

/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 * 
 */

class BaseDao {

    protected function addWhere(Doctrine_Query_Abstract $doctrine, $condtion, $value) {
        $whereExist = $doctrine->getParams('where');
        if ($whereExist[1] > 0) {
            return $doctrine->addWhere($condtion, $value);
        } else {
            return $doctrine->where($condtion, $value);
        }
    }

    protected function getUniqueId($object) {
        $idGenService = new IDGeneratorService();
        $idGenService->setEntity($object);
        return $idGenService->getNextID();
    }

    public function beginTransaction() {
        Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();
    }

    public function commit() {
        Doctrine_Manager::getInstance()->getCurrentConnection()->commit();
    }

    public function rollback() {
        Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
    }

}