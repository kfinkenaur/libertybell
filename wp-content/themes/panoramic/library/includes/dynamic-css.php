
<style type="text/css">
/* Branding */
.site-header .branding {
	padding: <?php echo $site_branding_padding_top; ?>px 0 <?php echo $site_branding_padding_bottom; ?>px 0;
}

/*
.panoramic-slider-container.default.smart .slider .slide .overlay h1,
.panoramic-slider-container.default.smart .slider .slide .overlay h2 {
	line-height: <?php echo floatVal( get_theme_mod( 'panoramic-slider-heading-line-height', customizer_library_get_default( 'panoramic-slider-heading-line-height' ) ) ); ?>em;	
}

.panoramic-slider-container.default.smart .slider .slide .overlay .opacity p {
	line-height: <?php echo floatVal( get_theme_mod( 'panoramic-slider-paragraph-line-height', customizer_library_get_default( 'panoramic-slider-paragraph-line-height' ) ) ); ?>em;	
}

.panoramic-slider-container.default.smart .slider .slide .overlay .opacity p {
	margin-top: <?php echo floatVal( get_theme_mod( 'panoramic-slider-paragraph-margin', customizer_library_get_default( 'panoramic-slider-paragraph-margin' ) ) ); ?>em;
	margin-bottom: <?php echo floatVal( get_theme_mod( 'panoramic-slider-paragraph-margin', customizer_library_get_default( 'panoramic-slider-paragraph-margin' ) ) ); ?>em;
}

.panoramic-slider-container.default.smart .slider .slide .overlay .opacity a.button,
.panoramic-slider-container.default.smart .slider .slide .overlay .opacity button {
	margin-top: <?php echo floatVal( get_theme_mod( 'panoramic-slider-button-margin', customizer_library_get_default( 'panoramic-slider-button-margin' ) ) ); ?>em;
	margin-bottom: <?php echo floatVal( get_theme_mod( 'panoramic-slider-button-margin', customizer_library_get_default( 'panoramic-slider-button-margin' ) ) ); ?>em;
}
*/

<?php
if ( $panoramic_slider_has_min_width ) {
?>

/* Minimum slider width */
.panoramic-slider-container.default .slider .slide img {
	min-width: <?php echo $panoramic_slider_min_width; ?>px;
}
	
<?php
}
?>

<?php
if ( $panoramic_header_image_has_min_width ) {
?>

/* Minimum slider width */
.header-image img {
	min-width: <?php echo $panoramic_header_image_min_width; ?>px;
}

<?php
}
?>

/* Full width logo */
<?php
$opener = '';
$middle = '';
$closer = '';

if ( get_theme_mod( 'panoramic-mobile-logo' ) && get_theme_mod( 'panoramic-full-width-mobile-logo', customizer_library_get_default( 'panoramic-full-width-mobile-logo' ) ) && ( ( !has_custom_logo() && !get_theme_mod( 'panoramic-logo' ) ) || !get_theme_mod( 'panoramic-full-width-logo', customizer_library_get_default( 'panoramic-full-width-logo' ) ) ) ) {
	$opener = '@media only screen ';
	$middle = 'and (max-width: ' .$mobile_logo_breakpoint. 'px) ';
}

if ( get_theme_mod( 'panoramic-mobile-logo' ) && !get_theme_mod( 'panoramic-full-width-mobile-logo', customizer_library_get_default( 'panoramic-full-width-mobile-logo' ) ) ) {
	if ( $opener == '' ) {
		$opener = '@media only screen ';
	}
	$middle = 'and (min-width: ' .$mobile_logo_breakpoint. 'px) ';
}

if ( $opener != '' ) {
	echo $opener . $middle . $closer . ' {'; 	
}
?>
	.site-header.full-width-logo .site-container,
	.site-header.full-width-mobile-logo .site-container {
		padding: 0;
		max-width: 100%;
	}
	.site-header.full-width-logo .site-top-bar .site-container,
	.site-header.full-width-mobile-logo .site-top-bar .site-container {
		padding: 0 22px;
		max-width: 1140px;
	}
	.site-header.full-width-logo .branding,
	.site-header.full-width-mobile-logo .branding {
		padding: 0;
		width: 100%;
	}
	.site-header.full-width-logo .branding .title_and_tagline,
	.site-header.full-width-mobile-logo .branding .title_and_tagline {
		display: none !important;
	}
	.site-header.full-width-logo .site-header-right,
	.site-header.full-width-mobile-logo .site-header-right {
		display: none !important;
	}
<?php
if ( $opener != '' ) {
	echo '}'; 	
}

