<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
?>
<?php use_javascripts_for_form($form); ?>
<?php use_stylesheets_for_form($form); ?>

<div id="location" class="box single">

    <div class="head">
        <h1 id="locationHeading"><?php echo ($editMode) ? __('Edit') . " " . __('Holiday') : __('Add') . " " . __('Holiday'); ?></h1>
    </div>

    <div class="inner">

        <?php include_partial('global/flash_messages'); ?>
        <form id="frmHoliday" name="frmHoliday" method="post" action="<?php echo url_for('leave/defineHoliday') ?>">

            <fieldset>

                <ol>
                    <?php echo $form->render(); ?>
                    <input type="hidden" name="hdnEditMode" id="hdnEditMode" value="<?php echo ($editMode) ? 'yes' : 'no'; ?>" />
                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>

                <p>

                <div class="formbuttons">            
                    <input type="button" class="savebutton" id="saveBtn" value="<?php echo __('Save'); ?>" />
                    <input type="button" class="reset" name="btnCancel" id="btnCancel" value="<?php echo __("Cancel"); ?>"/>               
                </div>

                </p>

            </fieldset>

        </form>
    </div>
</div>

<script type="text/javascript">
    //<![CDATA[
    
    var datepickerDateFormat = '<?php echo get_datepicker_date_format($sf_user->getDateFormat()); ?>';
    var backUrl = '<?php echo url_for('leave/viewHolidayList'); ?>';

    var lang_Required = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var lang_DateFormatIsWrong = '<?php echo __(ValidationMessages::DATE_FORMAT_INVALID, array('%format%' => str_replace('yy', 'yyyy', get_datepicker_date_format($sf_user->getDateFormat())))) ?>';
    var lang_NameIsOverLimit = "<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 200)); ?>";        

    //]]>
</script>
