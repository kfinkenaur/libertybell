<?php

class OurProfiles_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'ourprofiles_widget',
            __( 'Our Profiles Widget' ),
            array( 'description' => __( 'Display the links to profiles.' ) )
        );

        if ( is_active_widget( false, false, $this->id_base ) ) {
            add_action( 'wp_head', array( $this, 'ourprofiles_widget_css' ) );
        }
    }

    function ourprofiles_widget_css() {
?>

<style type="text/css">
    .our-profiles-widget-content {
        text-align: left;
    }
    .our-profiles-widget-image {
        margin-bottom: 5px;
    }
    .our-profiles-widget-image:last-child{
        margin-bottom: 0;
    }
    .our-profiles-widget-content a {
        text-decoration: none;
    }
    .our-profiles-widget-content img{
        box-shadow: 0 0 0;
    }
</style>

<?php
    }

    function form( $instance ) {
        if ( $instance ) {
            $title = esc_attr( $instance['title'] );
            $size = $instance['size'];
            $align = $instance['align'];
        }
        else {
            $title = __( 'Visit our profile' );
            $size = '100x50';
            $align = 'left';
        }
?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Images Size:' ); ?></label>
            <select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
                <option value="100x50"<?php selected( $size, '100x50' ); ?>>100x50</option>
                <option value="150x75"<?php selected( $size, '150x75' ); ?>>150x75</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e( 'Images Align:' ); ?></label>
            <select name="<?php echo $this->get_field_name('align'); ?>" id="<?php echo $this->get_field_id('align'); ?>" class="widefat">
                <option value="left"<?php selected( $align, 'left' ); ?>><?php _e('Left'); ?></option>
                <option value="center"<?php selected( $align, 'center' ); ?>><?php _e('Center'); ?></option>
                <option value="right"<?php selected( $align, 'right' ); ?>><?php _e( 'Right' ); ?></option>
            </select>
        </p>

<?php 
    }

    function update( $new_instance, $old_instance ) {
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['size'] = in_array($new_instance['size'], array('100x50', '150x75')) ? $new_instance['size'] : '100x50';
        $instance['align'] = in_array($new_instance['align'], array('left', 'center', 'right')) ? $new_instance['align'] : 'left';
        return $instance;
    }

    function widget( $args, $instance ) {
        global $ourprofiles_links, $ourprofiles_services, $ourprofiles_options;

        echo $args['before_widget'];
        if ( !empty( $instance['title'] ) ) {
            echo $args['before_title'];
            echo esc_html( $instance['title'] );
            echo $args['after_title'];
        }
        $images_size = '100x50';
        if ( !empty( $instance['size'] ) ) {
            $images_size = $instance['size'];
        }
        $content_align = 'left';
        if ( !empty( $instance['align'] ) ) {
            $content_align = $instance['align'];
        }
?>
        <div class="our-profiles-widget-content" style="text-align: <?php echo $content_align; ?>;">
<?php
        foreach ($ourprofiles_links as $service => $link) {
            $image = '';
            if (isset($ourprofiles_services[$service])){
                $image = OURPROFILES_HTTP_PATH . 'images/'.$images_size."/" . $ourprofiles_services[$service]['image'];
            }
            if (!empty($link) && !empty($image)){ ?>
                <div class="our-profiles-widget-image">
                    <a href="<?php echo $link; ?>" target="_blank" title="Visit our profile at <?php echo $service; ?>">
                        <img src="<?php echo $image; ?>" alt="Visit our profile at <?php echo $service; ?>" title="Visit our profile at <?php echo $service; ?>" >
                    </a>
                </div>
            <?php }
        }
?>
        </div>
<?php
        echo $args['after_widget'];
    }
}

function ourprofiles_register_widgets() {
    register_widget( 'OurProfiles_Widget' );
}

add_action( 'widgets_init', 'ourprofiles_register_widgets' );
