<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class RecruitmentAttachmentDao extends BaseDao {

    /**
     *
     * @param JobVacancyAttachment $attachment
     * @return <type>
     */
    public function saveVacancyAttachment(JobVacancyAttachment $attachment) {
        try {
            if ($attachment->getId() == '') {
                $idGenService = new IDGeneratorService();
                $idGenService->setEntity($attachment);
                $attachment->setId($idGenService->getNextID());
            }
            $attachment->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param JobCandidateAttachment $attachment
     * @return <type>
     */
    public function saveCandidateAttachment(JobCandidateAttachment $attachment) {
        try {
            if ($attachment->getId() == '') {
                $idGenService = new IDGeneratorService();
                $idGenService->setEntity($attachment);
                $attachment->setId($idGenService->getNextID());
            }
            $attachment->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param <type> $attachId
     * @return <type>
     */
    public function getVacancyAttachment($attachId) {
        try {
            $q = Doctrine_Query:: create()
                            ->from('JobVacancyAttachment a')
                            ->where('a.id = ?', $attachId);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param <type> $attachId
     * @return <type>
     */
    public function getInterviewAttachment($attachId) {
        try {
            $q = Doctrine_Query:: create()
                            ->from('JobInterviewAttachment a')
                            ->where('a.id = ?', $attachId);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param <type> $attachId
     * @return <type>
     */
    public function getCandidateAttachment($attachId) {
        try {
            $q = Doctrine_Query:: create()
                            ->from('JobCandidateAttachment a')
                            ->where('a.id = ?', $attachId);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param <type> $vacancyId
     * @return <type>
     */
    public function getVacancyAttachments($vacancyId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('JobVacancyAttachment')
                            ->where('vacancyId =?', $vacancyId)
                            ->orderBy('fileName ASC');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    
    /**
     *
     * @param <type> $interviewId
     * @return <type>
     */
    public function getInterviewAttachments($interviewId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('JobInterviewAttachment')
                            ->where('interview_id =?', $interviewId)
                            ->orderBy('fileName ASC');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
