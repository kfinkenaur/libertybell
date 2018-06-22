<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Open Graph Namespace
 *
 * Adds the open graph namespace to the language attributes filter.
 * as required by ogp.me schema.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_ogp_namespace( $output ) {

	global $post;
	
	if( is_singular( 'post' ) ) {
		$wps_seo_booster_disable = get_post_meta( $post->ID, '_wps_seo_booster_disable', true );
	} else {
		$wps_seo_booster_disable = '';
	}
	
	if( is_singular( 'post' ) && empty( $wps_seo_booster_disable ) ) {
	
		$product_name = get_post_meta( $post->ID, '_wps_seo_booster_product_name', true );
		$recipe_name = get_post_meta( $post->ID, '_wps_seo_booster_recipe_name', true );
		$review_product_name = get_post_meta( $post->ID, '_wps_seo_booster_review_product_name', true );
		$software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
		
		if( $product_name == '' && $recipe_name == '' && $review_product_name == '' && $software_name == '' ) {
			$itemprop = ' itemscope itemtype="http://schema.org/Article"';
		} else {
			$itemprop = '';
		}		
	} else {
		$itemprop = '';
	}
	
	return $output.' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"' . $itemprop . '';
	
}

add_filter( 'language_attributes', 'wps_seo_booster_ogp_namespace' );

if( !function_exists( 'wpseo_get_value' ) ) {

	if( !class_exists( 'All_in_One_SEO_Pack' ) ) {
	/**
	 * Starting Buffer
	 *
	 * Does start the buffer before any other outputs has been done to the code.
	 * With that we're able to find out if any SEO plugins are installed and if so
	 * we can take these settings for the correct open graph output.
	 *
	 * @package WPSocial SEO Booster
	 * @since 1.0.0
	 * @credit Chuck Reynolds (email: chuck@rynoweb.com)
	 */
	function wps_seo_booster_ogp_start_ob() {
		ob_start( 'wps_seo_booster_ogp_matches' );
	}

	/**
	 * Matching Content
	 *
	 * Does scan the content to check if there are any entries for the
	 * title and the description and if it finds any entries it will
	 * take their values and uses them for the open graph. With that
	 * we make sure, that we take the already given values from SEO
	 * plugins or from the theme and use them, so that our plugin user
	 * doesn't need to edit all his content to support open graph.
	 *
	 * @package WPSocial SEO Booster
	 * @since 1.0.0
	 * @credit Chuck Reynolds (email: chuck@rynoweb.com)
	 */
	function wps_seo_booster_ogp_matches( $content ) {

		global $post;
		
		$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
		if( isset( $wps_seo_booster_options['home_page'] ) ) {
			$home_page = $wps_seo_booster_options['home_page'];
		} else {
			$home_page = '';
		}
		$home_title = $wps_seo_booster_options['home_title'];
		$home_description = $wps_seo_booster_options['home_description'];
		$home_image = $wps_seo_booster_options['home_image'];
		
		// Retrieve the open graph title meta data values if they exist
		$wps_seo_booster_ogp_title = get_post_meta( $post->ID, '_wps_seo_booster_ogp_title', true );
			
		// Retrieve the open graph description meta data values if they exist
		$wps_seo_booster_ogp_description = get_post_meta( $post->ID, '_wps_seo_booster_ogp_description', true );
			
		// Grab the page title and meta description
		$title = preg_match( '/<title>(.*)<\/title>/', $content, $title_matches );
		$description = preg_match( '/<meta name="description" content="(.*)"/', $content, $description_matches );
		
		// Take page title and place it in the ogp meta tags, but only if the custom post open graph title is empty
		if( is_home() || is_front_page() ) {
			if ( $home_page == 1 ) {
				echo '<meta property="og:title" content="' . esc_attr( $home_title ) . '">' . "\n";
			} else {
				if( $wps_seo_booster_ogp_title == '' ) {
					if ( $title !== FALSE && count( $title_matches ) == 2 ) {
						$content = preg_replace( '/<meta property="og:title" content="(.*)">/', '<meta property="og:title" content="' . $title_matches[1] . '">', $content );
						$content = preg_replace( '/<meta itemprop="name" content="(.*)">/', '<meta itemprop="name" content="' . $title_matches[1] . '">', $content );
						$content = preg_replace( '/<meta name="twitter:title" content="(.*)">/', '<meta name="twitter:title" content="' . $title_matches[1] . '">', $content );
					}
				}
			}
		} else {
			if( $wps_seo_booster_ogp_title == '' ) {
				if ( $title !== FALSE && count( $title_matches ) == 2 ) {
					$content = preg_replace( '/<meta property="og:title" content="(.*)">/', '<meta property="og:title" content="'. $title_matches[1] .'">', $content );
					$content = preg_replace( '/<meta itemprop="name" content="(.*)">/', '<meta itemprop="name" content="' . $title_matches[1] . '">', $content );
					$content = preg_replace( '/<meta name="twitter:title" content="(.*)">/', '<meta name="twitter:title" content="' . $title_matches[1] . '">', $content );
				}
			}
		}
		
		// Take page meta description and place it in the ogp meta tags, but only if the custom post open graph description is empty
		if( is_home() || is_front_page() ) {
			if ( $home_page == 1 ) {
				echo '<meta property="og:description" content="' . esc_attr( $home_description ) . '">' . "\n";
			} else {
				if( $wps_seo_booster_ogp_description == '' ) {
					if ( $description !== FALSE && count( $description_matches ) == 2 ) {
						$content = preg_replace( '/<meta property="og:description" content="(.*)">/', '<meta property="og:description" content="' . $description_matches[1] . '">', $content );
						$content = preg_replace( '/<meta itemprop="description" content="(.*)">/', '<meta itemprop="description" content="' . $description_matches[1] . '">', $content );
						$content = preg_replace( '/<meta name="twitter:description" content="(.*)">/', '<meta name="twitter:description" content="' . $description_matches[1] . '">', $content );
					}
				}
			}
		} else {
			if( $wps_seo_booster_ogp_description == '' ) {
				if ( $description !== FALSE && count( $description_matches ) == 2 ) {
					$content = preg_replace( '/<meta property="og:description" content="(.*)">/', '<meta property="og:description" content="' . $description_matches[1] . '">', $content );
					$content = preg_replace( '/<meta itemprop="description" content="(.*)">/', '<meta itemprop="description" content="' . $description_matches[1] . '">', $content );
					$content = preg_replace( '/<meta name="twitter:description" content="(.*)">/', '<meta name="twitter:description" content="' . $description_matches[1] . '">', $content );
				}
			}
		}	
		return $content;
	}

	/**
	 * Ending Buffer
	 *
	 * Does end the buffer and fires it on a very high priority so that we are sure
	 * it really is then end of the content and we have found all our needed entries.
	 *
	 * @package WPSocial SEO Booster
	 * @since 1.0.0
	 * @credit Chuck Reynolds (email: chuck@rynoweb.com)
	 */
	function wps_seo_booster_ogp_flush_ob() {
		ob_end_flush();
	}

	add_action( 'init', 'wps_seo_booster_ogp_start_ob', 0 );
	add_action( 'wp_head', 'wps_seo_booster_ogp_flush_ob', 999 );
	
	}
}