if ( get_theme_mod( 'panoramic-mobile-logo' ) ) {
	echo '/* Mobile logo */';
	echo '@media only screen and (max-width: ' .$mobile_logo_breakpoint. 'px) {';
?>
		.site-header.full-width-mobile-logo .branding a.mobile-logo-link {
			float: none;
			display: block;
		}
		.site-header.full-width-mobile-logo .branding img.mobile-logo {
			width: 100%;
			margin: 0;
		}

		/* Display the mobile logo */
		.site-header .branding a.mobile-logo-link,
		.panoramic-header-layout-centered .branding a.mobile-logo-link {
			display: inline-block;
		}
		
		.site-header .branding img.mobile-logo {
			margin: 0 auto 0 auto !important;
		}
		
		/* Hide the desktop logo */
		.site-header.full-width-logo .branding a.custom-logo-link,
		.site-header .branding .custom-logo-link.hide-for-mobile {
			display: none;
		}
		
		/* Hide the title and description */
		.site-header .branding .title.hide-for-mobile,
		.site-header .branding .description.hide-for-mobile {
			display: none;
		}
		
		.site-header .branding.mobile-logo-with-site-title img.mobile-logo {
			margin: 0 auto 10px auto !important;
		}
	
		.site-header .branding.has-mobile-logo .title_and_tagline {
			display: block;
		}
		
		.site-header .branding.has-mobile-logo .title_and_tagline.hide-for-mobile {
			display: none;
		}
	}
<?php
}
?>

/* Solidify the navigation menu */
<?php
echo '@media only screen and (max-width: ' .$solid_nav_menu_breakpoint. 'px) {';
?>
	.main-navigation.translucent {
		position: relative;
		background-color: #006489 !important;
	}
	
	.header-image .overlay-container,
	.panoramic-slider-container.default .slider .slide .overlay-container {
		padding-top: 0 !important;
	}
	.panoramic-slider-container.default .controls-container {
		margin-top: 0 !important;
	}
}

<?php
// Only include the mobile menu styling if the mobile menu is enabled
if ( get_theme_mod( 'panoramic-mobile-menu', customizer_library_get_default( 'panoramic-mobile-menu' ) ) ) {
	echo '/* Mobile Menu and other mobile stylings */';
	echo '@media only screen and (max-width: ' .$mobile_menu_breakpoint. 'px) {';
?>

    #main-menu.panoramic-mobile-menu-dark-color-scheme,
	#main-menu.panoramic-mobile-menu-dark-color-scheme ul ul {
    	background-color: #272727;
	}
    
	#main-menu.panoramic-mobile-menu-standard-color-scheme {
		background-color: #006489;
	}

	/* Menu toggle button */
    .header-menu-button {
	    display: block;
		padding: 16px 18px 11px 18px;
	    color: #FFF;
	    text-transform: uppercase;
    	text-align: center;
	    cursor: pointer;
	}
	.header-menu-button .fa.fa-bars {
    	font-size: 28px;
	}
	
	/* Menu close button */
    .main-menu-close {
        display: block;
    	background-color: rgba(0, 0, 0, 0.2);
    	border-radius: 100%;
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 26px;
        color: #FFFFFF;
        text-align: center;
        padding: 0 6px 0 10px;
        height: 36px;
    	width: 36px;
        line-height: 33px;
        cursor: pointer;
    	
	    -webkit-transition: all 0.2s ease 0s;
	     -moz-transition: all 0.2s ease 0s;
	      -ms-transition: all 0.2s ease 0s;
	       -o-transition: all 0.2s ease 0s;
	          transition: all 0.2s ease 0s;

    }
    .main-menu-close:hover .fa {
    	font-weight: 700 !important;
	}
	.main-menu-close .fa-angle-left {
        position: relative;
        left: -4px;
    }

	/* Remove the rollover functionality from the desktop menu */
    .main-navigation ul {
        display: block;
		visibility: visible !important;
		opacity: 1 !important;
    }
	
    .main-navigation #main-menu {
        color: #FFFFFF;
        box-shadow: 1px 0 1px rgba(255, 255, 255, 0.04) inset;
        position: fixed;
        top: 0;
        right: -280px;
        width: 280px;
        max-width: 100%;
        -ms-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 70px 0 30px 0;
        z-index: 100000;
        height: 100%;
        overflow: auto;
        -webkit-transition: right 0.4s ease 0s;
        -moz-transition: right 0.4s ease 0s;
        -ms-transition: right 0.4s ease 0s;
        -o-transition: right 0.4s ease 0s;
        transition: right 0.4s ease 0s;
    }
    #main-menu .menu {
    	border-top-width: 1px;
    	border-top-style: solid;
	}
    #main-menu.panoramic-mobile-menu-standard-color-scheme .menu {
    	border-top-color: #FFFFFF;
	}
	.main-navigation li {
        display: block;
        float: none;
        position: relative;
    }
    .main-navigation li a {
    	white-space: normal !important;
    	border-bottom-width: 1px;
    	border-bottom-style: solid;
		box-shadow: none;
		display: block;
		color: #FFFFFF;
        float: none;
        padding: 10px 22px;
        font-size: 14px;
        text-align: left;
  	}
    #main-menu.panoramic-mobile-menu-standard-color-scheme li a {
    	border-bottom-color: #FFFFFF;
	}
    #main-menu.panoramic-mobile-menu-standard-color-scheme li a:hover {
    	background-color: rgba(0, 0, 0, 0.2); 
  	}
    .main-navigation ul ul a {
    	text-transform: none;
  	}
    .main-navigation ul ul li:last-child a,
    .main-navigation ul ul li a {
        padding: 6px 30px;
        width: auto;
    }
    .main-navigation ul ul ul li a {
        padding: 6px 39px !important;
    }
    .main-navigation ul ul ul ul li a {
        padding: 6px 47px !important;
    }
    .main-navigation ul ul ul ul ul li a {
        padding: 6px 55px !important;
    }

    .main-navigation ul ul {
        position: relative !important;
    	box-shadow: none;
        top: 0 !important;
        left: 0 !important;
        float: none !important;
    	background-color: transparent;
        padding: 0;
        margin: 0;
        display: none;
    	border-top: none;
    }
	.main-navigation ul ul ul {
		left: 0 !important;
	}
	.menu-dropdown-btn {
    	display: block;
    }
    .open-page-item > ul.children,
    .open-page-item > ul.sub-menu {
    	display: block !important;
    }
    .open-page-item .fa-angle-down {
		color: #FFFFFF;
    	font-weight: 700 !important;
    }
    
    /* 1st level selected item */
    #main-menu.panoramic-mobile-menu-standard-color-scheme a:hover,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current-menu-item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current_page_item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current-menu-parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current_page_parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current-menu-ancestor > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme li.current_page_ancestor > a {
		background-color: rgba(0, 0, 0, 0.2) !important;
	}

	/* 2nd level selected item */
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current-menu-item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current_page_item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current-menu-parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current_page_parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current-menu-ancestor > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul li.current_page_ancestor > a {
		background-color: rgba(0, 0, 0, 0.2);
	}
	
	/* 3rd level selected item */
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current-menu-item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current_page_item > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current-menu-parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current_page_parent > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current-menu-ancestor > a,
	#main-menu.panoramic-mobile-menu-standard-color-scheme ul ul ul li.current_page_ancestor > a {
		background-color: rgba(0, 0, 0, 0.2);
	}
	
	.slider-placeholder {
		display: none;
	}
	
	.panoramic-slider-container.default .prev.top-padded,
	.panoramic-slider-container.default .next.top-padded {
		margin-top: -26px;
	}

	.header-image .overlay.top-padded,
	.panoramic-slider-container.default .slider .slide .overlay.top-padded {
		padding-top: 0;
	}
}
<?php
}
?>

