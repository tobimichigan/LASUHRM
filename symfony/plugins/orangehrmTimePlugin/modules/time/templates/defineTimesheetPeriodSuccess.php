<?php /*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */ 
?>
<?php echo javascript_include_tag(plugin_web_path('orangehrmTimePlugin', 'js/defineTimesheetPeriod')); ?>

<div class="box">
    
    <div class="head">
        <h1 id="defineTimesheet"><?php echo __('Define Timesheet Period'); ?></h1>
    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form id="definePeriod" method="post" action="<?php echo url_for('time/defineTimesheetPeriod')?>">
            <?php echo $form['_csrf_token']; ?>
            <fieldset>
                <ol>
                    <li>
                        <?php if ($isAllowed) { ?>
                            <?php echo $form['startingDays']->renderLabel(__('First Day of Week') . ' <em>*</em>'); ?>
                            <?php echo $form['startingDays']->render(array("maxlength" => 20)); ?>
                        <?php } else { ?>                        
                            <label><?php echo __("Timesheet period start day has not been defined. Please contact HR Admin"); ?></label>
                        <?php } ?>
                    </li>
                    <?php if($isAllowed){?>
                        <li class="required">
                            <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                        </li>
                    <?php } ?>
                </ol>
                <?php if ($isAllowed) { ?>
                <p>
                    <input type="button" class="" name="btnSave" id="btnSave" value="<?php echo __("Save"); ?>"/>
                </p>
                <?php } ?>
            </fieldset>
        </form> 
        
    </div>
    
</div>
    
<script type="text/javascript">
    var lang_required = '<?php echo __(ValidationMessages::REQUIRED);?>';
</script>