/**
 * Open Graph Support
 *
 * Injects the open graph meta tags in to the header.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_ogp_head() {

	global $post;
	
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
		/* Getting data from the settings page */
		$app_id = $wps_seo_booster_options['app_id'];;
		$user_id = $wps_seo_booster_options['user_id'];
		$description = get_option( 'blogdescription' );	
		$image = $wps_seo_booster_options['allways_image'];
		$default_image = $wps_seo_booster_options['default_image'];
		if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $post->ID ) ) {
			if ( has_post_thumbnail()) {
				$thumbsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '', '' );
				$thumbnail = $thumbsrc[0];
			}
		} else {
			$thumbnail = '';
		}
		$type = $wps_seo_booster_options['content_type'];
		
		// Retrive the homepage entries for open graph if they are activated
		if( isset( $wps_seo_booster_options['home_page'] ) ) {
			$home_page = $wps_seo_booster_options['home_page'];
		} else {
			$home_page = '';
		}
		$home_title = $wps_seo_booster_options['home_title'];
		$home_description = $wps_seo_booster_options['home_description'];
		$home_image = $wps_seo_booster_options['home_image'];

		/* Getting data from the meta box */
		// Retrieve the open graph title meta data values if they exist
		$wps_seo_booster_ogp_title = get_post_meta( $post->ID, '_wps_seo_booster_ogp_title', true );
		
		// Retrieve the open graph description meta data values if they exist
		$wps_seo_booster_ogp_description = get_post_meta( $post->ID, '_wps_seo_booster_ogp_description', true );
		
		// Retrieve the open graph type meta data values if they exist
		$wps_seo_booster_ogp_type = get_post_meta( $post->ID, '_wps_seo_booster_ogp_type', true );
		
		// Retrieve the open graph image meta data value if it exists
		$wps_seo_booster_ogp_image = get_post_meta( $post->ID, '_wps_seo_booster_ogp_image', true );
		
		// Retrieve the open graph video url meta data values if they exist
		$wps_seo_booster_ogp_video_url = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_url', true );
		
		// Retrieve the open graph video height meta data values if they exist
		$wps_seo_booster_ogp_video_height = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_height', true );
		
		// Retrieve the open graph video width meta data values if they exist
		$wps_seo_booster_ogp_video_width = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_width', true );
		
		// Retrieve the open graph audio url meta data values if they exist
		$wps_seo_booster_ogp_audio_url = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_url', true );
		
		// Retrieve the open graph audio title meta data values if they exist
		$wps_seo_booster_ogp_audio_title = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_title', true );
		
		// Retrieve the open graph audio artist meta data values if they exist
		$wps_seo_booster_ogp_audio_artist = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_artist', true );
		
		// Retrieve the open graph audio album meta data values if they exist
		$wps_seo_booster_ogp_audio_album = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_album', true );
		
		// Retrieve the open graph post app id meta data values if they exist
		$wps_seo_booster_ogp_post_app_id = get_post_meta( $post->ID, '_wps_seo_booster_ogp_post_app_id', true );
		
		// Retrieve the open graph post fb admins meta data values if they exist
		$wps_seo_booster_ogp_post_fb_admins = get_post_meta( $post->ID, '_wps_seo_booster_ogp_post_fb_admins', true );
		
		/* Scanning content for image */
		$contentimagesrc = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		if( preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches ) ) {
			$contentimage = $matches[1][0];
		} else {
			$contentimage = '';
		}		
		
		/* Preparing meta entries */
			
		/* Retriving the correct Title */
		if( is_home() || is_front_page() ) {
			if( $home_page == 1 ) {
				$meta_title = $home_title;
			} else {
				if( $wps_seo_booster_ogp_title != '' ) {
					$meta_title = $wps_seo_booster_ogp_title;
				} elseif( function_exists( 'wpseo_get_value' ) && wpseo_get_value( 'title' ) != '' ) {
					$meta_title = wpseo_get_value( 'title' );
				} elseif( class_exists( 'All_in_One_SEO_Pack' ) ) {
					$aio_seo_title = htmlspecialchars( stripcslashes( get_post_meta( $post->ID, '_aioseop_title', true ) ) );
					if( $aio_seo_title != '' ) {			
						$meta_title = $aio_seo_title;
					} 
				} elseif( is_home() || is_front_page() ) {
					$meta_title = get_bloginfo( 'name' );
				} else {
					$meta_title = get_the_title();
				}
			}
		} else {
			if( $wps_seo_booster_ogp_title != '' ) {
				$meta_title = $wps_seo_booster_ogp_title;
			} elseif( function_exists( 'wpseo_get_value' ) && wpseo_get_value( 'title' ) != '' ) {
				$meta_title = wpseo_get_value( 'title' );
			} elseif( class_exists( 'All_in_One_SEO_Pack' ) ) {
				$aio_seo_title = htmlspecialchars( stripcslashes( get_post_meta( $post->ID, '_aioseop_title', true ) ) );
				if( $aio_seo_title != '' ) {			
					$meta_title = $aio_seo_title;
				} 
			} elseif( is_home() || is_front_page() ) {
				$meta_title = get_bloginfo( 'name' );
			} else {
				$meta_title = get_the_title();
			}
		}			
		
		/* Permalink of the content */
		if( is_home() || is_front_page() ) {
			$url = get_bloginfo( 'url' );
		} else {
			$url = get_permalink( $post->ID );
		}		
				
		/** 
		 * Content Description. First we check if there is an enrty in the description meta box filed.
		 * The we check if there is one of the three most popular SEO plugins installed.
		 * If that isn't the case we will take the blog description. Settings > General > Tagline 
		 */
		if( is_home() || is_front_page() ) {
			if ( $home_page == 1 ) {
				$meta_description = $home_description;
			} elseif ( $wps_seo_booster_ogp_description != '' ) {
				$meta_description = $wps_seo_booster_ogp_description;		
			} elseif( function_exists( 'wpseo_get_value' ) && wpseo_get_value( 'metadesc' ) != '' ) {	
				$meta_description = wpseo_get_value( 'metadesc' );	
			} elseif ( class_exists( 'All_in_One_SEO_Pack' ) ) {
				$aio_seo_desc = htmlspecialchars(stripcslashes(get_post_meta( $post->ID, '_aioseop_description', true ) ) );
				if( $aio_seo_desc != '' ) {			
					$meta_description = $aio_seo_desc;
				}
			} elseif ( is_singular() ) { /* General blog description Settings > General > Tagline */
				if ( has_excerpt( $post->ID ) ) {
					$meta_description = strip_tags( strip_shortcodes( get_the_excerpt( $post->ID ) ) );
				} else {
					$meta_description = str_replace( "\r\n", ' ' , substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
				}
			} else {
				$meta_description = get_bloginfo( 'description' );
			}
		} else {
			if ( $wps_seo_booster_ogp_description != '' ) {
				$meta_description = $wps_seo_booster_ogp_description;	
			} elseif( function_exists( 'wpseo_get_value' ) && wpseo_get_value( 'metadesc' ) != '' ) {		
				$meta_description = wpseo_get_value( 'metadesc' );
			} elseif ( class_exists( 'All_in_One_SEO_Pack' ) ) {
				$aio_seo_desc = htmlspecialchars(stripcslashes(get_post_meta( $post->ID, '_aioseop_description', true ) ) );
				if( $aio_seo_desc != '' ) {			
					$meta_description = $aio_seo_desc;
				}
			} elseif ( is_singular() ) {
				if ( has_excerpt( $post->ID ) ) {
					$meta_description = strip_tags( strip_shortcodes( get_the_excerpt( $post->ID ) ) );
				} else {
					$meta_description = str_replace( "\r\n", ' ' , substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
				}
			} else {
				$meta_description = get_bloginfo( 'description' );
			}
		}
		
		/** 
		 * Image. First we check if there is an entry within the 'Always use this image' field.
		 * If that is empty then we check if there is an entry within the meta box image field.
		 * If that is emtpy too we check if there is a featured image within the content.
		 * If that is empty too we will san the content to see if there is an image within the text.
		 * If we can't find an image within the content we check if there is an image url entered within
		 * the plugin settings (Default Image).
		 * If we can't find any image then halleluia :-)
		 */
		$meta_image = '';
		if( is_home() || is_front_page() ) {
			if ( $home_page == 1 ) {
				$meta_image = $home_image;
			} else {
				/* Image from the plugin settings (Always use this image) */
				if ( $image ) {
					$meta_image = $image;
				}
				/* Image from the meta box */
				elseif ( $wps_seo_booster_ogp_image ) {
					$meta_image = $wps_seo_booster_ogp_image;
				}
				/* Featured image */
				elseif ( $thumbnail ) {
					$meta_image = $thumbnail;
				}
				/* Image within the content */
				elseif ( $contentimage ) {
					$meta_image = $contentimage;
				}
				/* Default image from the plugin settings */
				elseif ( $default_image ) {
					$meta_image = $default_image;
				}
			}
		} else {
			/* Image from the plugin settings (Always use this image) */
			if ( $image ) {
				$meta_image = $image;				
			}
			/* Image from the meta box */
			elseif ( $wps_seo_booster_ogp_image ) {
				$meta_image = $wps_seo_booster_ogp_image;
			}
			/* Featured image */
			elseif ( $thumbnail ) {
				$meta_image = $thumbnail;
			}
			/* Image within the content */
			elseif ( $contentimage ) {	
				$meta_image = $contentimage;
			}
			/* Default image from the plugin settings */
			elseif ( $default_image ) {
				$meta_image = $default_image;
			}
		}		
		
		/* Retrieving the twitter user id */
		$twitter_card = get_the_author_meta( 'twitter_card_user', $post->post_author );
		
		echo "\n<!-- WPSocial SEO Booster Plugin (Version " . WPS_SEO_BOOSTER_VERSION . ") || Open Graph, Google Plus & Twitter Card Integration || http://wordpress.org/plugins/wp-social-seo-booster/ -->\n";
		
		/* Google itemprop integration */
		if( $meta_title ) echo '<meta itemprop="name" content="' . esc_attr( $meta_title ) . '">' . "\n";
		if( $meta_description ) echo '<meta itemprop="description" content="' . esc_attr( $meta_description ) . '">' . "\n";
		if( $meta_image ) echo '<meta itemprop="image" content="' . esc_url( $meta_image ) . '" />' . "\n";
		/* End Google itemprop integration */
		
		/* Open Graph integration */
		if( isset( $wps_seo_booster_options['enable_opg'] ) ) {
		
			/* Language */
			echo '<meta property="og:locale" content="' . esc_attr( strtolower( get_locale() ) ) . '">' . "\n";
			
			/* Facebook App ID from the meta box */
			if ( $wps_seo_booster_ogp_post_app_id ) echo '<meta property="fb:app_id" content="' . esc_attr( $wps_seo_booster_ogp_post_app_id ) . '">' . "\n";
			/* Facebook App ID from the plugin settings */
			elseif ( $app_id ) echo '<meta property="fb:app_id" content="' . esc_attr( $app_id ) . '">' . "\n";
			
			/* Facebook Fan Page Admin ID from the meta box */
			if ( $wps_seo_booster_ogp_post_fb_admins ) echo '<meta property="fb:admins" content="' . esc_attr( $wps_seo_booster_ogp_post_fb_admins ) . '">' . "\n";
			/* Facebook Fan Page Admin ID from the plugin settings */
			elseif ( $user_id ) echo '<meta property="fb:admins" content="' . esc_attr( $user_id ) . '">' . "\n";
			
			/* Title */
			if( $meta_title ) echo '<meta property="og:title" content="' . esc_attr( $meta_title ) . '">' . "\n";
			
			/* Description */
			if( $meta_description ) echo '<meta property="og:description" content="' . esc_attr( $meta_description ) . '">' . "\n";
			
			/* Url */
			if( $url ) echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";	

			/* Website name. This is being taken from the Blog Name. Settings > General > Site Title */
			$site_name = get_bloginfo( 'name' );
			if ( $site_name ) echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
			
			/* Content Type from the plugin settings */
			if ( $wps_seo_booster_ogp_type ) echo '<meta property="og:type" content="' . esc_attr( $wps_seo_booster_ogp_type ) . '">' . "\n";
			/* Content Type from the meta box */
			elseif ( $type ) echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
			
			/* Image */
			if ( $meta_image ) echo '<meta property="og:image" content="' . esc_url( $meta_image ) . '" />' . "\n";		
			
			/* Video URL from the meta box */
			if ( $wps_seo_booster_ogp_video_url ) echo '<meta property="og:video" content="' . esc_url( $wps_seo_booster_ogp_video_url ) . '">' . "\n";
			/* Video height from the meta box */
			if ( $wps_seo_booster_ogp_video_height ) echo '<meta property="og:video:height" content="' . esc_attr( $wps_seo_booster_ogp_video_height ) . '">' . "\n";
			/* Video Width from the meta box */
			if ( $wps_seo_booster_ogp_video_width ) echo '<meta property="og:video:width" content="' . esc_attr( $wps_seo_booster_ogp_video_width ) . '">' . "\n";
			/* Video Type. We define that because facebook does only support one ty (SWF) */
			if ( $wps_seo_booster_ogp_video_url ) echo '<meta property="og:video:type" content="application/x-shockwave-flash" />' . "\n";		
			
			/* Audio URL from the meta box */
			if ( $wps_seo_booster_ogp_audio_url ) echo '<meta property="og:audio" content="' . esc_attr( $wps_seo_booster_ogp_audio_url ) . '">' . "\n";
			/* Audio Title from the meta box */
			if ( $wps_seo_booster_ogp_audio_title ) echo '<meta property="og:audio:title" content="' . esc_attr( $wps_seo_booster_ogp_audio_title ) . '">' . "\n";
			/* Audio Artist from the meta box */
			if ( $wps_seo_booster_ogp_audio_artist ) echo '<meta property="og:audio:artist" content="' . esc_attr( $wps_seo_booster_ogp_audio_artist ) . '">' . "\n";
			/* Audio Album from the meta box */
			if ( $wps_seo_booster_ogp_audio_album ) echo '<meta property="og:audio:album" content="' . esc_attr( $wps_seo_booster_ogp_audio_album ) . '">' . "\n";
			/* Audio Type. We define that because Facebook does only support MP3. */
			if ( $wps_seo_booster_ogp_audio_url ) echo '<meta property="og:audio:type" content="application/mp3" />' . "\n";
		
		}
		/* End Open Graph integration */
		
		/* Twitter card integration */
		if( $twitter_card != '' ) {
			echo '<meta name="twitter:card" content="summary">' . "\n";
			echo '<meta name="twitter:site" content="@' . esc_attr( $twitter_card ) . '">' . "\n";
			echo '<meta name="twitter:creator" content="@' . esc_attr( $twitter_card ) . '">' . "\n";
			echo '<meta name="twitter:url" content="' . esc_url( $url ) . '">' . "\n";
			echo '<meta name="twitter:title" content="' . esc_attr( $meta_title ) . '">' . "\n";
			echo '<meta name="twitter:description" content="' . esc_attr( apply_filters( 'meta_description', $meta_description ) ) . '">' . "\n";
			echo '<meta name="twitter:image" content="' . esc_url( $meta_image ) . '">' . "\n";
		}		
		
		/* End Twitter card integration */
		echo "<!-- / WPSocial SEO Booster Plugin -->\n\n";
}

/**
 * Open Graph Support Home Page
 *
 * Injects the open graph meta tags in to the header for the home page.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_head_home() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
		
	// site url
	$url = get_bloginfo( 'url' );
		
	// Getting Open Graph data from the settings page
	$site_name = get_bloginfo( 'name' );
	$app_id = $wps_seo_booster_options['app_id'];;
	$user_id = $wps_seo_booster_options['user_id'];
	$ogp_home = isset( $wps_seo_booster_options['enable_opg'] ) ? $wps_seo_booster_options['enable_opg'] : '';
	$type = $wps_seo_booster_options['content_type'];		
	$home_title_ogp = $wps_seo_booster_options['home_title'];
	$home_description_opg = $wps_seo_booster_options['home_description'];
	$home_image_opg = $wps_seo_booster_options['home_image'];
		
	// Getting Facebook Open Graph data from the settings page
	if( $ogp_home == 1 ) {		
		echo "\n<!-- WPSocial SEO Booster Plugin (Version " . WPS_SEO_BOOSTER_VERSION . ") || Open Graph, Google Plus & Twitter Card Integration || http://wordpress.org/plugins/wp-social-seo-booster/ -->\n";
		
		/* Language */
		echo '<meta property="og:locale" content="' . esc_attr( strtolower( get_locale() ) ) . '">' . "\n";
		if( $app_id ) {
			echo '<meta property="fb:app_id" content="' . esc_attr( $app_id ) . '">' . "\n";
		}
		if( $user_id ) {
			echo '<meta property="fb:admins" content="' . esc_attr( $user_id ) . '">' . "\n";
		}
		if( $home_title_ogp ) {
			echo '<meta property="og:title" content="' . esc_attr( $home_title_ogp ) . '">' . "\n";
		}
		if( $home_description_opg ) {
			echo '<meta property="og:description" content="' . esc_attr( $home_description_opg ) . '">' . "\n";
		}
		if( $url ) {
			echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		}
		if( $site_name ) {
			echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
		}
		if( $type ) {
			echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
		}
		if( $home_image_opg ) {
			echo '<meta property="og:image" content="' . esc_url( $home_image_opg ) . '">' . "\n";	
		}
		
		echo "<!-- / WPSocial SEO Booster Plugin -->\n\n";
	}
}

/**
 * Adding everything to the front end
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_add() {

	global $post;
		
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
			
	$ogp_home = isset( $wps_seo_booster_options['home_page'] ) ? $wps_seo_booster_options['home_page'] : '';
	$gplus_home = isset( $wps_seo_booster_options['enable_gplus_home'] ) ? $wps_seo_booster_options['enable_gplus_home'] : '';
	$tw_home_page = isset( $wps_seo_booster_options['tw_home_page'] ) ? $wps_seo_booster_options['tw_home_page'] : '';

	if( is_singular( 'post' ) ) {
		$wps_seo_booster_disable = get_post_meta( $post->ID, '_wps_seo_booster_disable', true );
	}
		
	if( is_home() && ( !empty( $ogp_home ) || !empty( $gplus_home ) || !empty( $tw_home_page ) ) ) {
		add_action( 'wp_head', 'wps_seo_booster_head_home', 2 );
	} elseif( empty( $wps_seo_booster_disable ) && ( is_home() || is_singular( 'post' ) ) ) {
		add_action( 'wp_head', 'wps_seo_booster_ogp_head', 2 );
	}
}

add_action( 'wp', 'wps_seo_booster_add' );