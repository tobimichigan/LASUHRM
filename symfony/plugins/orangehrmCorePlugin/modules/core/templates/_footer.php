<?php
$imagePath = theme_path("images/login");
$version = '3.1';
$copyrightYear = date('Y');
?>

<style type="text/css">
    #divFooter {
        text-align: center;
    }
    
    #spanCopyright, #spanSocialMedia {
        padding: 20px 10px 10px 10px;
    }
    
    #spanSocialMedia a img {
		border: none;
    }

</style>
<div id="divFooter" >
    <span id="spanCopyright">
        <strong><a href="http://www.lasunigeria.edu.ng" target="_blank">LAGOS STATE UNIVERSITY HUMAN RESOURCE MANAGER</a></strong>
         <?php //echo ver $version; ?> &copy; 1983 - <?php echo $copyrightYear; ?> All rights reserved.
    </span>
    <span id="spanSocialMedia">
        <a href="http://www.linkedin.com/groups?home=&gid=891077" target="_blank">
            <img src="<?php //echo "{$imagePath}/linkedin.png"; ?>" /></a>&nbsp;
        <a href="http://www.facebook.com/OrangeHRM" target="_blank">
            <img src="<?php //echo "{$imagePath}/facebook.png"; ?>" /></a>&nbsp;
        <a href="http://twitter.com/orangehrm" target="_blank">
            <img src="<?php //echo "{$imagePath}/twiter.png"; ?>" /></a>&nbsp;
        <a href="http://www.youtube.com/results?search_query=orangehrm&search_type=" target="_blank">
            <img src="<?php //echo "{$imagePath}/youtube.png"; ?>" /></a>&nbsp;
    </span>
    <br class="clear" />
</div>
