<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>

<?php echo javascript_include_tag(plugin_web_path('orangehrmAdminPlugin', 'js/viewOrganizationGeneralInformationSuccess')); ?>

<div id="general-info" class="box twoColumn">
        
    <div class="head">
        <h1 id="genInfoHeading"><?php echo __('General Information'); ?></h1>
    </div>

    <div class="inner">
        
        <?php include_partial('global/flash_messages', array('prefix' => 'generalinformation')); ?>
        
        <form name="frmGenInfo" id="frmGenInfo" method="post" action="<?php echo url_for('admin/viewOrganizationGeneralInformation'); ?>" class="clickToEditForm">

            <?php echo $form['_csrf_token']; ?>
            
            <fieldset>
                
                <ol>
                    
                    <li>
                        <?php echo $form['name']->renderLabel(__('Organization Name') . ' <em>*</em>'); ?>
                        <?php echo $form['name']->render(array("maxlength" => 100)); ?>
                    </li>
                    
                    <li>
                        <?php echo $form['taxId']->renderLabel(__('Tax ID')); ?>
                        <?php echo $form['taxId']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                    <li>
                        <label><?php echo __("Number of Employees") ?></label>
                        <span id="numOfEmployees"><?php echo $employeeCount; ?></span>
                    </li>
                    
                    <li>
                        <?php echo $form['registraionNumber']->renderLabel(__('Registration Number')); ?>
                        <?php echo $form['registraionNumber']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                </ol>
                
                <ol>
                    
                    <li>
                        <?php echo $form['phone']->renderLabel(__('Phone')); ?>
                        <?php echo $form['phone']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                    <li>
                        <?php echo $form['fax']->renderLabel(__('Fax')); ?>
                        <?php echo $form['fax']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                    <li>
                        <?php echo $form['email']->renderLabel(__('Email')); ?>
                        <?php echo $form['email']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                </ol>
                
                <ol>
                    
                    <li>
                        <?php echo $form['street1']->renderLabel(__('Address Street 1')); ?>
                        <?php echo $form['street1']->render(array("maxlength" => 100)); ?>
                    </li>

                    <li>
                        <?php echo $form['street2']->renderLabel(__('Address Street 2')); ?>
                        <?php echo $form['street2']->render(array("maxlength" => 100)); ?>
                    </li>                    

                    <li>
                        <?php echo $form['city']->renderLabel(__('City')); ?>
                        <?php echo $form['city']->render(array("maxlength" => 30)); ?>
                    </li>                    
                    
                    <li>
                        <?php echo $form['province']->renderLabel(__('State/Province')); ?>
                        <?php echo $form['province']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                    <li>
                        <?php echo $form['zipCode']->renderLabel(__('Zip/Postal Code')); ?>
                        <?php echo $form['zipCode']->render(array("maxlength" => 30)); ?>
                    </li>
                    
                    <li>
                        <?php echo $form['country']->renderLabel(__('Country')); ?>
                        <?php echo $form['country']->render(array("class" => "drpDown", "maxlength" => 30)); ?>
                    </li>
                    
                    <li class="largeTextBox">
                        <?php echo $form['note']->renderLabel(__('Note')); ?>
                        <?php echo $form['note']->render(array("class" => "txtArea", "maxlength" => 255)); ?>
                    </li>
                    
                    <li class="required line">
                          <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                    
                </ol>
                
                <p>
                    <input type="button" class="addbutton editButton" name="btnSaveGenInfo" id="btnSaveGenInfo" value="<?php echo __("Edit"); ?>"/>
                </p>
                
            </fieldset>
            
        </form>
        
    </div>
    
</div>

<script type="text/javascript">

    //<![CDATA[
    var edit = "<?php echo __("Edit"); ?>";
    var save = "<?php echo __("Save"); ?>";
    var nameRequired = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var invalidPhoneNumber = '<?php echo __(ValidationMessages::TP_NUMBER_INVALID); ?>';
    var invalidFaxNumber = '<?php echo __(ValidationMessages::TP_NUMBER_INVALID); ?>';
    var incorrectEmail = '<?php echo __(ValidationMessages::EMAIL_INVALID); ?>';
    var lang_exceed255Chars = '<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 250)); ?>';
    //]]>
</script>