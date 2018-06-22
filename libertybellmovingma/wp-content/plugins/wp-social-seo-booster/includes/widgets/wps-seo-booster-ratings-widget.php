<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'wps_seo_booster_load_ratings_widget' );

/**
 * Register the Top Rated Widget
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_load_ratings_widget() {
	register_widget( 'Wps_Seo_Booster_Ratings_Widget' );
}

/**
 * Rated Posts
 *
 * Gets all the posts which received a rating.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_star_ratings_get( $total=5, $cat=false ) {
		
	global $wpdb;
	$table = $wpdb->prefix . 'postmeta';
	
	if( !$cat ) {
	    $rated_posts = $wpdb->get_results("SELECT a.ID, a.post_title, b.meta_value AS 'ratings' FROM " . $wpdb->posts . " a, $table b, $table c WHERE a.post_status='publish' AND a.ID=b.post_id AND a.ID=c.post_id AND b.meta_key='_wps_seo_booster_star_avg' AND c.meta_key='_wps_seo_booster_star_casts' ORDER BY b.meta_value DESC, c.meta_value DESC LIMIT $total");
	} else {
		$table2 = $wpdb->prefix . 'term_taxonomy';
		$table3 = $wpdb->prefix . 'term_relationships';
		$rated_posts = $wpdb->get_results("SELECT a.ID, a.post_title, b.meta_value AS 'ratings' FROM " . $wpdb->posts . " a, $table b, $table2 c, $table3 d, $table e WHERE c.term_taxonomy_id=d.term_taxonomy_id AND c.term_id=$cat AND d.object_id=a.ID AND a.post_status='publish' AND a.ID=b.post_id AND a.ID=e.post_id AND b.meta_key='_wps_seo_booster_star_avg' AND e.meta_key='_wps_seo_booster_star_casts' ORDER BY b.meta_value DESC, e.meta_value DESC LIMIT $total");
	}
	return $rated_posts;
}

/**
 * Wps_Seo_Booster_Ratings_Widget Widget Class
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update for displaying top rated posts.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
class Wps_Seo_Booster_Ratings_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	public function Wps_Seo_Booster_Ratings_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wps-seo-booster-top-rated', 'description' => __( 'A rating widget, which will display your top rated content.', 'wpsseo' ) );

		/* Create the widget. */
		$this->WP_Widget( 'wps-seo-booster-top-rated', __( 'SEO Booster: Top Rated Content', 'wpsseo' ), $widget_ops );
	}
	
	/**
	 * Outputs the content of the widget
	 */
	public function widget( $args, $instance ) {
	
		extract( $args );
		
		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );		 
		$limit = apply_filters( 'widget_limit', $instance['limit'] );	
		$category = apply_filters( 'widget_category', $instance['category'] );

		echo $before_widget;
		
		if ( $title ) {
			$thead = '	<thead>
							<tr>
								<td colspan="2">
									<span class="wps-seo-booster-item">' . $title . '</span>
								</td>
							</tr>
						</thead> '; 
		} else {
			$thead = '';
		}
		
		$posts = wps_seo_booster_star_ratings_get( $limit, $category );
		
		echo '	<div class="widget-seo-booster-top-rated">';
		
		echo '		<table width="100%">
						
						' . $thead . '
						
						<tbody>';
						
			foreach( $posts as $post ) {
			
				$stars = '';
				if( $post->ratings <= 1 ) {
					$stars = '1stars';
				} elseif( $post->ratings > 1 && $post->ratings <= 1.5 ) {
					$stars = '1halfstars';
				} elseif( $post->ratings > 1.5 && $post->ratings <= 2 ) {
					$stars = '2stars';
				} elseif( $post->ratings > 2 && $post->ratings <= 2.5 ) {
					$stars = '2halfstars';
				} elseif( $post->ratings > 2.5 && $post->ratings <= 3 ) {
					$stars = '3stars';
				} elseif( $post->ratings > 3 && $post->ratings <= 3.5 ) {
					$stars = '3halfstars';
				} elseif( $post->ratings > 3.5 && $post->ratings <= 4 ) {
					$stars = '4stars';
				} elseif( $post->ratings > 4 && $post->ratings <= 4.7 ) {
					$stars = '4halfstars';
				} elseif( $post->ratings > 4.7 && $post->ratings <= 5 ) {
					$stars = '5stars';
				}
				
				echo '		<tr>
								<td>			
									<p class="wps-seo-booster-top-rated-title"><strong><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a></strong></p>
								</td>
				
								<td width="90" class="wps-seo-booster-rating-td" align="center">
									<span class="wps-seo-booster-rating wps-seo-booster-stars_' . $stars . '">&nbsp;</span>
									<a href="' . get_permalink( $post->ID ) . '" class="wps-seo-booster-read">' . __( 'Read', 'wpsseo' ) . '</a>
								</td>
							</tr>';
			}
			
			echo '		</tbody>
					</table>
		
				</div>';
		
		echo $after_widget;
	}
	
	/**
	 * Updates the widget control options for the particular instance of the widget
	 */
	public function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		/* Set the instance to the new instance. */
		$instance = $new_instance;
		
		/* Input fields */
        $instance['title'] = strip_tags( $new_instance['title'] ); 
		$instance['limit'] = strip_tags( $new_instance['limit'] ); 
		$instance['category'] = strip_tags( $new_instance['category'] ); 

        return $instance;		
	}
	
	/*
	 * Displays the widget form in the admin panel
	 */
	public function form( $instance ) {
	
		$defaults = array( 'title' => '', 'limit' => '5', 'category' => '0' );
		
        $instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpsseo'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of Posts:', 'wpsseo' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $instance['limit']; ?>" />
		</p>	
		
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Filter by Category:', 'wpsseo' ); ?>
				<select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>">
					<option value="0" <?php if( $instance['category'] == '0' ) { echo ' selected="selected"'; } ?>><?php _e( 'Select', 'wpsseo' ); ?></option>
					<?php
						foreach( get_categories( array() ) as $category ) {
							echo '<option value="' . $category->term_id . '"';
							if( esc_attr( $instance['category'] ) == $category->term_id )
							echo ' selected="selected"';
							echo '>' . $category->name . '</option>';
						}
					?>
				</select>  
			</label>			 
		</p>
		
		<?php
	}
}
?>