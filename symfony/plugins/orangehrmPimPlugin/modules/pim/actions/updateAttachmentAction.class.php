<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module updateAttachmentAction
 */
class updateAttachmentAction extends basePimAction {

    /**
     * Add / update employee attachment
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $this->form = new EmployeeAttachmentForm(array(),
                        array('loggedInUser' => $loggedInEmpNum,
                            'loggedInUserName' => $loggedInUserName), true);

        if ($this->getRequest()->isMethod('post')) {

            $attachId = $request->getParameter('seqNO');
            $screen = $request->getParameter('screen');
            
            $permission = $this->getDataGroupPermissions($screen. '_attachment', $request->getParameter('EmpID'));

            if ((empty($attachId) && $permission->canCreate()) || $permission->canUpdate()) {

                // Handle the form submission
                $this->form->bind($request->getPostParameters(), $request->getFiles());

                if ($this->form->isValid()) {

                    $empNumber = $this->form->getValue('EmpID');
                    if (!$this->IsActionAccessible($empNumber)) {
                        $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
                    }

                    $this->form->save();
                    $this->getUser()->setFlash('listAttachmentPane.success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {

                    $validationMsg = '';
                    foreach ($this->form->getWidgetSchema()->getPositions() as $widgetName) {
                        if ($this->form[$widgetName]->hasError()) {
                            $validationMsg .= __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE);
                        }
                    }

                    $this->getUser()->setFlash('saveAttachmentPane.warning',$validationMsg);
                    $this->getUser()->setFlash('attachmentComments', $request->getParameter('txtAttDesc'));
                    $this->getUser()->setFlash('attachmentSeqNo', $request->getParameter('seqNO'));
                }
            }
        }

        $this->redirect($this->getRequest()->getReferer() . '#attachments');
    }

}
