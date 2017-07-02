<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class updateAttachmentAction extends sfAction {

    /**
     *
     * @param <type> $request 
     */
    public function execute($request) {

	$screen = $request->getParameter('screen');
	$param = array('screen' => $screen);
        $this->form = new RecruitmentAttachmentForm(array(), $param, true);

        if ($this->getRequest()->isMethod('post')) {

            if ($_FILES['recruitmentAttachment']['size']['ufile'] > 1024000 || $_FILES == null) {

                $this->getUser()->setFlash('attachmentMessage', array('warning', __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE)));
                $this->redirect($this->getRequest()->getReferer() . '#attachments');
            }
            // Handle the form submission
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

            if ($this->form->isValid()) {
                $this->form->save();
//                $this->getUser()->setFlash('attachmentMessage', array('success', __(TopLevelMessages::SAVE_SUCCESS)));
                $this->getUser()->setFlash('jobAttachmentPane.success', __(TopLevelMessages::SAVE_SUCCESS));
            }
        }
        $this->redirect($this->getRequest()->getReferer() . '#attachments');
    }

}
