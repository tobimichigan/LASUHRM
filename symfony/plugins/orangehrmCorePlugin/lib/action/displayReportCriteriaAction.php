<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
abstract class displayReportCriteriaAction extends sfAction {

    protected $request;

    public function execute($request) {

        $reportId = $request->getParameter("reportId");
       
        $reportGeneratorService = new ReportGeneratorService();
        $runtimeFilterFieldWidgetNamesAndLabelsList = $reportGeneratorService->getRuntimeFilterFieldWidgetNamesAndLabels($reportId);
        $this->reportName = $reportGeneratorService->getReportName($reportId);

        $this->runtimeFilterFieldWidgetNamesAndLabelsList = $runtimeFilterFieldWidgetNamesAndLabelsList;
        $selectedRuntimeFilterFieldList = $reportGeneratorService->getSelectedRuntimeFilterFields($reportId);

        $ohrmFormGenerator = new ohrmFormGenerator();
        $this->reportForm = $ohrmFormGenerator->generateForm($runtimeFilterFieldWidgetNamesAndLabelsList);

        if ($request->isMethod('post')) {

            $this->reportForm->bind($request->getParameter($this->reportForm->getName()));

            if ($this->reportForm->isValid()) {

                $formValues = $this->reportForm->getValues();

                $reportableService = new ReportableService();
                $selectedFilterFieldList = $reportableService->getSelectedFilterFields($reportId, true);
                $runtimeWhereClause = $reportGeneratorService->generateWhereClauseConditionArray($selectedFilterFieldList,$formValues);

                $staticColumns = null;
                if($this->hasStaticColumns()){
                    $staticColumns = $this->setStaticColumns($formValues);
                }
                $sql = $reportGeneratorService->generateSql($reportId, $runtimeWhereClause, $staticColumns);
                $this->setReportCriteriaInfoInRequest($formValues);
                $this->getRequest()->setParameter('sql', $sql);
                $this->getRequest()->setParameter('reportId', $reportId);
                $this->setForward();
            }
        }
    }

    abstract public function setReportCriteriaInfoInRequest($formValues);

    abstract public function setForward();

    abstract public function setStaticColumns($formValues);

    public function hasStaticColumns(){
        return false;
    }
}