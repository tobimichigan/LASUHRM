<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveDeleteEducationAction extends basePimAction {
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setEducationForm(sfForm $form) {
        if (is_null($this->educationForm)) {
            $this->educationForm = $form;
        }
    }
    
    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $education = $request->getParameter('education');
        $empNumber = (isset($education['emp_number']))?$education['emp_number']:$request->getParameter('empNumber');

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        $this->educationPermissions = $this->getDataGroupPermissions('qualification_education', $empNumber);
        
        $this->setEducationForm(new EmployeeEducationForm(array(), array('empNumber' => $empNumber, 'educationPermissions' => $this->educationPermissions), true));

        if ($request->isMethod('post')) {
            if ( $request->getParameter('option') == "save") {
              
                $this->educationForm->bind($request->getParameter($this->educationForm->getName()));

                if ($this->educationForm->isValid()) {
                    $education = $this->getEducation($this->educationForm);

                    if (!empty($education)) {
                        $this->getEmployeeService()->saveEmployeeEducation($education);
                        $this->getUser()->setFlash('education.success', __(TopLevelMessages::SAVE_SUCCESS));
                    }
                } else {
                    $this->getUser()->setFlash('education.warning', __('Form Validation Failed'));
                }
            }

            //this is to delete 
            if ($this->educationPermissions->canDelete()) {
                if ($request->getParameter('option') == "delete") {
                    $deleteIds = $request->getParameter('delEdu');

                    if(count($deleteIds) > 0) {
                        if ($form->isValid()) {
                            $this->getEmployeeService()->deleteEmployeeEducationRecords($empNumber, $request->getParameter('delEdu'));
                            $this->getUser()->setFlash('education.success', __(TopLevelMessages::DELETE_SUCCESS));
                        }
                    }
                }
            }
        }
        $this->getUser()->setFlash('qualificationSection', 'education');
        $this->redirect('pim/viewQualifications?empNumber='. $empNumber . '#education');
    }

    private function getEducation(sfForm $form) {

        $post = $form->getValues(); 
        
        $isAllowed = FALSE;
        if (!empty($post['id'])) {
            if($this->educationPermissions->canUpdate()){
                $education = $this->getEmployeeService()->getEducation($post['id']);
                $isAllowed = TRUE;
            }
        } 
        
        if (!$education instanceof EmployeeEducation) {
            if ($this->educationPermissions->canCreate()) {
                $education = new EmployeeEducation();
                $isAllowed = TRUE;
            }
        }        

        if ($isAllowed) {
            $education->empNumber = $post['emp_number'];
            $education->educationId = $post['code'];
            $education->institute = $post['institute'];
            $education->major = $post['major'];
            $education->year = $post['year'];
            $education->score = $post['gpa'];
            $education->startDate = $post['start_date'];
            $education->endDate = $post['end_date'];
        }
        
        return $education;
    }
}
?>