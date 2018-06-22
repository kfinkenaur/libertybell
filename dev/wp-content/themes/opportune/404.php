<?php
 /**
 * 404 page
 * @package Opportune
 */

 ?>
 
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
    <style>
	html, body {
    height: 100%;
}
.main {
    height: 100%;
    width: 100%;
    display: table;
}
.wrapper {
    display: table-cell;
    height: 100%;
    vertical-align: middle;
}
</style>
</head>

<body id="error-page">
       

<div class="main">
<div class="wrapper">

<div class="container">
  <div class="row">
    <div id="error-content" class="clearfix">
      <div class="col-md-6">
      <img class="error-image" src="<?php  echo esc_url(get_theme_mod('error_image', get_template_directory_uri() . '/images/error404.png') ) ; ?>" />
      </div>
      <div class="col-md-6 text-center">
      <p class="error404">
	  <?php echo esc_html(get_theme_mod( 'error_title', '404' )); ?></p>
      <p class="error-message"><?php echo esc_html(get_theme_mod( 'error_message', 'I know...you are upset the page you were going to is apparently missing.' )); ?></p>
<p><a class="error-button btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html(get_theme_mod( 'error_button', 'Back to Home' )); ?></a></p>
      </div>
    </div>
  </div>
</div>


</div></div>
</body>
</html>
