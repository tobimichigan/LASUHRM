<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class attachmentsComponent extends sfComponent {

	/**
	 * Get RecruitmentAttachmentService
	 * @returns RecruitmentAttachmentService
	 */
	public function getRecruitmentAttachmentService() {
		if (is_null($this->recruitmentAttachmentService)) {
			$this->recruitmentAttachmentService = new RecruitmentAttachmentService();
			$this->recruitmentAttachmentService->setRecruitmentAttachmentDao(new RecruitmentAttachmentDao());
		}
		return $this->recruitmentAttachmentService;
	}

	/**
	 * Execute method of component
	 *
	 * @param type $request
	 */
	public function execute($request) {

		$this->scrollToAttachments = false;

		if ($this->getUser()->hasFlash('attachmentMessage')) {

			$this->scrollToAttachments = true;
			list($this->attachmentMessageType, $this->attachmentMessage) = $this->getUser()->getFlash('attachmentMessage');
		}

		//$attachments = $this->getRecruitmentAttachmentService()->getVacancyAttachment($this->id);
		$attachments = $this->getRecruitmentAttachmentService()->getAttachments($this->id, $this->screen);
		$this->attachmentList = array();
		if (!empty($attachments)) {
			foreach ($attachments as $attachment) {
				$this->attachmentList[] = $attachment;
			}
		}
		$param = array('screen' => $this->screen);
		$this->form = new RecruitmentAttachmentForm(array(), $param, true);
		$this->deleteForm = new RecruitmentAttachmentDeleteForm(array(), $param, true);
	}

}
