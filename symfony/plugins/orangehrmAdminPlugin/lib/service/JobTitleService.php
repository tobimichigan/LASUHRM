<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class JobTitleService extends BaseService {

    private $jobTitleDao;

    public function __construct() {
        $this->jobTitleDao = new JobTitleDao();
    }

    public function getJobTitleDao() {
        if (!($this->jobTitleDao instanceof JobTitleDao)) {
            $this->jobTitleDao = new JobTitleDao();
        }
        return $this->jobTitleDao;
    }

    public function setJobTitleDao(JobTitleDao $jobTitleDao) {
        $this->jobTitleDao = $jobTitleDao;
    }

    /**
     * Returns JobTitlelist - By default this will returns the active jobTitle list
     * To get the all the jobTitles(with deleted) should pass the $activeOnly as false
     *
     * @param string $sortField
     * @param string $sortOrder
     * @param boolean $activeOnly
     * @return JobTitle Doctrine collection
     */
    public function getJobTitleList($sortField='jobTitleName', $sortOrder='ASC', $activeOnly = true, $limit = null, $offset = null) {
        return $this->getJobTitleDao()->getJobTitleList($sortField, $sortOrder, $activeOnly, $limit, $offset);
    }

    /**
     * This will flag the jobTitles as deleted
     *
     * @param array $toBeDeletedJobTitleIds
     * @return int number of affected rows
     */
    public function deleteJobTitle($toBeDeletedJobTitleIds) {
        return $this->getJobTitleDao()->deleteJobTitle($toBeDeletedJobTitleIds);
    }

    /**
     * Will return the JobTitle doctrine object for a purticular id
     *
     * @param int $jobTitleId
     * @return JobTitle doctrine object
     */
    public function getJobTitleById($jobTitleId) {
        return $this->getJobTitleDao()->getJobTitleById($jobTitleId);
    }

    /**
     * Will return the JobSpecificationAttachment doctrine object for a purticular id
     *
     * @param int $attachId
     * @return JobSpecificationAttachment doctrine object
     */
    public function getJobSpecAttachmentById($attachId) {
        return $this->getJobTitleDao()->getJobSpecAttachmentById($attachId);
    }

}

