<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class ExceptionCatcherFilter extends sfFilter {

    public function execute($filterChain) {
        
        try {

            $filterChain->execute();

        } catch (sfStopException $e) {

            throw $e; // This is an internally used symfony exception and shouldn't be blocked

        } catch (Exception $e) {

            $logger = Logger::getLogger('filter.ExceptionCatcherFilter');
            $logger->error('Uncaught Exception: ' . $e);
            
            echo "<h2>An internal error occurred. Please contact your system administrator. </h2>";

        }

    }

}