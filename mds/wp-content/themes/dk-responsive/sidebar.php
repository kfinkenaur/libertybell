<?php
/**
 * The sidebar containing the main widget area.
 *
 * 
 * Sidebar Template
 *
 *
 * @file           sidebar.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */


$layout= dk_get_current_layout();	
switch ( $layout ) {
	case 'content-sidebar':
		get_sidebar( 'right' );
		return;
		break;
	case 'sidebar-content':
		get_sidebar( 'left' );
		return;
		break;
	case 'full-width':
		return;
		break;
} 
?>
<div id="secondary" class="widget-area <?php echo implode( ' ', dk_sidebar_classes() ); ?>" role="complementary">
	<div class="widget-title">
		<h3><?php _e( 'In Archive', 'dk_responsive' ); ?></h3>
	</div>
	<ul>
		<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
	</ul>			
</div>
