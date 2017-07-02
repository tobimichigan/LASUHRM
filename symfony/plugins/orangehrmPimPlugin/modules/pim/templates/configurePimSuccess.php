<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
?>

<div class="box">
    
    <div class="head">
        <h1><?php echo __('Configure PIM'); ?></h1>
    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
        
        <form id="frmConfigPim" name="frmConfigPim" method="post" action="<?php echo url_for('pim/configurePim') ?>" >
            <?php echo $form['_csrf_token']; ?>
            <fieldset>
                
                
                
                <ol>
                    
                    <li>
                        <h2><?php echo __('Show Deprecated Fields'); ?></h2>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['chkDeprecateFields']->render(); ?>
                        <?php echo $form['chkDeprecateFields']->renderLabel(__('Show Nick Name, Smoker and Military Service in Personal Details')); ?>
                    </li>
                    
                <ol>
                    
                    <li>
                        <h2><?php echo __('Country Specific Information'); ?></h2>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['chkShowSSN']->render(); ?>
                        <?php echo $form['chkShowSSN']->renderLabel(__('Show National ID field in Personal Details')); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['chkShowSIN']->render(); ?>
                        <?php echo $form['chkShowSIN']->renderLabel(__('Show PIN field in Personal Details')); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['chkShowTax']->render(); ?>
                        <?php echo $form['chkShowTax']->renderLabel(__('Show Nigerian Tax Exemptions menu')); ?>
                    </li>
                    
                </ol>
                
                <p>
                    <input type="button" class="" id="btnSave" value="<?php echo __("Edit"); ?>" tabindex="2" />
                </p>
                
            </fieldset>

        </form>
    
    </div>

</div>

<script type="text/javascript">
//<![CDATA[
//we write javascript related stuff here, but if the logic gets lengthy should use a seperate js file
$(document).ready(function() {
    $("#configPim_chkDeprecateFields").attr('disabled', 'disabled');
    $("#configPim_chkShowSSN").attr('disabled', 'disabled');
    $("#configPim_chkShowSIN").attr('disabled', 'disabled');
    $("#configPim_chkShowTax").attr('disabled', 'disabled');
    
    $("#btnSave").click(function() {
        if($("#btnSave").attr('value') == "<?php echo __("Edit"); ?>") {
            $("#btnSave").attr('value', "<?php echo __("Save"); ?>");
            $("#configPim_chkDeprecateFields").removeAttr('disabled');
            $("#configPim_chkShowSSN").removeAttr('disabled');
            $("#configPim_chkShowSIN").removeAttr('disabled');
            $("#configPim_chkShowTax").removeAttr('disabled');
            
            return;
        }

        if($("#btnSave").attr('value') == "<?php echo __("Save"); ?>") {
            $("#frmConfigPim").submit();
        }
    });
});
//]]>
</script>