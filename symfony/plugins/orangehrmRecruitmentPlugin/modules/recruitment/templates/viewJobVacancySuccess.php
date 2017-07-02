<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>

<div class="box searchForm toggableForm" id="srchVacancy">
    
    <div class="head">
        <h1><?php echo __('Vacancies'); ?></h1>
    </div>
    
    <div class="inner">

        <form name="frmSrchJobVacancy" id="frmSrchJobVacancy" method="post" action="<?php echo url_for('recruitment/viewJobVacancy'); ?>">
            <fieldset>
                <?php echo $form['_csrf_token']; ?>
                <ol>
                    <li>
                        <?php echo $form['jobTitle']->renderLabel(__('Job Title'), array("class" => "jobTitleLabel")); ?>
                        <?php echo $form['jobTitle']->render(array("class" => "drpDown", "maxlength" => 50)); ?>
                    </li>
                    <li>
                        <?php echo $form['jobVacancy']->renderLabel(__('Vacancy'), array("class" => "vacancyLabel")); ?>
                        <?php echo $form['jobVacancy']->render(array("class" => "drpDown", "maxlength" => 50)); ?>
                    </li>
                    <li>
                        <?php echo $form['hiringManager']->renderLabel(__('Hiring Manager'), array("class" => "hiringManagerLabel")); ?>
                        <?php echo $form['hiringManager']->render(array("class" => "drpDown", "maxlength" => 50)); ?>
                    </li>
                    <li>
                        <?php echo $form['status']->renderLabel(__('Status'), array("class" => "statusLabel")); ?>
                        <?php echo $form['status']->render(array("class" => "drpDown", "maxlength" => 50)); ?>
                    </li>
                </ol>

                <p>
                    <input type="button" id="btnSrch" value="<?php echo __("Search") ?>" name="btnSrch" />
                    <input type="button" class="reset" id="btnRst" value="<?php echo __("Reset") ?>" name="btnSrch" />                    
                </p>
            </fieldset>            
        </form>
    </div>
    <a href="#" class="toggle tiptip" title="<?php echo __(CommonMessages::TOGGABLE_DEFAULT_MESSAGE); ?>">&gt;</a>
</div>

<?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfirmation">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('LASU.HRM - Confirmation Required'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __(CommonMessages::DELETE_CONFIRMATION); ?></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
        <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>
<!-- Confirmation box HTML: Ends -->

<form name="frmHiddenParam" id="frmHiddenParam" method="post" action="<?php echo url_for('recruitment/viewJobVacancy'); ?>">
    <input type="hidden" name="pageNo" id="pageNo" value="<?php //echo $form->pageNo;         ?>" />
    <input type="hidden" name="hdnAction" id="hdnAction" value="search" />
</form>

<script type="text/javascript">

    function submitPage(pageNo) {

        document.frmHiddenParam.pageNo.value = pageNo;
        document.frmHiddenParam.hdnAction.value = 'paging';
        document.getElementById('frmHiddenParam').submit();

    }
    //<![CDATA[
    var addJobVacancyUrl = '<?php echo url_for('recruitment/addJobVacancy'); ?>';
    var vacancyListUrl = '<?php echo url_for('recruitment/getVacancyListForJobTitleJson?jobTitle='); ?>';
    var hiringManagerListUrlForJobTitle = '<?php echo url_for('recruitment/getHiringManagerListJson?jobTitle='); ?>';
    var hiringManagerListUrlForVacancyId = '<?php echo url_for('recruitment/getHiringManagerListJson?vacancyId='); ?>';
    var lang_all = '<?php echo __("All") ?>';
    //]]>
</script>