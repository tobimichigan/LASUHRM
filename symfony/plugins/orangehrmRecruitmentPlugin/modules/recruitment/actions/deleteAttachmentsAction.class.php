<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteAttachmentsAction extends sfAction {

    /**
     *
     * @param <type> $request 
     */
    public function execute($request) {

        $screen = $request->getParameter('screen');
        $param = array('screen' => $screen);
        $this->form = new RecruitmentAttachmentDeleteForm(array(), $param, true);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $attachmentsToDelete = $request->getParameter('delAttachments', array());
            if ($attachmentsToDelete) {
                for ($i = 0; $i < sizeof($attachmentsToDelete); $i++) {
                    $service = new RecruitmentAttachmentService();
                    $attachment = $service->getAttachment($attachmentsToDelete[$i], $this->form->screen);
                    $attachment->delete();
                }
                $this->getUser()->setFlash('jobAttachmentPane.success', __(TopLevelMessages::DELETE_SUCCESS));
            }
        }

        $this->redirect($this->getRequest()->getReferer() . '#attachments');
    }

}