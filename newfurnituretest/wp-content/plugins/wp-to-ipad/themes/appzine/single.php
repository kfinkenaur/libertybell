<?php 
global $wpti;

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1><?php the_title() ?></h1>

<div class="content">
	<?php echo $wpti->facebooktwitter() ?><br/>
	<?php 
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'wp-to-ipad' ),
		'meta-prep meta-prep-author',
		sprintf( '<span class="entry-date">%s</span>',
			get_the_date()
		),
		sprintf( '<span class="author vcard">%s</span>', get_the_author()
		)
	);
	?><br/><br/>

	<?php  the_content() ?>
	
	<?php 
	comments_template( '', true ); 
	?>
</div>

<br/><br/><br/>

<?php endwhile; ?>