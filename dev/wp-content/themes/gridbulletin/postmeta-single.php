<?php
/*
 * Postmeta used by file single.
 */
?>

<div class="postmetadata">
	<?php printf( __( 'Category: %s', 'gridbulletin' ), get_the_category_list( __( ', ', 'gridbulletin' ) ) ); ?>
	<?php if(has_tag() ) : ?>
		<?php echo '|'; ?> <?php printf(__( 'Tag: %s', 'gridbulletin' ), get_the_tag_list('', __( ', ', 'gridbulletin' ) ) ); ?>
	<?php endif; ?>
</div>