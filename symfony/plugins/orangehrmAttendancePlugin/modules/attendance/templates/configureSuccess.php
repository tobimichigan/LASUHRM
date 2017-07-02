<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
?>

<style type="text/css">
    form ol li.checkbox label {
        width:35%
    }
</style>
    

<div class="box">
         
    <div class="head">
        <h1><?php echo __('Attendance Configuration'); ?></h1>
    </div>
        
    <div class="inner">
        
        <?php include_partial('global/flash_messages'); ?>
            
        <form  id="configureForm" action=""  method="post">
            <?php echo $form['_csrf_token']; ?>
            <fieldset>
                <ol>
                   <li class="checkbox">
                        <?php echo $form['configuration1']->renderLabel(__('Employee can change current time when punching in/out')); ?>
                        <?php echo $form['configuration1']->render(); ?>
                        </li>
                        
                                            
                    <li class="checkbox">
                        <?php echo $form['configuration2']->renderLabel(__('Employee can edit/delete own attendance records')); ?>
                        <?php echo $form['configuration2']->render(); ?>
                        </li>
                        
                    <li class="checkbox">
                         <?php echo $form['configuration3']->renderLabel(__('Supervisor can add/edit/delete attendance records of subordinates')); ?>
                         <?php echo $form['configuration3']->render(); ?>
                         </li>
                                                                 
                </ol>
                <p>
                    <input type="submit" class="" id="btnSave" value="<?php echo __('Save'); ?>" />
                </p>
                    
            </fieldset>
                
        </form>
            
    </div>
        
</div>