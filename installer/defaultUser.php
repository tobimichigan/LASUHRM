<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>
<script language="JavaScript">

function submitDefUserInfo() {

	frm = document.frmInstall;
	if(frm.OHRMAdminUserName.value.length < 5) {
		alert('LASU.HRM Admin User-name should be at least 5 char. long!');
		frm.OHRMAdminUserName.focus();
		return;
	}

	if(frm.OHRMAdminPassword.value == '') {
		alert('LASU.HRM Admin Password left Empty!');
		frm.OHRMAdminPassword.focus();
		return;
	}

	if(frm.OHRMAdminPassword.value != frm.OHRMAdminPasswordConfirm.value) {
		alert('LASU.HRM Admin Password and Confirm OrangeHRM Admin Password don\'t match!');
		frm.OHRMAdminPassword.focus();
		return;
	}

document.frmInstall.actionResponse.value  = 'DEFUSERINFO';
document.frmInstall.submit();
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />


<div id="content">
	<h2>Step 4: Admin User Creation</h2>

        <p>After <strong>Academic Staff Establishment LASUHRM</strong> is configured you will need an Administrator Account to Login into LASUHRM Academic Staff Establishment. <br />
        Please fill in the Username and User Password for the Administrator login. </p>

        <table cellpadding="0" cellspacing="0" border="0" class="table">
<tr><th colspan="3" align="left">Admin User Creation</th></tr>
<tr>
	<td class="tdComponent_n"><strong>Academic Staff Establishment LASUHRM</strong> Admin Username</td>
	<td class="tdValues_n"><input type="text" name="OHRMAdminUserName" value="Admin" tabindex="1"/></td>
</tr>
<tr>
	<td class="tdComponent_n"><strong>Academic Staff Establishment LASUHRM</strong> Admin User Password</td>
	<td class="tdValues_n"><input type="password" name="OHRMAdminPassword" value="" tabindex="2"/></td>
</tr>
<tr>
	<td class="tdComponent_n">Confirm <strong>Academic Staff Establishment LASUHRM</strong> Admin User Password</td>
	<td class="tdValues_n"><input type="password" name="OHRMAdminPasswordConfirm" value="" tabindex="3"/></td>
</tr>

</table><br />
<input class="button" type="button" value="Back" onclick="back();" tabindex="5"/>
<input type="button" value="Next" onclick="submitDefUserInfo()" tabindex="4"/>
</div>