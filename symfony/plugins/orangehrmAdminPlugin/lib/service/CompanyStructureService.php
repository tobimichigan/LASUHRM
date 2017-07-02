<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CompanyStructureService extends BaseService {

    private $companyStructureDao;

    public function getCompanyStructureDao() {
        if (!($this->companyStructureDao instanceof CompanyStructureDao)) {
            $this->companyStructureDao = new CompanyStructureDao();
        }
        return $this->companyStructureDao;
    }

    public function setCompanyStructureDao(CompanyStructureDao $dao) {
        $this->companyStructureDao = $dao;
    }

    /**
     * Get sub unit for a given id
     *
     * @version
     * @param int $id Subunit auto incremental id
     * @return Subunit instance if found or a dao exception
     */
    public function getSubunitById($id) {
        return $this->getCompanyStructureDao()->getSubunitById($id);
    }

    /**
     * Save a Subunit
     *
     * If id is not set, it will be set to next available value and a new subunit
     * will be added.
     *
     * If id is set the belonged subunit will be updated.
     *
     * @version
     * @param Subunit $subunit
     * @return boolean
     */
    public function saveSubunit(Subunit $subunit) {
        return $this->getCompanyStructureDao()->saveSubunit($subunit);
    }

    /**
     * Save the parent sub unit again
     *
     * This will update the parent sub unit if the child is changed.
     *
     * @version
     * @param Subunit $parentSubunit
     * @param Subunit $subunit
     * @return boolean
     */
    public function addSubunit(Subunit $parentSubunit, Subunit $subunit) {
        return $this->getCompanyStructureDao()->addSubunit($parentSubunit, $subunit);
    }

    /**
     * Delete subunit
     *
     * This will delete the passed subunit and it's children
     *
     * @version
     * @param Subunit $subunit
     * @return boolean
     */
    public function deleteSubunit(Subunit $subunit) {
        return $this->getCompanyStructureDao()->deleteSubunit($subunit);
    }

    /**
     * Set the organization name to the root of the tree. Previously the root has the name
     * 'Organization' then if the company name is set this will update the root node of the tree
     *
     * @version
     * @param string $name
     * @return int - affected rows
     */
    public function setOrganizationName($name) {
        return $this->getCompanyStructureDao()->setOrganizationName($name);
    }

    /**
     * Get the whole subunit tree
     *
     * @version
     * @return Nested set - Subunit object list
     */
    public function getSubunitTreeObject() {
        return $this->getCompanyStructureDao()->getSubunitTreeObject();
    }

}
