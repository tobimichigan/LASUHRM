<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class JobTitleDao extends BaseDao {

    public function getJobTitleList($sortField='jobTitleName', $sortOrder='ASC', $activeOnly = true, $limit = null, $offset = null) {

        $sortField = ($sortField == "") ? 'jobTitleName' : $sortField;
        $sortOrder = ($sortOrder == "") ? 'ASC' : $sortOrder;

        try {
            $q = Doctrine_Query :: create()
                            ->from('JobTitle');
            if ($activeOnly == true) {
                $q->addWhere('isDeleted = ?', JobTitle::ACTIVE);
            }
            $q->orderBy($sortField . ' ' . $sortOrder);
            if (!empty($limit)) {
                $q->offset($offset)
                  ->limit($limit);
            }
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deleteJobTitle($toBeDeletedJobTitleIds) {

        try {
            $q = Doctrine_Query :: create()
                            ->update('JobTitle')
                            ->set('isDeleted', '?', JobTitle::DELETED)
                            ->whereIn('id', $toBeDeletedJobTitleIds);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getJobTitleById($jobTitleId) {

        try {
            return Doctrine::getTable('JobTitle')->find($jobTitleId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getJobSpecAttachmentById($attachId) {

        try {
            return Doctrine::getTable('JobSpecificationAttachment')->find($attachId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}

