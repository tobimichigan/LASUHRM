<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 */


/* For logging PHP errors */
include_once('../lib/confs/log_settings.php');

session_start();

$cupath = realpath(dirname(__FILE__).'/../');

define('ROOT_PATH', $cupath);


if(isset($_SESSION['CONFDONE'])) {
	$currScreen = 7;
} elseif(isset($_SESSION['INSTALLING'])) {
	$currScreen = 6;
} elseif(isset($_SESSION['DEFUSER'])) {
	$currScreen = 5;
} elseif(isset($_SESSION['SYSCHECK'])) {
	$currScreen = 4;
} elseif(isset($_SESSION['DBCONFIG'])) {
	$currScreen = 3;
} elseif(isset($_SESSION['LICENSE'])) {
	$currScreen = 2;
} elseif(isset($_SESSION['WELCOME'])) {
	$currScreen = 1;
} else $currScreen = 0;

if (isset($_SESSION['error'])) {
	$error = $_SESSION['error'];
}

if (isset($_SESSION['reqAccept'])) {
	$reqAccept = $_SESSION['reqAccept'];
}

$steps = array('welcome', 'license', 'database configuration', 'system check', 'admin user creation', 'confirmation', 'Installing', 'registration');

$helpLink = array("#welcome", "#license", "#DBCreation", "#systemChk", "#adminUsrCrt", "#confirm", "#installing", "#registration");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>LASUHRM Web Installation Wizard</title>
<link href="favicon.ico" rel="icon" type="image/gif"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript">

function goToScreen(screenNo) {
	document.frmInstall.txtScreen.value = screenNo;
}

function cancel() {
	document.frmInstall.actionResponse.value  = 'CANCEL';
	document.frmInstall.submit();
}

function back() {
	document.frmInstall.actionResponse.value  = 'BACK';
	document.frmInstall.submit();
}

</script>
<link href="./style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="body">
  <a href="http://www.lasu.edu.ng"><img src="../symfony/web/themes/default/images/logo.png" alt="OrangeHRM" name="logo"  width="600" height="150" border="0" id="logo" style="margin-left: 10px;margin-bottom: 15px;" title="LASU.HRM"></a>
<form name="frmInstall" action="../install.php" method="POST">
<input type="hidden" name="txtScreen" value="<?php echo $currScreen?>">
<input type="hidden" name="actionResponse">

<table border="0" cellpadding="0" cellspacing="0">
  <tr>
<?php
	$tocome = '';
	for ($i=0; $i < count($steps); $i++) {
		if ($currScreen == $i) {
			$tabState = 'Active';
		} else {
			$tabState = 'Inactive';
		}
?>

    <td nowrap="nowrap" class="left_<?php echo $tabState?>">&nbsp;</td>
    <td nowrap="nowrap" class="middle_<?php echo $tabState.$tocome?>"><?php echo $steps[$i]?></td>
	<td nowrap="nowrap" class="right_<?php echo $tabState?>">&nbsp;</td>

    <?php
		if ($tabState == 'Active') {
			$tocome = '_tocome';
		}
	}
	?>
  </tr>
</table>
<?php //echo ("<a href="./guide/ $helpLink[$currScreen]")?> <?php //echo ("id='help' target='_blank'>[Help ?]</a>")?>
<?php

switch ($currScreen) {

	default :
	case 0 	: 	require(ROOT_PATH . '/installer/welcome.php'); break;
	case 1 	: 	require(ROOT_PATH . '/installer/license.php'); break;
	case 2 	: 	require(ROOT_PATH . '/installer/dbConfig.php'); break;
	case 3 	: 	require(ROOT_PATH . '/installer/checkSystem.php'); break;
	case 4 	: 	require(ROOT_PATH . '/installer/defaultUser.php'); break;
	case 5 	: 	require(ROOT_PATH . '/installer/confirmation.php'); break;
	case 6 	: 	require(ROOT_PATH . '/installer/progress.php'); break;
	case 7 	: 	require(ROOT_PATH . '/installer/registration.php'); break;
}
?>

</form>
<div id="footer"><a href="http://www.lasu.edu.ng" target="_blank" tabindex="37">LASUHRM</a> Web Installation Wizard  &copy; LAGOS STATE UNIVERSITY 1983 - 2014. All rights reserved. </div>
</div>
</body>
</html>