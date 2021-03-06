<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of LeaveChangeMailProcessor
 *
 */
class LeaveChangeMailProcessor extends LeaveEmailProcessor {
    
    protected function _generateLeaveDetailsTable($data, $replacements) {

        $logger = $this->getLogger();
        $debugLogEnabled = $logger->isDebugEnabled();
        
        $requestType = isset($data['requestType']) ? $data['requestType'] : 'request';

        if ($debugLogEnabled) {
            $logger->debug("requestType = " . $requestType . ", days = " . count($data['days']));
        }
        
        // Show individual comments in table if there are any leave dates with comments
        $displayIndividualComments = false;
        if ($requestType == 'multiple' && count($data['days']) > 1) {
            
            foreach ($data['days'] as $leave) {
                $thisLeaveComment = $leave->getLatestCommentAsText();
                
                $this->getLogger()->debug("Leave Comment: " . $leaveComment);
                if (!empty($thisLeaveComment)) {
                    $displayIndividualComments = true;
                    break;
                }
            }
        }
        
        $details = '';
        $workFlows = $data['workFlow'];
        
        foreach ($data['changes'] as $workFlowId => $change) {
            
            if (isset($workFlows[$workFlowId])) {
                $action = ucwords(strtolower($workFlows[$workFlowId]->getAction()));
                $resultingState = ucwords(strtolower($workFlows[$workFlowId]->getResultingState()));
                
                $details .= "Action: $action, Resulting State: $resultingState\n\n";
            }
            
            // Length of tab (4 spaces) : "    "

            $details .= "Date(s)                Duration (Hours)";
            if ($displayIndividualComments) {
                $details .= "            Comments";
            }
            $details .= "\n";
            $details .= "=========================";
            if ($displayIndividualComments) {
                $details .= "=========================";
            }        

            $details .= "\n";

            foreach ($change as $leave) {

                $leaveDate = set_datepicker_date_format($leave->getDate());
                $leaveDuration = round($leave->getLengthHours(), 2);

                if ($leaveDuration > 0) {

                    $leaveDuration = $this->_fromatDuration($leaveDuration);
                    $details .= "$leaveDate            $leaveDuration";
                    if ($displayIndividualComments) {
                        $details .= "                " . $this->trimComment($leave->getLatestCommentAsText());
                    }
                    $details .= "\n";

                }

            }
            
            $details .= "\n";

        }
        
        $details .= "Leave type : " . $replacements['leaveType'];
        $details .= "\n";

        $leaveComment = '';
        
        if ($requestType == 'request') {
            $leaveComment = $data['request']->getCommentsAsText();
        } elseif ($requestType == 'single') {
            $leaveComment = $data['days'][0]->getCommentsAsText();
        }

        if (!empty($leaveComment)) {
            $details .= "\n\nComments:\n=========\n$leaveComment";
            $details .= "\n";
        }

        return $details;

    }
    
    public function getReplacements($data) {
        $data['request'] = $data['days'][0]->getLeaveRequest();
        $replacements = parent::getReplacements($data);
        return $replacements;

    }    
    
    protected function getSubscribers($emailName, $data) {        

        $workFlow = $data['workFlow'];
        $recipients = array();

        $logger = $this->getLogger();
        $debugLogEnabled = $logger->isDebugEnabled();
        
        if (is_array($workFlow)) {
            foreach ($workFlow as $item) {
                $action = strtolower($item->getAction());
                $eventRecipients = parent::getSubscribers('leave.' . $action, $data);

                if ($debugLogEnabled) {
                    $logger->debug('Recipient Count for leave.' . $action . ' = ' . count($eventRecipients));
                }

                // check if already there in recipients:
                foreach ($eventRecipients as $new) {
                    $found = false;

                    if ($debugLogEnabled) {
                        $logger->debug('Looking at recipient: ' . $new->getEmail());
                    }                
                    foreach ($recipients as $existing) {
                        if ($existing->getEmail() == $new->getEmail()) {
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $recipients[] = $new;

                        if ($debugLogEnabled) {
                            $logger->debug('Recipient not found, adding to list');
                        }                     
                    }
                }            
            }
        } else {
            $logger->warn('Only one workflow passed to leave.change mail notification');
        }
        
        if ($debugLogEnabled) {
            $logger->debug('Returning Total recipients for leave.change event = ' . count($recipients));
        }
        
        return $recipients;
    }    
    
}

