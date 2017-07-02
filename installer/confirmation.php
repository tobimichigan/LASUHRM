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
function confirm() {
	document.frmInstall.actionResponse.value  = 'CONFIRMED';
	document.frmInstall.submit();
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />


  <div id="content">
	<h2>Step 5: Confirmation</h2>

        <p>All information required for <strong>Academic Staff Establishment LASUHRM</strong> installation collected in the earlier steps are given below. On confirmation, the installer will create the database,
         database users, configuration file, etc.<br />
		 Click <b>[Install]</b> to continue.
		 </p>

         <p><font color="Red"><?php echo isset($error) ? $error : ''?></font></p>

        <table cellpadding="0" cellspacing="0" border="0" class="table">
		<tr>
			<th colspan="3" align="left" class="th">Details</th>
		</tr>
		<tr>
			<td class="tdComponent">Host Name</td>
			<td class="tdValues"><?php echo $_SESSION['dbInfo']['dbHostName']?></td>
		</tr>
		<tr>
			<td class="tdComponent">Database Host Port</td>
			<td class="tdValues"><?php echo $_SESSION['dbInfo']['dbHostPort']?></td>
		</tr>
		<tr>
			<td class="tdComponent">Database Name</td>
			<td class="tdValues"><?php echo $_SESSION['dbInfo']['dbName']?></td>
		</tr>
<?php if($_SESSION['dbCreateMethod'] == 'new') { ?>		
		<tr>
			<td class="tdComponent">Privileged Database User-name</td>
			<td class="tdValues"><?php echo $_SESSION['dbInfo']['dbUserName']?></td>
		</tr>
<?php } ?>
<?php if(isset($_SESSION['dbInfo']['dbOHRMUserName'])) { ?>
		<tr>
			<td class="tdComponent">LASUHRM Database User-name</td>
			<td class="tdValues"><?php echo $_SESSION['dbInfo']['dbOHRMUserName']?></td>
		</tr>
<?php } ?>
		<tr>
			<td class="tdComponent">LASUHRM Admin User Name</td>
			<td class="tdValues"><?php echo $_SESSION['defUser']['AdminUserName']?></td>
		</tr>
<?php if ($_SESSION['ENCRYPTION'] == "Active") {  ?>
		<tr>
			<td class="tdComponent">Data Encryption</td>
			<td class="tdValues">Data Encryption is on. Employee PF Number and Employee Basic Salary would be encrypted.
			<br>Please backup encryption key located at lib/confs/cryptokeys/</td>
		</tr>
<?php } elseif ($_SESSION['ENCRYPTION'] == "Failed") { ?>
		<tr>
			<td class="tdComponent">Data Encryption</td>
			<td class="tdValues">Data Encryption configuration failed. Data Encryption would not be enabled.</td>
		</tr>
<?php } ?>
</table>
		<br />
		<input class="button" type="button" value="Back" onclick="back();" tabindex="3"/>
		<input class="button" type="button" value="Cancel Install" onclick="cancel();" tabindex="2"/>
        <input class="button" type="button" value="Install" onclick="confirm();" tabindex="1"/>
  </div>
