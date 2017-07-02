<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of getLeaveCommentAjaxActin
 */
class getLeaveCommentsAjaxAction extends baseCoreLeaveAction {

    public function execute($request) {
        
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
       
        $leaveId = $request->getParameter("leaveId");
        $leaveRequestId = $request->getParameter('leaveRequestId');
        
        $comments = array();
        $leaveRequestService = $this->getLeaveRequestService();
        
        if (!empty($leaveRequestId)) {
            $comments = $leaveRequestService->getLeaveRequestComments($leaveRequestId);
        } else if (!empty($leaveId)) {
            $comments = $leaveRequestService->getLeaveComments($leaveId);
        }        

        
        $returnData = array();
        
        if (count($comments) > 0) {
            
            foreach ($comments as $comment) {
                $commentDate = new DateTime($comment->getCreated());
                $row['date'] = set_datepicker_date_format($commentDate->format('Y-m-d'));
                $row['time'] = $commentDate->format('H:i');
                $row['author'] = $comment->getCreatedByName();
                $row['comments'] = $comment->getComments();
                
                $returnData[] = $row;
            }
        }
        
        
        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);
        
        return $this->renderText(json_encode($returnData));
    }    
}
