<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
?>
<?php 

use_javascripts_for_form($searchForm);
use_stylesheets_for_form($searchForm);
?>


<div id="holiday-information" class="box toggableForm">
    
    <div class="head">
        <h1 id="searchHolidayHeading"><?php echo __('Holidays'); ?></h1>
    </div>
    
    <div class="inner">
         
        <form id="frmHolidaySearch" name="frmHolidaySearch" method="post" action="<?php echo url_for('leave/viewHolidayList') ?>" > 
            

            <fieldset>
                
                <ol>
                    <?php echo $searchForm->render(); ?>
                </ol>
               
                <p>
                    <input type="button" name="btnSearch" id="btnSearch" value="<?php echo __("Search") ?>" class="savebutton" />
                </p>
                
            </fieldset>
            
        </form>
        
        
    </div>
    
    <a href="#" class="toggle tiptip" title="<?php echo __(CommonMessages::TOGGABLE_DEFAULT_MESSAGE); ?>">&gt;</a>
    
</div>

<div id="holidayList">
    <?php include_component('core', 'ohrmList'); ?>
</div>

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfModal">
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

<script type="text/javascript"> 
//<![CDATA[    
    var defineHolidayUrl = '<?php echo url_for('leave/defineHoliday'); ?>';
    var lang_SelectHolidayToDelete = '<?php echo __(TopLevelMessages::SELECT_RECORDS); ?>';      
//]]>    
</script>