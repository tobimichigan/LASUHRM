<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmWidgetEmployeeListAutoFill extends sfWidgetFormInput implements ohrmEnhancedEmbeddableWidget {

    private $whereClauseCondition;

    public function configure($options = array(), $attributes = array()) {

        parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        $html = parent::render($name, $value, $attributes, $errors);
        
        $noEmployeeMessage = __('No Employees Available');
        $requiredMessage = __(ValidationMessages::REQUIRED);
        $invalidMessage = __(ValidationMessages::INVALID);
        $typeHint = __('Type for hints') . '...';

        $javaScript = $javaScript = sprintf(<<<EOF
<script type="text/javascript">

    var employees = %s;
    var employeesArray = eval(employees);
    var errorMsge;
    var employeeFlag;
    var empId;
    var valid = false;

$(document).ready(function() {

            if ($("#%s").val() == '') {
                $("#%s").val('%s')
                .addClass("inputFormatHint");
            }

            $("#%s").one('focus', function() {

                if ($(this).hasClass("inputFormatHint")) {
                    $(this).val("");
                    $(this).removeClass("inputFormatHint");
                }
            });

    $("#%s").autocomplete(employees, {

            formatItem: function(item) {
                return $('<div/>').text(item.name).html();
            },
            formatResult: function(item) {
                return item.name;
            }            
            ,matchContains:true
        }).result(function(event, item) {

        }
    );

    $('#viewbutton').click(function() {
                $('#reportForm input.inputFormatHint').val('');
                $('#reportForm').submit();
        });

        $('#reportForm').submit(function(){
            $('#validationMsg').removeAttr('class');
            $('#validationMsg').html("");
            var employeeFlag = validateInput();
            if(!employeeFlag) {
                $('#validationMsg').attr('class', "messageBalloon_failure");
                $('#validationMsg').html(errorMsge);
                return false;
            }
        });
     
 });

function validateInput(){

        var errorStyle = "background-color:#FFDFDF;";
        var empDateCount = employeesArray.length;
        var temp = false;
        var i;

        if(empDateCount==0){

            errorMsge = "$noEmployeeMessage";
            return false;
        }
        for (i=0; i < empDateCount; i++) {
            empName = $.trim($('#%s').val()).toLowerCase();
            arrayName = employeesArray[i].name.toLowerCase();

            if (empName == arrayName) {
                $('#%s').val(employeesArray[i].id);
                empId = employeesArray[i].id
                temp = true
                break;
            }
        }
        if(temp){
            valid = true;
            return true;
        }else if(empName == "" || empName == $.trim("$typeHint").toLowerCase()){
            errorMsge = "$requiredMessage";
            return false;
        }else{
            if(valid != true){
            errorMsge = "$invalidMessage";
            return false;
            }else{
            return true;
            }
        }
    }
 </script>
EOF
                        ,
                        $this->getEmployeeListAsJson(sfContext::getInstance()->getUser()->getAttribute("user")->getEmployeeList()),
                        $this->attributes['id'],
                        $this->attributes['id'],
                        "Type for hints ...",
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id']);

        return $html . $javaScript;
    }

    public function getEmployeeListAsJson($employeeList) {

        $jsonArray = array();
        
        $employeeService = new EmployeeService();
        $employeeService->setEmployeeDao(new EmployeeDao());

        $employeeUnique = array();
        foreach ($employeeList as $employee) {

            if (!isset($employeeUnique[$employee->getEmpNumber()])) {

                $name = $employee->getFirstName() . " " . $employee->getMiddleName();
                $name = trim(trim($name) . " " . $employee->getLastName());

                $employeeUnique[$employee->getEmpNumber()] = $name;
                $jsonArray[] = array('name' => $name, 'id' => $employee->getEmpNumber());
            }
        }

        $jsonString = json_encode($jsonArray);

        return $jsonString;
    }

    /**
     * Embeds this widget into the form. Sets label and validator for this widget.
     * @param sfForm $form
     */
    public function embedWidgetIntoForm(sfForm &$form) {

        $widgetSchema = $form->getWidgetSchema();
        $widgetSchema[$this->attributes['id']] = $this;
        $label = ucwords(str_replace("_", " ", $this->attributes['id']));
        $validator = new sfValidatorString();
        if (isset($this->attributes['required']) && ($this->attributes['required'] == "true") ) {
            $label .= "<span class='required'> * </span>";
            $validator = new sfValidatorString(array('required' => true), array('required' => 'Select a project'));
        }
        $widgetSchema[$this->attributes['id']]->setLabel($label);
        $form->setValidator($this->attributes['id'], $validator);
    }

    /**
     * Sets whereClauseCondition.
     * @param string $condition
     */
    public function setWhereClauseCondition($condition) {

        $this->whereClauseCondition = $condition;
    }

    /**
     * Gets whereClauseCondition. ( if whereClauseCondition is set returns that, else returns default condition )
     * @return string ( a condition )
     */
    public function getWhereClauseCondition() {

        if (isset($this->whereClauseCondition)) {
            $setCondition = $this->whereClauseCondition;
            return $setCondition;
        } else {
            $defaultCondition = "=";
            return $defaultCondition;
        }
    }

    /**
     * This method generates the where clause part.
     * @param string $fieldName
     * @param string $value
     * @return string
     */
    public function generateWhereClausePart($fieldName, $value) {

        $whereClausePart = $fieldName . " " . $this->getWhereClauseCondition() . " " . $value;

        return $whereClausePart;
    }
    
    public function getDefaultValue(SelectedFilterField $selectedFilterField) {
        return $selectedFilterField->value1;
    }
}

