<div class="fdx_postfooter">
</div>
<div class="fdx_clear"></div>
<?php
$options = get_option('fdx3_updater_options');
if ( $options['fdx_text_ads'] <> "" ) {
echo "<div align='center'> \n";
echo stripslashes($options['fdx_text_ads']) . "\n";
echo "</div> \n";
}
?>
<div class="fdx_switch">
<div class="fdx_switch_text"><?php _e('Mobile Version', 'wp-mobile-edition') ?> | <a href="<?php echo FDX_SITEURL.$_SERVER['REQUEST_URI'].'?switch=0'; ?>"><?php _e('Desktop Version', 'wp-mobile-edition') ?></a></div>
<div class="fdx_switch_checkbox"></div>
<div class="fdx_clear"></div>
</div>

<div class="fdx_footer"><div class="fdx_copyright"><a href="<?php echo FDX3_PLUGINPAGE; ?>"><img src="<?php echo get_template_directory_uri();?>/images/menu_fdx.png" width="16" height="16" border="0" alt="" /></a></div>
</div>
</div>



<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/total_script.js" charset="utf-8"></script> 
<?php
$options = get_option('fdx3_updater_options');
if ( $options['fdx_text_foot'] <> "" ) {
echo stripslashes($options['fdx_text_foot']) . "\n";
}
?>
</body>
</html>