<?php
// Only include the CSS to disable the sticky header if it is sticky and if there is a deactivation breakpoint set
if ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) && $sticky_header_deactivation_breakpoint ) {
	echo '/* Sticky Header */';
	echo '@media only screen and (max-width: ' .$sticky_header_deactivation_breakpoint. 'px) {';
?>

	.sticky-wrapper {
		height: auto !important;
	}

	.site-header.sticky.stuck {
		position: relative;
	}	
	.main-navigation.sticky.stuck {
		position: relative;
	}	

}
<?php 
}
?>

/* Blog Featured Image Rollover Effect  */

/* Opacity */
.featured-image-container.opacity-rollover .opacity {
	background-color: rgba( 0, 0, 0, <?php echo floatVal( get_theme_mod( 'panoramic-featured-image-rollover-effect-opacity', customizer_library_get_default( 'panoramic-featured-image-rollover-effect-opacity' ) ) ); ?>);
}

.masonry-grid-container {
    margin-left: -<?php echo floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ) / 2; ?>%;
	margin-right: -<?php echo floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ) / 2; ?>%;
}

<?php
$masonry_grid_columns = intval( get_theme_mod( 'panoramic-blog-masonry-grid-columns', customizer_library_get_default( 'panoramic-blog-masonry-grid-columns' ) ) );
?>

.masonry-grid-container article.blog-post-masonry-grid-layout {
	width: <?php echo ( 100 / $masonry_grid_columns ) - floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ); ?>%;
    margin-left: <?php echo floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ) / 2; ?>%;
	margin-right: <?php echo floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ) / 2; ?>%;
	margin-bottom: <?php echo floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ); ?>%;
}

@media screen and (max-width: 980px) {
	.masonry-grid-container article.blog-post-masonry-grid-layout {
	    width: <?php echo 50 - floatVal( get_theme_mod( 'panoramic-blog-masonry-grid-gutter', customizer_library_get_default( 'panoramic-blog-masonry-grid-gutter' ) ) ); ?>%;
	}
}

</style>