<form class="ast-search" role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
	<input id="search-input" name="s"  value="<?php echo get_search_query(); ?>"/>
	<input id="search-submit" type="submit" value="<?php echo __("search","business-world"); ?>" />
</form>