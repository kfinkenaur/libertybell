<?php
/*
 * The content used by files archive and search.
 */
?>

<?php if( is_home() ) { ?>
	<?php if( $wp_query->current_post%4 == 0 ) : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-home left'); ?>> 
	<?php elseif( $wp_query->current_post%4 == 3 ) : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-home right'); ?>>
	<?php else : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-home'); ?>> 
	<?php endif; ?> 
<?php } else { ?> 
	<?php if( $wp_query->current_post%3 == 0 ) : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-archive left'); ?>> 
	<?php elseif( $wp_query->current_post%3 == 2 ) : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-archive right'); ?>>
	<?php else : ?> 
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-archive'); ?>> 
	<?php endif; ?> 
<?php } ?>

	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<h4 class="sticky-title"><?php _e( 'Featured post', 'gridbulletin' ); ?></h4>
	<?php endif; ?>

	<h2 class="post-title">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permalink to %s', 'gridbulletin'), the_title_attribute('echo=0')); ?>"> <?php the_title(); ?></a> 
	</h2>

	<?php if ( has_post_thumbnail() ) { 
		the_post_thumbnail(); 
	} ?>

	<?php the_excerpt(); ?>

	<?php get_template_part( 'postmeta' ); ?>

</article>