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
function login() {
	document.frmInstall.actionResponse.value = 'LOGIN';
	document.frmInstall.submit();
}

function regInfo() {

	frm = document.frmInstall;
	var messages = '';
	if(frm.userName.value == '') {
		messages += "\n" + ' - Enter last name ';
	}
	if(frm.company.value == '') {
		messages += "\n" + ' - Enter company name';  
    }

	var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;

	if(frm.userEmail.value == '') {
		messages += "\n" + ' - Enter e-mail address';
	} else if (!reg.test(frm.userEmail.value)) {
		messages += "\n" + ' - Invalid e-mail address';
	}

	if (messages != '') {
        alert('Please correct the following error(s)' + messages);
        return;
    }

document.frmInstall.submit();
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

<style>
        ul.registration li { 
        	color:#dc8701; 
        	height: 11px;
        }
        ul.registration li span { 
            color:black;           
        }
        
        .registration {           
            	
        }
        .wrapper {
        	display: block;
        }
        
        .wrapper_content_div {
        	float: left;
            margin: 5px 30px 0px 0px; 
        }
		.clear {
			clear:both;
		}
}
</style>

<div style="display: block;" class="wrapper">
	<h2>Step 7: Registration</h2>
	 <p>You have successfully installed <strong>LASUHRM for </strong> <strong>Academic Staff Establishment </strong> .</p>
	<div class="wrapper" style="width: 900px;">
    



        <input name="button" type="button" onclick="login();" value="Login to LASUHRM" tabindex="10"/>
        <?php //echo "<input name='button' type='button' onclick='noREG();' value='Skip' tabindex='11'/>";?>
        <?php //echo "<input name="btnRegister" type="button" onclick="regInfo();" value="Retry" tabindex="1"/>;?>
 </div>    
</div>
<br class="clear"/>
