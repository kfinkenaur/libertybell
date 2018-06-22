<aside>

<?php if ( get_theme_mod( 'happenings_logo' ) ) : ?>
    <div class='site-logo'>
        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' 
        	title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' 
        	rel='home'><img src='<?php echo esc_url( get_theme_mod( 'happenings_logo' ) ); ?>' 
        	alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
    </div>
<?php else : ?>
    <hgroup>
        <h1 class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' 
        	title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' 
        	rel='home'><?php bloginfo( 'name' ); ?></a></h1>
        <!--<h2 class='site-description'><?php bloginfo( 'description' ); ?></h2>-->
    </hgroup>
<?php endif; ?>
	
	<p class='description'><?php bloginfo( 'description' ); ?></p>
      <div id='widgetized-area'>

	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area')) : else : ?>

	<div class="pre-widget">
		<p><strong><?php _e('Widgetized Area', 'happenings'); ?></strong></p>
		<p><?php _e('This panel is active and ready for you to add some widgets via the WP Admin', 'happenings'); ?></p>
	</div>

	<?php endif; ?>

</div>
    </aside>