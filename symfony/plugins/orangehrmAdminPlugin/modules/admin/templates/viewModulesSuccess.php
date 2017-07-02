<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>

<style type="text/css">
    form ol li.checkbox label {
        width:15%
    }
</style>

<div id="saveFormDiv" class="box">
    
    <div class="head">
        <h1 id="saveFormHeading"> <?php echo __('Module Configuration') ?> </h1>
    </div>
    
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>

        <form name="frmSave" id="frmSave" method="post" action="<?php echo url_for('admin/viewModules'); ?>">
            
            <?php echo $form['_csrf_token']; ?>
            
            <fieldset>
                
                <ol>
                    
                    <li class="checkbox">
                        <?php echo $form['admin']->renderLabel(__('Enable Admin module') . ' <em>*</em>'); ?>
                        <?php echo $form['admin']->render(); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['pim']->renderLabel(__('Enable PIM module') . ' <em>*</em>'); ?>
                        <?php echo $form['pim']->render(); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['leave']->renderLabel(__('Enable Leave module')); ?>
                        <?php echo $form['leave']->render(); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['time']->renderLabel(__('Enable Time module')); ?>
                        <?php echo $form['time']->render(); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['recruitment']->renderLabel(__('Enable Recruitment module')); ?>
                        <?php echo $form['recruitment']->render(); ?>
                    </li>
                    
                    <li class="checkbox">
                        <?php echo $form['performance']->renderLabel(__('Enable Performance module')); ?>
                        <?php echo $form['performance']->render(); ?>
                    </li>
                    
                    <li class="required">
                        <em>*</em> <?php echo __('compulsory'); ?>
                    </li>
                    
                </ol>
                
                <p>
                    <input type="button" class="" name="btnSave" id="btnSave" value="<?php echo __('Edit'); ?>"/>
                </p>
                
            </fieldset>
            
        </form>
    
    </div>
    
</div> <!-- saveFormDiv -->



<?php use_javascript(plugin_web_path('orangehrmAdminPlugin', 'js/viewModulesSuccess')); ?>

<script type="text/javascript">
//<![CDATA[	    
    
    var lang_edit = "<?php echo __('Edit'); ?>";
    var lang_save = "<?php echo __('Save'); ?>";
    
//]]>	
</script>