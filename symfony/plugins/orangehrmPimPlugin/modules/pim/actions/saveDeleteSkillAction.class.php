<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveDeleteSkillAction extends basePimAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setSkillForm(sfForm $form) {
        if (is_null($this->skillForm)) {
            $this->skillForm = $form;
        }
    }

    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $skill = $request->getParameter('skill');
        $empNumber = (isset($skill['emp_number'])) ? $skill['emp_number'] : $request->getParameter('empNumber');

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $this->skillPermissions = $this->getDataGroupPermissions('qualification_skills', $empNumber);

        $this->setSkillForm(new EmployeeSkillForm(array(), array('empNumber' => $empNumber, 'skillPermissions' => $this->skillPermissions), true));

        if ($request->isMethod('post')) {
            if ($request->getParameter('option') == "save") {
                if ($this->skillPermissions->canCreate() || $this->skillPermissions->canUpdate()) {

                    $this->skillForm->bind($request->getParameter($this->skillForm->getName()));

                    if ($this->skillForm->isValid()) {
                        $skill = $this->getSkill($this->skillForm);
                        $this->getEmployeeService()->saveEmployeeSkill($skill);
                        $this->getUser()->setFlash('skill.success', __(TopLevelMessages::SAVE_SUCCESS));
                    } else {
                        $this->getUser()->setFlash('skill.warning', __('Form Validation Failed'));
                    }
                }
            }

            //this is to delete 
            if ($request->getParameter('option') == "delete") {
                if ($this->skillPermissions->canDelete()) {
                    $deleteIds = $request->getParameter('delSkill');

                    if (count($deleteIds) > 0) {
                        if ($form->isValid()) {
                            $this->getEmployeeService()->deleteEmployeeSkills($empNumber, $request->getParameter('delSkill'));
                            $this->getUser()->setFlash('skill.success', __(TopLevelMessages::DELETE_SUCCESS));
                        }
                    }
                }
            }
        }
        $this->getUser()->setFlash('qualificationSection', 'skill');
        $this->redirect('pim/viewQualifications?empNumber=' . $empNumber . '#skill');
    }

    private function getSkill(sfForm $form) {

        $post = $form->getValues();

        $skill = $this->getEmployeeService()->getEmployeeSkills($post['emp_number'], $post['code']);

        if (!$skill instanceof EmployeeSkill) {
            $skill = new EmployeeSkill();
        }

        $skill->emp_number = $post['emp_number'];
        $skill->skillId = $post['code'];
        $skill->years_of_exp = $post['years_of_exp'];
        $skill->comments = $post['comments'];

        return $skill;
    }

}