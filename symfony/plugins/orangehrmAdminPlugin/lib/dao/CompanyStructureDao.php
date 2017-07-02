<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CompanyStructureDao extends BaseDao {

    public function getSubunitById($id) {
        try {
            return Doctrine::getTable('Subunit')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function saveSubunit(Subunit $subunit) {
        try {
            if ($subunit->getId() == '') {
                $subunit->setId(0);
            } else {
                $tempObj = Doctrine::getTable('Subunit')->find($subunit->getId());

                $tempObj->setName($subunit->getName());
                $tempObj->setDescription($subunit->getDescription());
                $tempObj->setUnitId($subunit->getUnitId());
                $subunit = $tempObj;
            }

            $subunit->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function addSubunit(Subunit $parentSubunit, Subunit $subunit) {
        try {
            $subunit->setId(0);
            $subunit->getNode()->insertAsLastChildOf($parentSubunit);

            $parentSubunit->setRgt($parentSubunit->getRgt() + 2);
            $parentSubunit->save();

            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deleteSubunit(Subunit $subunit) {
        try {
            $q = Doctrine_Query::create()
                            ->delete('Subunit')
                            ->where('lft >= ?', $subunit->getLft())
                            ->andWhere('rgt <= ?', $subunit->getRgt());
            $q->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function setOrganizationName($name) {
        try {
            $q = Doctrine_Query:: create()->update('Subunit')
                            ->set('name', '?', $name)
                            ->where('id = 1');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getSubunitTreeObject() {
        try {
            return Doctrine::getTable('Subunit')->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
