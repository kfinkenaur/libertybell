<?php
/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists('CNHKSS_WIDGET')) {
    class CNHKSS_WIDGET extends WP_Widget
    {
        // Constructor
        public function CNHKSS_WIDGET()
        {
            $widget_ops = array('classname' => 'cnhk-ss-wdg', 'description'	=> __('Use this widget to add one slideshow to one of your sidebar.', CNHK_TEXTDOMAIN));		
            $control_ops = array('id_base' => 'cnhk-ss-wdg');		
            $this->WP_Widget('cnhk-ss-wdg', 'Cnhk Slideshow', $widget_ops, $control_ops);
        }
        
        // Display the slideshow
        public function widget($args, $instance) {
            extract($args);
            $title 		= apply_filters('widget_title', $instance['title']);
            $slideshow 	= $instance['slideshow'];
            
            echo $before_widget;
            if ($title) {
                echo $before_title . $title . $after_title;
            }
            
            if ('' != $slideshow) {
                cnhk_slideshow($slideshow);
            }
            echo $after_widget;
        }
        
        // The form displayed when setting up this widget in sidebars
        public function form($instance) {
            $defaults = array('title' => '', 'slideshow' => '');		
            $instance = wp_parse_args((array) $instance, $defaults);
            $options = get_option('cnhk_options');
            if (array() != $options['slideshows']) {
                $slug = $instance['slideshow'];
                echo '<p><label for="' . $this->get_field_id('title') . '">' . __('Title', CNHK_TEXTDOMAIN) . '</label>
                <input type="text" class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" /></p>';
                
                echo '<p><label for="' . $this->get_field_id('slideshow') . '">'. __('Slideshow to display', CNHK_TEXTDOMAIN) .'</label></p>';
                echo "<select name='" . $this->get_field_name('slideshow') . "' id='" .$this->get_field_id('slideshow') . "'>";
                echo '<option value="" ' . selected(!isset($options['slideshows'][$slug])) . '></option>';
                    foreach ($options['slideshows'] as $id => $value) {
                        $selected = ($slug == $id) ? ' selected="selected"' : '';
                        echo '<option value="' . $id . '"' . $selected . '>' . esc_html(stripslashes($options['slideshows'][$id]['name'])) . '</option>';
                    }
                echo "</select>";
            } else {
                echo '<p class="error">' . __('You need to create at least one slideshow', CNHK_TEXTDOMAIN) . '</p>';
            }
            
        }
        
        // Update values
        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] 		= strip_tags($new_instance['title']);
            $instance['slideshow'] 	= $new_instance['slideshow'];
            return $instance;
        }
    }
}
