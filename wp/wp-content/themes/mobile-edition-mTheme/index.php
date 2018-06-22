<?php get_header(); ?>
<div class="fdx_topheading"><?php  if (is_home()){ ?>Home <?php } else {  fdx_body_result_text();  } ?> </div>
<?php
$options = get_option('fdx3_updater_options');
if ( $options['fdx_index_home'] == "menu" ) {
include('inc-menu.php');
get_footer('2');
} else {
include('inc-blog.php');
get_footer();
}
?>
