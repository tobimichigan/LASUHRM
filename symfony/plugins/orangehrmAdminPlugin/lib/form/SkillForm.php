<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class SkillForm extends BaseForm {
    
    private $skillService;
    
    public function getSkillService() {
        
        if (!($this->skillService instanceof SkillService)) {
            $this->skillService = new SkillService();
        }
        
        return $this->skillService;
    }

    public function setSkillService($skillService) {
        $this->skillService = $skillService;
    }

    public function configure() {

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText(),
            'description' => new sfWidgetFormTextArea(array(),array('rows'=>5,'cols'=>10)),
        ));

        $this->setValidators(array(
            'id' => new sfValidatorNumber(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 120)),
            'description' => new sfValidatorString(array('required' => false, 'max_length' => 250)),
        ));

        $this->widgetSchema->setNameFormat('skill[%s]');

        $this->setDefault('id', '');
	}
    
    public function save() {
        
        $id = $this->getValue('id');
        
        if (empty($id)) {
            $skill = new Skill();
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::SAVE_SUCCESS));
        } else {
            $skill = $this->getSkillService()->getSkillById($id);
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::UPDATE_SUCCESS));
        }
        
        $skill->setName($this->getValue('name'));
        $skill->setDescription($this->getValue('description'));            
        $this->getSkillService()->saveSkill($skill);        
        
        return $message;
        
    }
    
    public function getSkillListAsJson() {

        $list = array();
        $skillList = $this->getSkillService()->getSkillList();
        foreach ($skillList as $skill) {
            $list[] = array('id' => $skill->getId(), 'name' => $skill->getName());
        }
        return json_encode($list);
    }

}

?>
