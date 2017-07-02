<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
?>
<?php echo javascript_include_tag(plugin_web_path('orangehrmTimePlugin', 'js/editTimesheet')); ?>
<table id="newRow">
    <tr class="<?php echo ($num & 1) ? 'even' : 'odd' ?>">
        <td id="">
            <?php echo $form['initialRows'][$num]['toDelete'] ?>
        </td>
        <td>
            <?php echo $form['initialRows'][$num]['projectName']->renderError() ?>
            <?php echo $form['initialRows'][$num]['projectName']->render(array("class" => "project", "size" => 25)); ?>
            <?php echo $form['initialRows'][$num]['projectId'] ?>
        </td>
        <td>
            <?php echo $form['initialRows'][$num]['projectActivityName']->renderError() ?>
            <?php echo $form['initialRows'][$num]['projectActivityName']->render(array("class" => "projectActivity")); ?>
            <?php echo $form['initialRows'][$num]['projectActivityId'] ?>
        </td>
        <?php for ($j = 0; $j < $noOfDays; $j++) { ?>
            <td class="center comments">
                <?php echo $form['initialRows'][$num][$j]->renderError() ?>
                <?php echo $form['initialRows'][$num][$j]->render(array("class" => "timeBox")) ?>
                <?php echo image_tag(theme_path('images/comment.png'), 'id=commentBtn_' . $j . '_' . $num . " class=commentIcon ") ?>
                <?php echo $form['initialRows'][$num]['TimesheetItemId' . $j] ?>
            </td>
        <?php } ?>
    </tr>
</table>
