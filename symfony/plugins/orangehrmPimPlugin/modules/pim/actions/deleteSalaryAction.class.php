<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteSalaryAction extends basePimAction {    
    
    public function execute($request) {

        $empNumber = $request->getParameter('empNumber');

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        

        if ($request->isMethod('post')) {
            $form = new DefaultListForm(array(), array(), true);
            $form->bind($request->getParameter($form->getName()));
            $deleteIds = $request->getParameter('delSalary');

            if (count($deleteIds) > 0) {
                if ($form->isValid()) {
                $this->getEmployeeService()->deleteEmployeeSalaryComponents($empNumber, $deleteIds);
                $this->getUser()->setFlash('salary.success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }

        }
        $this->redirect('pim/viewSalaryList?empNumber='. $empNumber);
    }

}
?>