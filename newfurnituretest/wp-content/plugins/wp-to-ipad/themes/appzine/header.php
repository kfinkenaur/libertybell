<?php global $wpti; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php bloginfo( 'template_url' ); ?>/css/portrait.css">
<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php bloginfo( 'template_url' ); ?>/css/landscape.css">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/cubiq-iscroll-2ddf602/src/iscroll.js?v3.7.1"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/dropdown.js"></script>
<script type="text/javascript">
	var urlSite = "<?php bloginfo( 'url' ); ?>";
	var templateUrl = "<?php bloginfo( 'template_url' ); ?>";
	var urlPageCategorie = "<?php echo admin_url('admin-ajax.php'); ?>";
	var postsPerPage = <?php echo $wpti->postsPerPage; ?>;
</script>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

</head>

<body <?php body_class(); ?>>

<div id="wrapper" class="hfeed">
	<div id="header">
		<div style="position:relative">
			<a href="" id="logo"><?php bloginfo('name') ?></a>
			<a href="" id="home"></a>
			<a href="" id="info" popup="popup_info"></a>
			<a href="" id="fontSize" popup="popup_size"></a>
		</div>
		
	</div><!-- #header -->
	<div class="clear"></div>