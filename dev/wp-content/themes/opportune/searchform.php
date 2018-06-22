<?php
/**
 * The template for displaying search forms 
 * @package Opportune
 */
?>



<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'opportune' ); ?></span>
<div class="form-group">		
      		<input type="text" class="form-control" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="<?php echo esc_attr_x( 'Enter search words','placeholder',  'opportune' ) ; ?>" title="<?php echo esc_attr_x( 'Search', 'label', 'opportune' ); ?>" >
   </div>           
   <div class="form-group">
                <input class="button-search" type="submit" value="<?php echo _x( 'Search', 'submit button', 'opportune' ); ?>"></input>
          
    	</div>
</form>   

