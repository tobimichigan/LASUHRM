<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */


$license_file_name = ROOT_PATH . "/license/LICENSE.TXT";
$fh = fopen( $license_file_name, 'r' ) or die( "License file not found!" );
$license_file = fread( $fh, filesize( $license_file_name ) );
fclose( $fh );
?>
<script language="JavaScript">
function licenseAccept() {
	document.frmInstall.actionResponse.value  = 'LICENSEOK';
	document.frmInstall.submit();
}
</script>

	<div id="content">

  		<h2>Step 1: License Acceptance</h2>

		<p>Please read the license and click <b>[I Accept]</b> to continue. </p>
    	<textarea cols="80" rows="20" readonly tabindex="1"><?php echo $license_file?></textarea><br /><br />

    	<input class="button" type="button" value="Back" onclick="cancel();" tabindex="3">
		<input type="button" onClick='licenseAccept();' value="I Accept" tabindex="2">

	</div>