<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of EmailDao
 *
 */
class EmailDao {

    public function getEmailByName($name) {

        try {

            $query = Doctrine_Query::create()
                    ->select('e.*, t.*, p.*')
                    ->from("Email e")
                    ->leftJoin('e.EmailTemplate t')
                    ->leftJoin('e.EmailProcessor p')
                    ->where("e.name = ?", $name);

            return $query->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     * Get all matching email templates for the given email
     * 
     * fetches templates for given role and records for which role is null.
     * 
     * @param string $name Email Name
     * @param string $locale locale
     * @param string $recipientRole recipient role
     * @param string $performerRole performer role
     */
    public function getEmailTemplateMatches($name, $locale, $recipientRole, $performerRole) {
        try {

            $query = Doctrine_Query::create()
                    ->from("EmailTemplate t")
                    ->leftJoin('t.Email e')
                    ->where("e.name = ?", $name)
                    ->andWhere('t.locale = ?', $locale);
            
            if (empty($recipientRole)) {
                $query->andWhere('t.recipient_role IS NULL');
            } else {
                $query->andWhere('(t.recipient_role IS NULL OR t.recipient_role = ?)', $recipientRole);
            }
            
            if (empty($performerRole)) {
                $query->andWhere('t.performer_role IS NULL');
            } else {
                $query->andWhere('(t.performer_role IS NULL OR t.performer_role = ?)', $performerRole);
            }            
            return $query->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }        
    }

}

