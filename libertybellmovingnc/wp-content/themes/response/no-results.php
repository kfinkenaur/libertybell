<?php
/**
 * Title: No-results template.
 *
 * Description: Defines content of search page when no results found in the search.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */
?>

<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'cyberchimps' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() ) { ?>

			<p><?php printf( '%1$s <a href="%2$s">%3$s</a>.',
												__( 'Ready to publish your first post?', 'cyberchimps' ), 
												admin_url( 'post-new.php' ),
												__( 'Get started here', 'cyberchimps' ) 
											); ?></p>

		<?php } elseif ( is_search() ) { ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cyberchimps' ); ?></p>
			<?php get_search_form(); ?>

		<?php } else { ?>

			<p><?php _e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'cyberchimps' ); ?></p>
			<?php get_search_form(); ?>

		<?php } ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 -->
