<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Custom execution filter that includes form js and css files in the request
 */
class orangehrmExecutionFilter extends sfExecutionFilter {

    /**
     * Executes the execute method of an action.
     *
     * @param sfAction $actionInstance An sfAction instance
     *
     * @return string The view type
     */
    protected function executeAction($actionInstance) {
        // execute the action
        $viewName = parent::executeAction($actionInstance);

        // Add form js and stylesheets to response
        if ($viewName != sfView::NONE) {

            $response = $actionInstance->getResponse();

            $actionVars = $actionInstance->getVarHolder()->getAll();
            foreach ($actionVars as $var) {
                if ($var instanceof sfForm) {

                    foreach ($var->getStylesheets() as $file => $media) {
                        $response->addStylesheet($file, '', array('media' => $media));
                    }
                    foreach ($var->getJavascripts() as $file) {
                        $response->addJavascript($file);
                    }
                }
            }
        }

        return $viewName;
    }

}
