<?php /*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */ ?>

<?php echo javascript_include_tag(plugin_web_path('orangehrmTimePlugin', 'js/createTimesheetForSubourdinateSuccess')); ?>

<div class="box noHeader">
    <div class="inner">
        <?php include_partial('global/flash_messages'); ?>
        <div id="validationMsg">
            <?php echo isset($messageData[0]) ? displayMainMessage($messageData[0], $messageData[1]) : ''; ?>
        </div>
        <form  id="createTimesheetForm" action=""  method="post">
            <?php echo $createTimesheetForm['_csrf_token']; ?>
            <fieldset>
                <ol id="createTimesheet">
                    <li>
                        <?php echo $createTimesheetForm['date']->renderLabel(__('Select a Day to Create Timesheet'), array('class' => 'line')); ?>
                        <?php echo $createTimesheetForm['date']->render(); ?>
                        <?php echo $createTimesheetForm['date']->renderError() ?>
                    </li>
                </ol>
                <?php if (in_array(WorkflowStateMachine::TIMESHEET_ACTION_CREATE, $sf_data->getRaw('allowedToCreateTimesheets'))): ?>
                    <p>
                        <input type="button" class="" name="button" id="btnAddTimesheet" value="<?php echo __('Add Timesheet') ?>" />
                    </p>
                <?php endif; ?>
            </fieldset>
        </form>
    </div>
</div>

<script type="text/javascript">
    var datepickerDateFormat = '<?php echo get_datepicker_date_format($sf_user->getDateFormat()); ?>';
    var displayDateFormat = '<?php echo str_replace('yy', 'yyyy', get_datepicker_date_format($sf_user->getDateFormat())); ?>';
    var employeeId = "<?php echo $employeeId; ?>";
    var linkForViewTimesheet="<?php echo url_for('time/viewTimesheet') ?>";
    var validateStartDate="<?php echo url_for('time/validateStartDate'); ?>";
    var createTimesheet="<?php echo url_for('time/createTimesheet'); ?>";
    var returnEndDate="<?php echo url_for('time/returnEndDate'); ?>";
    var currentDate= "<?php echo $currentDate; ?>";
    var lang_noFutureTimesheets= "<?php echo __("Failed to Create: Future Timesheets Not Allowed"); ?>";
    var lang_overlappingTimesheets= "<?php echo __("Timesheet Overlaps with Existing Timesheets"); ?>";
    var lang_timesheetExists= "<?php echo __("Timesheet Already Exists"); ?>";
    var lang_invalidDate= '<?php echo __(ValidationMessages::DATE_FORMAT_INVALID, array('%format%' => str_replace('yy', 'yyyy', get_datepicker_date_format($sf_user->getDateFormat())))) ?>';
</script>