<?php
if ( get_theme_mod( 'panoramic-social-pronoun', customizer_library_get_default( 'panoramic-social-pronoun' ) ) == 'panoramic-social-pronoun-group' ) {
	$pronoun 	= __( 'us', 'panoramic' );
	$determiner = __( 'our', 'panoramic' );
} else {
	$pronoun 	= __( 'me', 'panoramic' );
	$determiner = __( 'my', 'panoramic' );
}
?>

<ul class="social-links">
<?php
if( get_theme_mod( 'panoramic-social-email', customizer_library_get_default( 'panoramic-social-email' ) ) != '' ) :
    echo '<li><a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'panoramic-social-email' ), 1 ) ) . '" title="';
	printf( __( 'Send %1$s an email', 'panoramic' ), $pronoun);
	echo '" class="social-email"><i class="fa fa-envelope-o"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-skype', customizer_library_get_default( 'panoramic-social-skype' ) ) != '' ) :
    echo '<li><a href="skype:' . esc_html( get_theme_mod( 'panoramic-social-skype' ) ) . '?userinfo" title="';
	printf( __( 'Contact %1$s on Skype', 'panoramic' ), $pronoun);
	echo '" class="social-skype"><i class="fa fa-skype"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-facebook', customizer_library_get_default( 'panoramic-social-facebook' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-facebook' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Facebook', 'panoramic' ), $pronoun);
	echo '" class="social-facebook"><i class="fa fa-facebook"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-twitter', customizer_library_get_default( 'panoramic-social-twitter' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-twitter' ) ) . '" target="_blank" title="';
	printf( __( 'Follow %1$s on Twitter', 'panoramic' ), $pronoun);
	echo '" class="social-twitter"><i class="fa fa-twitter"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-google-plus', customizer_library_get_default( 'panoramic-social-google-plus' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-google-plus' ) ) . '" target="_blank" title="';
	printf( __( 'Add %1$s on Google Plus', 'panoramic' ), $pronoun);
	echo '" class="social-google-plus"><i class="fa fa-google-plus"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-youtube', customizer_library_get_default( 'panoramic-social-youtube' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-youtube' ) ) . '" target="_blank" title="';
	printf( __( 'View %1$s YouTube Channel', 'panoramic' ), $determiner);
	echo '" class="social-youtube"><i class="fa fa-youtube"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-instagram', customizer_library_get_default( 'panoramic-social-instagram' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-instagram' ) ) . '" target="_blank" title="';
	printf( __( 'Follow %1$s on Instagram', 'panoramic' ), $pronoun);
	echo '" class="social-instagram"><i class="fa fa-instagram"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-pinterest', customizer_library_get_default( 'panoramic-social-pinterest' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-pinterest' ) ) . '" target="_blank" title="';
	printf( __( 'Pin %1$s on Pinterest', 'panoramic' ), $pronoun);
	echo '" class="social-pinterest"><i class="fa fa-pinterest"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-linkedin', customizer_library_get_default( 'panoramic-social-linkedin' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-linkedin' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on LinkedIn', 'panoramic' ), $pronoun);
	echo '" class="social-linkedin"><i class="fa fa-linkedin"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-tumblr', customizer_library_get_default( 'panoramic-social-tumblr' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-tumblr' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Tumblr', 'panoramic' ), $pronoun);
	echo '" class="social-tumblr"><i class="fa fa-tumblr"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-flickr', customizer_library_get_default( 'panoramic-social-flickr' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-flickr' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Flickr', 'panoramic' ), $pronoun);
	echo '" class="social-flickr"><i class="fa fa-flickr"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-yelp', customizer_library_get_default( 'panoramic-social-yelp' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-yelp' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Yelp', 'panoramic' ), $pronoun);
	echo '" class="social-yelp"><i class="fa fa-yelp"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-vimeo', customizer_library_get_default( 'panoramic-social-vimeo' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-vimeo' ) ) . '" target="_blank" title="';
	printf( __( 'Follow %1$s on Vimeo', 'panoramic' ), $pronoun);
	echo '" class="social-vimeo"><i class="fa fa-vimeo"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-etsy', customizer_library_get_default( 'panoramic-social-etsy' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-etsy' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Etsy', 'panoramic' ), $pronoun);
	echo '" class="social-etsy"><i class="fa fa-etsy"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-tripadvisor', customizer_library_get_default( 'panoramic-social-tripadvisor' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-tripadvisor' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on TripAdvisor', 'panoramic' ), $pronoun);
	echo '" class="social-tripadvisor"><i class="fa fa-tripadvisor"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-yahoo-groups', customizer_library_get_default( 'panoramic-social-yahoo-groups' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-yahoo-groups' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Yahoo! Groups', 'panoramic' ), $pronoun);
	echo '" class="social-yahoo-groups"><i class="fa fa-yahoo"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-snapchat', customizer_library_get_default( 'panoramic-social-snapchat' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-snapchat' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Snapchat', 'panoramic' ), $pronoun);
	echo '" class="social-snapchat"><i class="fa fa-snapchat"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-behance', customizer_library_get_default( 'panoramic-social-behance' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-behance' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Behance', 'panoramic' ), $pronoun);
	echo '" class="social-behance"><i class="fa fa-behance"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-soundcloud', customizer_library_get_default( 'panoramic-social-soundcloud' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-soundcloud' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on SoundCloud', 'panoramic' ), $pronoun);
	echo '" class="social-soundcloud"><i class="fa fa-soundcloud"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-xing', customizer_library_get_default( 'panoramic-social-xing' ) ) != '' ) :
    echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-xing' ) ) . '" target="_blank" title="';
	printf( __( 'Find %1$s on Xing', 'panoramic' ), $pronoun);
	echo '" class="social-xing"><i class="fa fa-xing"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-social-custom-icon-code', customizer_library_get_default( 'panoramic-social-custom-icon-code' ) ) != '' ) :
	echo '<li><a href="' . esc_url( get_theme_mod( 'panoramic-social-custom-icon-url' ) ) . '" target="_blank" title="';
	echo esc_attr( get_theme_mod( 'panoramic-social-custom-icon-hover-text' ) );
	echo '" class="social-custom"><i class="fa ' . get_theme_mod( 'panoramic-social-custom-icon-code' ) . '"></i></a></li>';
endif;

if( get_theme_mod( 'panoramic-header-search', customizer_library_get_default( 'panoramic-header-search' ) ) ) :
	echo '<li class="search"><i title="';
	printf( __( 'Search %1$s website', 'panoramic' ), $determiner);
	echo '" class="fa fa-search search-btn"></i></li>';
endif; ?>
</ul>