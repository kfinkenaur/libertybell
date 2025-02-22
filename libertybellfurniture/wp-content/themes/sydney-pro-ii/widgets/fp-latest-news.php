<?php

class Sydney_Latest_News extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_latest_news_widget', 'description' => __( 'Show the latest news from your blog.', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Latest News - A', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_latest_news_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$category  		= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : 3;
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';											
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'sydney' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show posts from all categories.', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('Add the text for the button here if you want to change the default <em>See all our news</em>', 'sydney'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>		

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['number'] 		= strip_tags($new_instance['number']);
		$instance['category'] 		= strip_tags($new_instance['category']);
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);						
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['sydney_latest_news']) )
			delete_option('sydney_latest_news');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('sydney_latest_news', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'sydney_latest_news', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : 3;
		if ( ! $number )
			$number 	= 3;		
		$category = isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$see_all_text = isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : __( 'See all our news', 'sydney' );
		if ($see_all_text == '') {
			$see_all_text = __( 'See all our news', 'sydney' );
		}

		$r = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'category_name'		  => $category,
			'posts_per_page'	  => $number,			
		) );

		echo $args['before_widget'];

		if ($r->have_posts()) :
?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<div class="blog-post col-md-4 col-sm-6 col-xs-12">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('medium-thumb'); ?>
					</a>			
				</div>	
			<?php endif; ?>						
			<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
				<div class="entry-summary"><?php the_excerpt(); ?></div>
			</div>
		<?php endwhile; ?>

		<?php $cat = get_term_by('slug', $category, 'category') ?>
		<?php if ($category) : //Link to the category page instead of blog page if a category is selected ?>
			<a href="<?php echo esc_url(get_category_link(get_cat_ID($cat -> name))); ?>" class="roll-button more-button"><?php echo $see_all_text; ?></a>
		<?php else : ?>
			<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="roll-button more-button"><?php echo $see_all_text; ?></a>
		<?php endif; ?>		
	<?php
		echo $args['after_widget'];
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'sydney_latest_news', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}