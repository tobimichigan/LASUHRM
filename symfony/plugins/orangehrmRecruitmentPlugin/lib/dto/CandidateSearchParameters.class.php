<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CandidateSearchParameters {

    private $jobTitleCode;
    private $hiringManagerId;
    private $fromDate = '1900-01-01';
    private $toDate = '2200-01-01';
    private $modeOfApplication;
    private $keywords;
    private $vacancyId;
    private $status;
    private $candidateId;
    private $candidateStatus = array(JobCandidate::ACTIVE);
    private $vacancyStatus;
    private $sortField = 'jc.date_of_application';
    private $sortOrder = 'DESC';
    private $candidateName;
    private $vacancyName;
    private $hiringManagerName;
    private $statusName;
    private $dateOfApplication;
    private $offset = 0;
    private $limit = 50;
    private $candidateAndVacancyId;
    private $attachmentId;
    private $linkName;
    private $allowedCandidateList;
    private $allowedVacancyList;
    private $isAdmin;
    private $additionalParams;
    private $empNumber;

    public function getAllowedCandidateList() {
        return $this->allowedCandidateList;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function getEmpNumber() {
        return $this->empNumber;
    }

    public function getAllowedVacancyList() {
        return $this->allowedVacancyList;
    }

    public function getJobTitleCode() {
        return $this->jobTitleCode;
    }

    public function getHiringManagerId() {
        return $this->hiringManagerId;
    }

    public function getFromDate() {
        return $this->fromDate;
    }

    public function getToDate() {
        return $this->toDate;
    }

    public function getModeOfApplication() {
        return $this->modeOfApplication;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getVacancyId() {
        return $this->vacancyId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCandidateId() {
        return $this->candidateId;
    }

    public function getCandidateStatus($withDefault = true) {
        $additionalParams = $this->getAdditionalParams();
        if(is_array($additionalParams) && array_key_exists('candidateArchiveOptions', $additionalParams)) {
            $this->candidateStatus = explode(',', $additionalParams['candidateArchiveOptions']);
        } else {
            $this->candidateStatus = ($withDefault) ? array(JobCandidate::ACTIVE) : array();
        }
        return $this->candidateStatus;
    }

    public function getVacancyStatus() {
        return $this->vacancyStatus;
    }

    public function getSortField() {
        return $this->sortField;
    }

    public function getSortOrder() {
        return $this->sortOrder;
    }

    public function getCandidateName() {
        return $this->candidateName;
    }

    public function getVacancyName() {
        return ($this->vacancyStatus == JobVacancy::CLOSED) ? $this->vacancyName . " (Closed)" : $this->vacancyName;
    }

    public function getHiringManagerName() {
        return $this->hiringManagerName;
    }

    public function getStatusName() {
        return $this->statusName;
    }

    public function getDateOfApplication() {
        return $this->dateOfApplication;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getAttachmentId() {
        return $this->attachmentId;
    }

    public function getLink() {
        if (!empty($this->attachmentId)) {
            $this->linkName = __("Download");
        }
        return $this->linkName;
    }

    public function getCandidateAndVacancyId() {
        return $this->candidateId . "_" . $this->vacancyId;
    }

    public function setAllowedCandidateList($allowedCandidateList) {
        $this->allowedCandidateList = $allowedCandidateList;
    }

    public function setAllowedVacancyList($allowedVacancyList) {
        $this->allowedVacancyList = $allowedVacancyList;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function setJobTitleCode($jobTitleCode) {
        $this->jobTitleCode = $jobTitleCode;
    }

    public function setHiringManagerId($hiringManagerId) {
        $this->hiringManagerId = $hiringManagerId;
    }

    public function setFromDate($fromDate) {
        if (!empty($fromDate)) {
            $this->fromDate = $fromDate;
        }
    }

    public function setToDate($toDate) {
        if (!empty($toDate)) {
            $this->toDate = $toDate;
        }
    }

    public function setModeOfApplication($modeOfApplication) {
        $this->modeOfApplication = $modeOfApplication;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    public function setVacancyId($vacancyId) {
        $this->vacancyId = $vacancyId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCandidateId($candidateId) {
        $this->candidateId = $candidateId;
    }

    public function setCandidateStatus($candidateStatus) {
        $this->candidateStatus = $candidateStatus;
    }

    public function setVacancyStatus($vacancyStatus) {
        $this->vacancyStatus = $vacancyStatus;
    }

    public function setSortField($sortField) {
        if (!empty($sortField)) {
            $this->sortField = $sortField;
        }
    }

    public function setSortOrder($sortOrder) {
        if (!empty($sortOrder)) {
            $this->sortOrder = $sortOrder;
        }
    }

    public function setCandidateName($candidateName) {
        $this->candidateName = $candidateName;
    }

    public function setVacancyName($vacancyName) {
        $this->vacancyName = $vacancyName;
    }

    public function setHiringManagerName($hiringManagerName) {
        $this->hiringManagerName = $hiringManagerName;
    }

    public function setStatusName($statusName) {
        $this->statusName = $statusName;
    }

    public function setDateOfApplication($dateOfApplication) {
        $this->dateOfApplication = $dateOfApplication;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
    }

    public function setLimit($limit) {
        if (!empty($limit)) {
            $this->limit = $limit;
        }
    }

    public function setAttachmentId($attachmentId) {
        $this->attachmentId = $attachmentId;
    }

    public function setEmpNumber($empNumber) {
        $this->empNumber = $empNumber;
    }

    public function getAdditionalParams() {
        return $this->additionalParams;
    }

    public function setAdditionalParams($params) {
        $this->additionalParams = $params;
    }

    public function getDisplayDateOfApplication(){
        return set_datepicker_date_format($this->dateOfApplication);
    }

}

