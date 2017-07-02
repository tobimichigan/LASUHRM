<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class ohrmWidgetProjectList extends sfWidgetForm implements ohrmEmbeddableWidget {

    private $whereClauseCondition;

    public function configure($options = array(), $attributes = array()) {

        $projectNameList = $this->_getProjectList();

        $this->addOption('choices', $projectNameList);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $value = $value === null ? 'null' : $value;

        $options = array();

        foreach ($this->getOption('choices') as $key => $option) {
            $attributes = array('value' => self::escapeOnce($key));

            $options[] = $this->renderContentTag(
                            'option',
                            self::escapeOnce($option),
                            $attributes
            );
        }

        $html = $this->renderContentTag(
                        'select',
                        "\n" . implode("\n", $options) . "\n",
                        array_merge(array('name' => $name), $attributes
                ));

        return $html;
    }

    /**
     * Gets all the names of available projects, including deleted projects.
     * @return array() $projectNameList
     */
    private function _getProjectList() {

        $projectNameList = array();
        $userObj = sfContext::getInstance()->getUser()->getAttribute("user");
        $projectList = $userObj->getActiveProjectList();

        if (!empty($projectList)) {
            
            foreach ($projectList as $project) {
                $projectNameList[$project->getProjectId()] = $project->getCustomer()->getName() . " - " . $project->getName();
            }
            
            // order by customer name, project name
            asort($projectNameList);
            
            // push -- Select -- to front 
            $projectNameList = array(null => "--" . __("Select") . "--") + $projectNameList;
        } else {
            $projectNameList[null] = "--" . __("No Projects") . "--";
        }

        return $projectNameList;
    }

    /**
     * Embeds this widget into the form. Sets label and validator for this widget.
     * @param sfForm $form
     */
    public function embedWidgetIntoForm(sfForm &$form) {

        $userObj = sfContext::getInstance()->getUser()->getAttribute("user");
        $projectList = $userObj->getActiveProjectList();
        $requiredMess = __('Select a project');

        if ($projectList == null) {
            $requiredMess = __("No Projects Defined");
        }

        $widgetSchema = $form->getWidgetSchema();
        $widgetSchema[$this->attributes['id']] = $this;
        $label = __(ucwords(str_replace("_", " ", $this->attributes['id'])));
        $validator = new sfValidatorString();
        if ($this->attributes['required'] == "true") {
            $label .= "<span class='required'> * </span>";
            $validator = new sfValidatorString(array('required' => true), array('required' => $requiredMess));
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

}