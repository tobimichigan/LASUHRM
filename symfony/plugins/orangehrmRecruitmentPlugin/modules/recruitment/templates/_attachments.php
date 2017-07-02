<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>

<?php
use_javascript(plugin_web_path('orangehrmRecruitmentPlugin', 'js/attachmentsPartial'));
?>

<?php
$hasAttachments = count($attachmentList) > 0;
?>

<a name="attachments"></a>

<div id="addPaneAttachments">
    <div class="head" id="saveHeading">
        <h1><?php echo __('Add Attachment'); ?></h1>
    </div> <!-- head -->
    <div class="inner">
        <form name="frmRecAttachment" id="frmRecAttachment" method="post" enctype="multipart/form-data" action="<?php echo url_for('recruitment/updateAttachment?screen=' . $screen); ?>">
            <?php echo $form['_csrf_token']; ?>
            <?php echo $form["vacancyId"]->render(); ?>
            <?php echo $form["commentOnly"]->render(); ?>
            <?php echo $form["recruitmentId"]->render(); ?>

            <fieldset>
                <ol>
                    <li id="currentFileLi">
                        <label><?php echo __("Current File")?></label>
                        <span id="currentFileSpan"></span>
                    </li>                     
                    <li class="fieldHelpContainer">
                        <label id="selectFileSpan"><?php echo __("Select File") ?> <em>*</em></label>
                        <?php echo $form['ufile']->render(array("class" => "atachment")); ?>
                        <label class="fieldHelpBottom"><?php echo __(CommonMessages::FILE_LABEL_SIZE); ?></label>
                    </li>
                    <li class="largeTextBox">
                        <?php echo $form['comment']->renderLabel(__('Comment')); ?>
                        <?php echo $form['comment']->render(array("class" => "comment", "cols" => 36, "rows" => 3)); ?>
                    </li>
                    <li class="required"><em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?></li>
                </ol>
                <p>
                    <input type="button" name="btnSaveAttachment" id="btnSaveAttachment" value="<?php echo __("Upload"); ?>" />
                    <input type="button" id="btnCommentOnly" value="<?php echo __("Save Comment Only"); ?>" />
                    <input type="button" class="cancel" id="cancelButton" value="<?php echo __("Cancel"); ?>" />
                </p>
            </fieldset>
        </form>
    </div> <!-- inner -->
</div> <!-- addPaneAttachments -->

<div id="attachmentList" class="miniList">
    <div class="head">
        <h1><?php echo __('Attachments'); ?></h1>
    </div>
    <div class="inner">
        <?php include_partial('global/flash_messages', array('prefix' => 'jobAttachmentPane')); ?>
        <form name="frmRecDelAttachments" id="frmRecDelAttachments" method="post" action="<?php echo url_for('recruitment/deleteAttachments?screen=' . $screen); ?>">
            <?php echo $deleteForm['_csrf_token']; ?>
            <p id="attachmentActions">
                <input type="button" class="addbutton" id="btnAddAttachment" value="<?php echo __("Add"); ?>" />
                <?php if ($hasAttachments) : ?>
                    <input type="button" class="delete" id="btnDeleteAttachment" value="<?php echo __("Delete"); ?>"/>
                <?php endif; // $hasAttachments ?>
            </p>
            <?php if ($hasAttachments) : ?>
                <table id="tblAttachments" cellpadding="0" cellspacing="0" width="100%" class="table tablesorter">
                    <thead>
                        <tr>
                            <th width="2%"><input type="checkbox" id="attachmentsCheckAll" class="checkboxAtch"/></th>
                            <th><?php echo __("File Name") ?></th>                   
                            <th><?php echo __("Size") ?></th>
                            <th><?php echo __("Type") ?></th>
                            <th><?php echo __("Comment") ?></th>
                            <th></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$disabled = ($locRights['delete']) ? "" : 'disabled="disabled"';
                        $row = 0;
                        foreach ($attachmentList as $attachment) {
                            $cssClass = ($row % 2) ? 'even' : 'odd';
                            ?>
                            <tr class="<?php echo $cssClass; ?>">
                                <td class="check"><input type='checkbox' class='checkboxAtch' name='delAttachments[]'
                                                         value="<?php echo $attachment->id; ?>"/></td>
                                <td><a title="<?php echo $attachment->fileName; ?>" target="_blank" class="fileLink"
                                       href="<?php echo url_for('recruitment/viewAttachment?attachId=' . $attachment->id . '&screen=' . $screen); ?>"><?php echo $attachment->fileName; ?></a></td>
                                <td><?php echo add_si_unit($attachment->fileSize); ?></td>
                                <td><?php echo $attachment->fileType; ?></td>
                                <td class="comments">
                                    <?php echo $attachment->comment; ?>
                                </td>
                                <td><a href="#" class="editLink"><?php echo __("Edit"); ?></a></td>
                            </tr>
                            <?php
                            $row++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; // $hasAttachments ?>
        </form> 
    </div>
</div> <!-- attachmentList -->   

<script type="text/javascript">
    //<![CDATA[
    
    var hideAttachmentListOnAdd = <?php echo $hasAttachments ? 'false' : 'true'; ?>;
    var lang_SelectAtLeastOneAttachment = "<?php echo __(TopLevelMessages::SELECT_RECORDS); ?>";
    var id = '<?php echo $id; ?>';
    var clearAttachmentMessages = true;
    var lang_SelectFile = "<?php echo __("Select File"); ?>";
    var lang_ReplaceWith = "<?php echo __("Replace With"); ?>";
    var lang_EditAttachmentHeading = "<?php echo __("Edit Attachment"); ?>";
    var lang_AddAttachmentHeading = "<?php echo __("Add Attachment"); ?>";
    var lang_PleaseSelectAFile = "<?php echo __(ValidationMessages::REQUIRED); ?>";
    var lang_CommentsMaxLength = "<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 250)); ?>";
    var lang_SelectAtLeastOneAttachment = "<?php echo __(TopLevelMessages::SELECT_RECORDS); ?>";

    // Scroll to bottom if neccessary. Works around issue in IE8 where
    // using the <a name="attachments" is not sufficient

<?php if ($scrollToAttachments) { ?>
        window.scrollTo(0, $(document).height());
<?php } ?>
    //]]>
</script>