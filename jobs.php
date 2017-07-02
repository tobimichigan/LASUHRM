<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

define('ROOT_PATH', dirname(__FILE__));

$url = 'symfony/web/index.php/recruitmentApply/jobs.html';
?>
<html>
<head>
<title>Job Vacancies</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<iframe align="center" src="<?php echo $url; ?>" id="rightMenu" name="rightMenu" width="100%" height="100%" frameborder="0"></iframe>
</body>
</html>
