<form method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>/">
	<label class="hidden" for="s"></label>
	<button><i class="fa fa-search"></i></button>
	<input type="text" value="<?php the_search_query(); ?>" placeholder="<?php _e( 'Search...', 'happenings') ?>" name="s" id="s" />
</form>