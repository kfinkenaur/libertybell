<?php
/**
 * The template for displaying search forms in Market
 *
 * @package Market
 */
?>
<form role="search" method="get" class="row search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class"search-form">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'market' ); ?></span>
		<input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search for anything on this site...', 'placeholder', 'market' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<button type="submit" class="btn btn-default search-submit"><i class="fa fa-search"> </i></button>
	</div>
</form>
