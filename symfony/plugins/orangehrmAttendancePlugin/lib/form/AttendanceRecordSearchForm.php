<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class AttendanceRecordSearchForm extends sfForm {

    public function configure() {

        $date = $this->getOption('date');
        $employeeId = $this->getOption('employeeId');
        $trigger = $this->getOption('trigger');

        $this->setWidgets(array(
            'employeeName' => new ohrmWidgetEmployeeNameAutoFill(array('jsonList' => $this->getEmployeeListAsJson()), array('class' => 'formInputText')),
            'date' => new ohrmWidgetDatePicker(array(), array('id' => 'attendance_date'), array('class' => 'formDateInput'))
        ));

        if ($trigger) {
            $this->setDefault('employeeName', $this->getEmployeeName($employeeId));
            $this->setDefault('date', set_datepicker_date_format($date));
        }

        $this->widgetSchema->setNameFormat('attendance[%s]');

        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();
        $this->setValidators(array(
            'date' => new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => true),
                    array('invalid' => 'Date format should be ' . $inputDatePattern)),
            'employeeName' => new ohrmValidatorEmployeeNameAutoFill()
        ));

        $this->getWidgetSchema()->setLabels($this->getFormLabels());

    }

    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        $requiredMarker = ' <em> *</em>';

        $labels = array(
            'employeeName' => __('Employee Name'),
            'date' => __('Date') . $requiredMarker
        );

        return $labels;
    }

    public function getEmployeeListAsJson() {

        $jsonArray = array();
        $employeeService = new EmployeeService();
        $employeeService->setEmployeeDao(new EmployeeDao());

        $employeeList = UserRoleManagerFactory::getUserRoleManager()->getAccessibleEntities('Employee');
        $employeeUnique = array();
        $jsonArray[] = array('name' => __('All'), 'id' => '');
        foreach ($employeeList as $employee) {

            if (!isset($employeeUnique[$employee->getEmpNumber()])) {

                $name = $employee->getFullName();
                $employeeUnique[$employee->getEmpNumber()] = $name;
                $jsonArray[] = array('name' => $name, 'id' => $employee->getEmpNumber());
            }
        }

        $jsonString = json_encode($jsonArray);

        return $jsonString;
    }

    public function getEmployeeName($employeeId) {

        $employeeService = new EmployeeService();
        $employee = $employeeService->getEmployee($employeeId);
        if ($employee->getMiddleName() != null) {
            return $employee->getFirstName() . " " . $employee->getMiddleName() . " " . $employee->getLastName();
        } else {
            return $employee->getFirstName() . " " . $employee->getLastName();
        }
    }

}