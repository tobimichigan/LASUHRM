<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title><?php echo __('Active Job Vacancies');?></title>
    <link><?php echo public_path('index.php/recruitmentApply/jobs.rss'); ?></link>
    <description></description>
    <pubDate><?php echo date('D, d M Y H:i:s T');?></pubDate>
    <language>en</language>
<?php foreach ($publishedVacancies as $vacancy): ?>    
    <item>
      <title><![CDATA[<?php echo $vacancy->name;?>]]></title>
      <link><?php echo public_path('index.php/recruitmentApply/applyVacancy/id/'.$vacancy->getId(), true); ?></link>
      <description><![CDATA[<pre><?php echo wordwrap($vacancy->description, 110); ?></pre>]]>
      </description>
    </item>
<?php endforeach; ?>    
  </channel>
</rss>
