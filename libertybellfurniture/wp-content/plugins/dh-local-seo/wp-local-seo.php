<?php
/*
Plugin Name: Wordpress Local SEO
Plugin URI: http://www.digitaleheimat.de
Description: Boost the Local SEO rankings of your WordPress and optimize the display of your locations: Schema.org, GEO sitemap, Google Maps, infinite locations
Version: 2.3
Author: digitaleheimat GmbH
Author URI: http://www.digitaleheimat.de
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class WPLocalSeo {

    public $version;
    public $fields;
    public $defaults;
    public $ms_defaults;
    public $settings;
    public $ms_settingss;
    public $business_list;
    
    
    /**
     * __construct
     * Constructor. Sets variables for fields and default settings, adds basic action and filter hooks
     *
     * @since 1.0.
     *
     */ 
    function __construct () {
        
        $this->version = 2.3;
        
        
        $this->fields = (object) array(
                'business' => '_wpl_business',
                'name' => '_wpl_name',
                'logo' => '_wpl_logo',
                'streetAddress' => '_wpl_streetAddress',
                'postalCode' => '_wpl_postalCode',
                'addressLocality' => '_wpl_addressLocality',
                'latitude' => '_wpl_latitude',
                'longitude' => '_wpl_longitude',
                'telephone' => '_wpl_telephone',
                'faxNumber' => '_wpl_faxNumber',
                'email' => '_wpl_email',
                'url' => '_wpl_url',
                'openingHours' => '_wpl_openingHours',        
                'description' => '_wpl_description',
                //'locations' => '_wpl_locations',
         );
         
        $this->defaults = array(
                'adv_config' => false,   
                'gmaps_api_key' => '',     
                'default_business' => 'LocalBusiness',   
                'enable_type_of_business' => true,
                //'enable_location' => true,
                'enable_post_types' => array('post' => true, 'page' => true),
                'enable_location_content' => false,                                     
                'enable_telephone' => true,
                'enable_faxNumber' => true,
                'enable_email' => true,
                'enable_url' => true,
                'enable_description' => true,
                'enable_openingHours' => true,
                'map_size' => array('width' => '', 'height' => ''),      
                'logo_size' => array('width' => '200', 'height' => '', 'crop' => 'false'),      
                'disable_css' => false,      
                'custom_css' => '',      
                'set_the_content_filter' => true,        
                'set_the_content_filter_position' => 10,        
        );
        
        $this->ms_defaults = array(
            'default_blog' => '',
        );
        
        
        $this->ms_settings = (object) $this->ms_defaults;
        
        $this->settings = (object) $this->defaults;
        

         
        //general init
        add_action( 'init', array($this, 'init') );
        

        add_action( 'template_redirect', array( $this, 'template_redirect' )  );
        
        //add meta boxes
        add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );
        //backwards compatibility
        add_action( 'admin_init', array($this, 'add_meta_boxes'), 1 );
        
        //admin init
        add_action( 'admin_init', array($this, 'admin_init'), 1 );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 1 );
        
        //admin menu
        add_action( 'admin_menu', array($this, 'admin_menu'), 1 );
        
        //network admin menu
        add_action( 'network_admin_menu', array(&$this, 'network_admin_menu') );
                
        //save meta boxes
        add_action( 'save_post', array($this, 'save_meta_boxes') ); 

        //textdomain
        add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );  
        
        //add shortcode
        add_shortcode( 'wp_localseo', array($this, 'shortcode') );    
        
        //add shortcode
        add_shortcode( 'wp_localseo_map', array($this, 'shortcode_map') );   
        
    }

    /**
     * init
     * Initializes the Plugin: Loads settings, creates custom post type "location", enqueues scripts and styles
     *
     * @since 1.0.
     *
     */    
    function init() {
        
        //check version
        $this->check_update();
        
        
        if (get_site_option('wpl_ms'))
            $this->ms_settings = (object) get_site_option('wpl_ms');

            
        if (get_option('wp_localseo'))
            $this->settings = (object) get_option('wp_localseo');
        
        elseif ($this->ms_settings->default_blog)   
            $this->settings = (object) get_blog_option($this->ms_settings->default_blog, 'wp_localseo');

        if ($_POST['wpl_reset']) {
            // Secondly we need to check if the user intended to change this value.
            if ( ! (isset( $_POST['wp_localseo_nonce'] ) || ! wp_verify_nonce( $_POST['wp_localseo_nonce'], plugin_basename( __FILE__ ) ))  )
                return;

            //reset options
            $this->settings = ($this->ms_settings->default_blog) ? get_blog_option($this->ms_settings->default_blog, 'wp_localseo') : $this->defaults;
            update_option('wp_localseo', (array) $this->settings); 
            if (!$this->settings->adv_config)
                delete_option('wpl_adv_config');
           
            wp_redirect('options-general.php?page=wp-localseo-settings');
            //TODO delete all contents?
           
        }  

        include(plugin_dir_path(__FILE__).'inc/business_list.php');
        
        
        if ($this->settings->adv_config) {
            
            $supports = array('title','author');
            if ($this->settings->enable_location_content)
                $supports[] = 'editor';
            
            register_post_type( 'location',
                array(
                    'labels' => array(
                        'name' => __( 'Locations', 'wp_localseo'),
                        'singular_name' => __( 'Location', 'wp_localseo' )
                    ),
                'public' => true,
                'supports' => $supports,
                //'taxonomies' => array('category'),
                )
            );
            

            $args = array(
                'hierarchical'      => true,
                //'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                //'query_var'         => true,
                //'rewrite'           => array( 'slug' => 'location' ),
            );

            register_taxonomy( 'location_category', array( 'location' ), $args );  
         
            //check if advanced configuration was activated and locations need to be migrated
            
            //delete_option('wpl_adv_config');
            if (!get_option('wpl_adv_config')) {
                $this->migrate_locations();
                update_option('wpl_adv_config', true);
                add_action( 'admin_notices', array($this, 'admin_notice_adv_config') );   
                update_option('wpl_rewrite_rules', false);
            }
            
            
            //ad image size
            add_theme_support( 'post-thumbnails' ); 
            add_image_size( 'wpl_logo', $this->settings->logo_size['width'], $this->settings->logo_size['height'], $this->settings->logo_size['crop'] );
            
        }
        
        //rewrite rules
        $this->add_rewrite_rules();
        
        //scripts
        
        wp_register_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key='.$this->settings->gmaps_api_key.'&sensor=false',null,null,true);
        //wp_enqueue_script('markercluster', plugins_url('js/markerclusterer_compiled.js', __FILE__), array('gmaps'));
        wp_register_script('wp-localseo', plugins_url('js/wp-localseo.js', __FILE__), array('jquery', 'jquery-ui-autocomplete'),null,true);
        wp_register_script('wp-localseo-admin', plugins_url('js/wp-localseo-admin.js', __FILE__), array('wp-localseo'),null,true);
        
      
        
        
        //styles
        if (!$this->settings->disable_css)
            wp_enqueue_style('wp-localseo',plugins_url('css/wp-local-seo.css', __FILE__));
        
        add_action('wp_head', array($this, 'get_custom_css'));

        
        $strings['select_image'] = __('Select Logo', 'wp_localseo'); 
        
        wp_localize_script( 'wp-localseo', 'wpl_lang', $strings );
        
        //ajax calls
        add_action('wp_ajax_wpl_get_location_list', array($this, 'ajax_get_location_list'));
        add_action('wp_ajax_nopriv_wpl_get_location_list', array($this, 'ajax_get_location_list'));
        add_action('wp_ajax_wpl_get_location', array($this, 'ajax_get_location'));
        add_action('wp_ajax_get_wpl_logo_url', array($this, 'ajax_get_wpl_logo_url'));
        
        $this->localize_script();        
        
        if($this->settings->set_the_content_filter) {
            $filter_position =  $this->settings->set_the_content_filter_position;
            if ((int)$filter_position == 0) //save cast
                $filter_position = 10; 
            add_filter( 'the_content', array($this, 'the_content'), $filter_position );          
        }
    }
    
    /**
     * enqueue_scripts
     * Enqueues Scripts only if needed
     *
     * @since 2.3.
     *
     */     
    function enqueue_scripts($admin = false) {
        if(!$this->settings->exclude_gmaps) wp_enqueue_script('gmaps');    
        wp_enqueue_script('wp-localseo');    
        if($admin) wp_enqueue_script('wp-localseo-admin');    
    }    
    /**
     * admin_enqueue_scripts
     * Enqueues Scripts only needed for Admin
     *
     * @since 2.0.
     *
     */     
    function admin_enqueue_scripts() {
        wp_enqueue_media();    
    }
    

    /**
     * check_update
     * Checks for update and does update if necessary
     *
     * @since 1.1.
     *
     */        
    function check_update() {
        global $wpdb;
        //check if its a fresh install
        if(!$old_version = get_option('wpl_version')) {
            update_option('wpl_version', $this->version);  
            add_action( 'admin_notices', array($this, 'admin_notice_install') );             
            return;
        }
       
        if ($old_version < 1.1) {
            
            //update settings
            if ($old_option = get_option('dh_localseo')) {
                add_option('wp_localseo', $old_option);
                delete_option('dh_localseo');
                delete_option('dhl_rewrite_rules');
            }
            
            //update all custom fields for all posts
            foreach ($this->fields as $k => $v) {
                $query = "UPDATE $wpdb->postmeta SET `meta_key` = '$v'  WHERE `meta_key` LIKE '_dhl_$k'";  
                $wpdb->query($query);
            }
            
            //update shortcodes in all post content fields
            $query = "UPDATE $wpdb->posts SET `post_content` = REPLACE (post_content, '[dh_localseo]', '[wp_localseo]')";  
            $wpdb->query($query);
            
            
            add_action( 'admin_notices', array($this, 'admin_notice_update_11') );   
            update_option('wpl_version', $this->version);            
            
        }
        
        
        if ($old_version < 2.0) {
            
            if ($old_option = get_option('wp_localseo')) {
                // add default_business to options
                $old_option['default_business'] = "LocalBusiness";
                $old_option['enable_type_of_business'] = true;
                
                //check if advanced_config has to be activated
                if ($old_option['enable_location']) {
                    $old_option['adv_config'] = true;
                }
                
                update_option('wp_localseo', $old_option);
            }
            
            add_action( 'admin_notices', array($this, 'admin_notice_update_20') );   
            update_option('wpl_version', $this->version);   
        
        }
        
        if ($old_version < 2.2) {
            
            if ($old_option = get_option('wp_localseo')) {
                
                $old_option['map_size'] = array('width' => '', 'height' => '');
                $old_option['logo_size'] = array('width' => '200', 'height' => '', 'crop' => 'false');
                $old_option['disable_css'] = false;
                $old_option['custom_css'] = '';

                update_option('wp_localseo', $old_option);
            }                    
          
            add_action( 'admin_notices', array($this, 'admin_notice_update_22') );   
            update_option('wpl_version', $this->version);            
        } 
        
        if ($old_version < 2.3) {
            
            if ($old_option = get_option('wp_localseo')) {
                $old_option['enable_location_content'] = false;

                update_option('wp_localseo', $old_option);
            }                    
          
            add_action( 'admin_notices', array($this, 'admin_notice_update_23') );   
            update_option('wpl_version', $this->version);            
        }              
        

       
    }
    
    /**
     * migrate_locations
     * migrates locations if necessary
     *
     * @since 2.
     *
     */        
    function migrate_locations() {    
    
        
        $posts = get_posts(array(
            'post_type' => $this->get_enabled_post_types(),
            'posts_per_page' => -1,
        ));
        foreach ($posts as $cpost) {
            $check = false;
                        
            foreach ($this->fields as $field)
                if (get_post_meta($cpost->ID, $field, true))
                    $check = true;
            
            if (!$check)
                continue; 
            
            //first save locations that are already in
            if ($locations = $_POST['_wpl_locations']) {
                foreach ($locations as $key => $value) {
                    if ($_POST['_wpl_locations_delete'][$key]) {
                        unset($locations[$key]);
                    }
                }
                 
            }
                        
                
            //create new location post
            $location = array(
              'post_title'    => get_post_meta($cpost->ID, '_wpl_name', true),
              'post_status'   => 'publish',
              'post_type' => 'location',
            );
            
            $location_id = wp_insert_post( $location ); 
            $locations[] = $location_id;
            
            
            //now fill the meta fields
            foreach ($this->fields as $field => $name) {
               
                if ($field == "openingHours") {
                    $openingHours = get_post_meta($cpost->ID, $name, true);
                    if (!empty($openingHours)) {
                        ksort($openingHours);
                        foreach ($openingHours as $k => $v) {
                            usort($v, array('WPLocalSeo', 'cmp_time'));
                            $openingHours[$k] = $v;
                        }
                    }
                }  
                update_post_meta( $location_id, $name, get_post_meta($cpost->ID, $name, true));
            } 
        
            update_post_meta( $cpost->ID, '_wpl_locations', $locations);              
            
                
        }
    
    }
    
    
    /**
     * load_plugin_textdomain
     * Loads textdomain
     *
     * @since 1.0.
     *
     */     
    function load_plugin_textdomain() {
      load_plugin_textdomain( 'wp_localseo', false, dirname( plugin_basename( __FILE__ ) )  . '/languages/' ); 
    }
    
    /**
     * template_redirect
     * redirects to sitemap / kml generator
     *
     * @since 1.0.
     *
     */ 
	function template_redirect() {
        if (get_query_var( 'wpl_sitemap' ))
            $this->create_sitemap();        
        if (get_query_var( 'kml' ))
            $this->create_kml();
    }    

    /**
     * options_page
     * creates the settings page
     *
     * @since 1.0.
     *
     */

    function options_page() {
        
    
?>
<div class="wrap">
<?php if ($_GET['reset']): ?>
    <form method="post" action="options-general.php?page=wp-localseo-settings&settings-updated=true">
        <?php wp_nonce_field( plugin_basename( __FILE__ ), 'wp_localseo_nonce' ); ?>
        <p><?php _e('<strong>Are you sure you want to reset the plugin settings?</strong>', 'wp_localseo'); ?></p>
        <?php /* <p><?php _e('This action will both reset the settings and delete all location contents.', 'wp_localseo'); ?></p> */ ?>
        <p><?php _e('Created location content will not be deleted. <br/>If advanced features will be deactivated through the reset, the location posts will not be avaiable, while advanced features stay deactivated.', 'wp_localseo'); ?></p>
        <input type="submit" name="wpl_reset" class="button-primary" value="<?php _e('Reset Plugin', 'wp_localseo'); ?>" />
        <a href="options-general.php?page=wp-localseo-settings"><input type="button"  class="button-secondary" value="<?php _e('Back', 'wp_localseo'); ?>" /></a>        
        
    </form>
<?php else: ?>
   <form method="post" action="options.php">
   <h2><?php _e('WP Local SEO settings', 'wp_localseo'); ?></h2>
            <?php settings_fields( 'wp_localseo_settings' ); ?>
            <?php do_settings_sections( 'wp-localseo-settings' ); ?>
            <?php submit_button(); ?>
    </form>
    <a href="options-general.php?page=wp-localseo-settings&reset=true"><input type="button"  class="button-secondary" value="<?php _e('Reset Plugin', 'wp_localseo'); ?>" /></a>        
<?php endif; ?>    
<?php    

    }
    
    /**
     * admin_init 
     * inits the plugin in admin interface
     * @since 1.0.
     *
     */

     
    function admin_init() {
        global $pagenow;
        //init settings for settings page
            
        //registers the settings
        register_setting( 'wp_localseo_settings', 'wp_localseo' );
         
        
        add_option('wp_localseo', (array) $this->settings);
        add_settings_section('advanced_config', __('Advanced features', 'wp_localseo'), null, 'wp-localseo-settings');
        add_settings_section('maps_settings', __('Google Maps settings', 'wp_localseo'), null, 'wp-localseo-settings');
        add_settings_section('post_type_settings', __('Post type settings', 'wp_localseo'), null, 'wp-localseo-settings');
        add_settings_section('additional_settings', __('Enable additional fields', 'wp_localseo'), array($this,'additional_settings'), 'wp-localseo-settings');
        add_settings_section('layout_settings', __('Layout settings', 'wp_localseo'), null, 'wp-localseo-settings');
        add_settings_section('template_settings', __('Template settings', 'wp_localseo'), array($this,'template_settings'), 'wp-localseo-settings');
        add_settings_section('sitemap_settings', __('GEO sitemap settings', 'wp_localseo'), array($this,'sitemap_settings'), 'wp-localseo-settings');
        

        add_settings_field('enable-adv-conf', __('Enable advanced features', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'advanced_config', array('name' => 'wp_localseo[adv_config]', 'value' => $this->settings->adv_config, 'disabled' => $this->settings->adv_config, 'help' =>  
        
        __('- Location information will be saved as a custom post type and multiple instances can be added to other posts', 'wp_localseo') . '<br/>' .
        __('- Locations can be categorized', 'wp_localseo') . '<br/>' .
        __('- Enables a Google Map that shows all locations via shortcode <code>[wp_localseo_map width=100% height=350px]*</code> ot function call <code>$wp_localseo->show_location_map($width="100%", $height="350px");*</code> | *the default values can be overridden', 'wp_localseo') . '<br/>' .
        '<br/>' . __('<strong>Note:</strong><br/> All existing entries will be mapped on the post type. <br/> This cannot be undone without resetting the plugin.', 'wp_localseo')));
        
        add_settings_field('gmaps-api-key', __('Google Maps API Key', 'wp_localseo'), array($this, 'input_text'), 'wp-localseo-settings', 'maps_settings', array('name' => 'wp_localseo[gmaps_api_key]', 'value' => $this->settings->gmaps_api_key, 'help' => __('An API console key is recommended and provided by <a href="https://developers.google.com/maps/documentation/javascript/tutorial?hl=en#api_key" target="_blank">Google</a>.', 'wp_localseo')));
        
        //add_settings_field('enable-location', __('Enable "Location" as post type', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'post_type_settings', array('name' => 'wp_localseo[enable_location]', 'value' => $this->settings->enable_location, 'help' => __('enables a simple post type "Location" with only location information.', 'wp_localseo')));        
        
        // get other existing post_types
        
        $pt1 = get_post_types(array('public' =>true, 'show_ui' => true), 'array');
        $pt2 = get_post_types(array('public' =>false, 'show_ui' => true), 'array');
        $post_types = array_merge($pt1,$pt2);
        foreach ($post_types as $type) {
            if ($type->name == 'location' || $type->name == 'attachment')
                continue;
            add_settings_field('enable-post-types-'.$type->name, sprintf(__('Enable for post type "%s"', 'wp_localseo'), $type->labels->name), array($this, 'input_checkbox'), 'wp-localseo-settings', 'post_type_settings', array('name' => 'wp_localseo[enable_post_types]['.$type->name.']', 'value' => $this->settings->enable_post_types[$type->name], 'help' => sprintf(__('Shows location information fields for post type "%s"', 'wp_localseo'), $type->labels->name)));                
        }
        
        
        
        add_settings_field('default-business', __('Default type of location', 'wp_localseo'), array($this, 'select_business'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[default_business]', 'value' => $this->settings->default_business, 'help' => __('Sets the default Schema.org type of location.', 'wp_localseo')));
        add_settings_field('enable-type-of-business', __('Type of location', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_type_of_business]', 'value' => $this->settings->enable_type_of_business, 'help' => __('Enables a select field to override default business', 'wp_localseo')));
        if ($this->settings->adv_config)
            add_settings_field('enable-location-content', __('Content', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_location_content]', 'value' => $this->settings->enable_location_content, 'help' => __('Enables the post content with wordpress editor', 'wp_localseo')));
        add_settings_field('enable-telephone', __('Phone', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_telephone]', 'value' => $this->settings->enable_telephone, 'help' => __('Enables a text field to enter the phone number', 'wp_localseo')));
        add_settings_field('enable-faxNumber', __('Fax', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_faxNumber]', 'value' => $this->settings->enable_faxNumber, 'help' => __('Enables a text field to enter the fax number', 'wp_localseo')));
        add_settings_field('enable-email', __('Email address', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_email]', 'value' => $this->settings->enable_email, 'help' => __('Enables a text field to enter the email address; <code>mailto:</code> link in default template', 'wp_localseo')));
        add_settings_field('enable-url', __('Website', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_url]', 'value' => $this->settings->enable_url, 'help' => __('Enables a text field to enter the website; linked in default template', 'wp_localseo')));
        add_settings_field('enable-description', __('Description', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_description]', 'value' => $this->settings->enable_description, 'help' => __('Enables a textarea to enter a description with html allowed and automatic linebreaks', 'wp_localseo')));
        add_settings_field('enable-openingHours', __('Opening hours', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'additional_settings', array('name' => 'wp_localseo[enable_openingHours]', 'value' => $this->settings->enable_openingHours, 'help' => __('Enables a dynamic fieldset to enter various opening hours; autosort by weekday and time', 'wp_localseo')));

        $fields[] = array('type' => 'text', 'name' => 'wp_localseo[map_size][width]', 'label' => __('Width: ', 'wp_localseo'), 'value' => $this->settings->map_size['width']); 
        $fields[] = array('type' => 'text', 'name' => 'wp_localseo[map_size][height]', 'label' => __('Height: ', 'wp_localseo'), 'value' => $this->settings->map_size['height']); 
        add_settings_field('map-size', __('Custom map size', 'wp_localseo'), array($this, 'input_multiple'), 'wp-localseo-settings', 'layout_settings', array('fields' => $fields, 'help' => __('Set a custom size for the location map<br/><strong>Possible values: </strong>numeric values, ex.: 200, 200px, 100%<br/><strong>Note:</strong> Overrides other CSS styles', 'wp_localseo')));
        
        $fields = array();
        $fields[] = array('type' => 'text', 'name' => 'wp_localseo[logo_size][width]', 'label' => __('Width: ', 'wp_localseo'), 'value' => $this->settings->logo_size['width']); 
        $fields[] = array('type' => 'text', 'name' => 'wp_localseo[logo_size][height]', 'label' => __('Height: ', 'wp_localseo'), 'value' => $this->settings->logo_size['height']); 
        $fields[] = array('type' => 'checkbox', 'name' => 'wp_localseo[logo_size][crop]', 'label' => __('Crop: ', 'wp_localseo'), 'value' => $this->settings->logo_size['crop']); 
        add_settings_field('logo-size', __('Logo size', 'wp_localseo'), array($this, 'input_multiple'), 'wp-localseo-settings', 'layout_settings', array('fields' => $fields, 'help' => __('Set a size for uploaded logos<br/><strong>Possible values:</strong> size in pixels without unit, ex.: 200 | <strong>Crop:</strong> crops image to the exact dimenesions<br/><strong>Note:</strong> Image resizing only applies for new images', 'wp_localseo')));
        
        add_settings_field('disable-css', __('Disable default CSS styles', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'layout_settings', array('name' => 'wp_localseo[disable_css]', 'value' => $this->settings->disable_css));
        add_settings_field('custom-css', __('Add custom CSS styles', 'wp_localseo'), array($this, 'input_textarea'), 'wp-localseo-settings', 'layout_settings', array('name' => 'wp_localseo[custom_css]', 'value' => $this->settings->custom_css, 'help' => __('<strong>Note:</strong> Please be aware that wrong formatting can break your layout. Alternatively you can also add custom css code directly in your theme css', 'wp_localseo')));
        
        
        add_settings_field('set-the_content-filter', __('Append template automatically', 'wp_localseo'), array($this, 'input_checkbox'), 'wp-localseo-settings', 'template_settings', array('name' => 'wp_localseo[set_the_content_filter]', 'value' => $this->settings->set_the_content_filter, 'help' => __('Automatically appends location information template to post content through <code>the_content</code> filter', 'wp_localseo')));
        add_settings_field('set-the_content-filter-position', __('Position in filter herarchy', 'wp_localseo'), array($this, 'input_text'), 'wp-localseo-settings', 'template_settings', array('name' => 'wp_localseo[set_the_content_filter_position]', 'value' => $this->settings->set_the_content_filter_position, 'help' => __('Adjusts, when within the filter the template is loaded; <strong>Note:</strong> Only necessary for ordering when several filters are active. Default: <code>10</code> ', 'wp_localseo')));
        
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery');
        
        wp_enqueue_style('thickbox');
        
    } 
    
    /**
     * network_options_page
     * creates the network settings page
     *
     * @since 1.0.
     *
     */

    function network_options_page() {   
        global $wpdb;
        if ($_POST['wpl_ms_save']) {
            $errormsg = "";
            if ($_POST['wpl_ms']['default_blog'] && !$wpdb->get_var('select blog_id from '.$wpdb->blogs.' WHERE blog_id = '.(int)$_POST['wpl_ms']['default_blog']))
                $errormsg .= '<p>'.__('Please enter an existing Blog ID.', 'wp_localseo').'</p>';
            
            if ($errormsg != "") {
                $this->ms_settings = (object) $_POST['wpl_ms'];
                print '<div class="message error">'.$errormsg.'</div>';
            } else {
                update_site_option('wpl_ms', $_POST['wpl_ms']);
                $this->ms_settings = (object) get_site_option('wpl_ms');
                 print '<div class="updated"><p>'.__('Settings were successfully updated.', 'wp_localseo').'</p></div>';
            }
            
        }


        if ($_POST['wpl_ms_reset']) {
            $errormsg = "";
                    
            if($_POST['wpl_reset_all'])
                $blog_ids = $wpdb->get_results('select blog_id from '.$wpdb->blogs.' WHERE blog_id NOT IN ('.$this->ms_settings->default_blog.')');
            
            elseif (!$blog_ids = $wpdb->get_results('select blog_id from '.$wpdb->blogs.' WHERE blog_id IN ('.$_POST['wpl_reset_id'].')'))
                $errormsg .= '<p>'.__('Please enter at least one existing Blog ID.', 'wp_localseo').'</p>';
            
            if ($errormsg != "") {
                $wpl_reset_id = $_POST['wpl_reset_id'];
                print '<div class="message error">'.$errormsg.'</div>';
            } else {
                $msg = "";

                foreach($blog_ids as $blog_id) {
                    $blog_id = $blog_id->blog_id;
                    $old_settings = get_blog_option($blog_id, 'wp_localseo');
                    $resetted_settings = ($this->ms_settings->default_blog) ? get_blog_option($this->ms_settings->default_blog, 'wp_localseo') : $this->defaults;
                    
                    //see if advanced configuration needs to stay enabled
                    $note = "";
                    if ($old_settings['adv_config'] && !$resetted_settings['adv_config']) {
                        $resetted_settings['adv_config'] = 1;
                        $note = __(' | <strong>Note:</strong> Advanced configuration was left activated.', 'wp_localseo');
                    }
                    update_blog_option($blog_id, 'wp_localseo', $resetted_settings);
                    if ($msg) $msg .= "<br/>";
                    $msg .= sprintf(__('Settings for Blog ID %d were successfully resetted.', 'wp_localseo').$note, $blog_id);
                    
                }
                    print '<div class="updated"><p>'.$msg.'</p></div>';
            }
            
        }
        
        
        ?>
        <div class="wrap">
            <form method="post">
                <h2><?php _e('WP Local SEO settings', 'wp_localseo'); ?></h2>    
                <table class="form-table">
                    <tr>
                        <th><label for="wpl_ms[default_blog]"><?php _e('Default Blog (ID): ', 'wp_localseo'); ?></label></th>
                        <td>
                            <input type="text" name="wpl_ms[default_blog]" value="<?php print $this->ms_settings->default_blog ?>"/>
                            <span class="howto"><?php _e('Enter the Blog ID for the site whose settings you want to use as default for all sites that are added to your network. Leave empty for using the plugins default settings.', 'wp_localseo'); ?></span>
                        </td>
                    </tr>
                </table>
                <p><input type="submit" name="wpl_ms_save" class="button-primary" value="<?php _e('Save network settings', 'wp_localseo'); ?>" /></p>
                
                <table class="form-table">
                    <tr>
                        <th><label for="wpl_reset_id"><?php _e('Reset Blogs (IDs): ', 'wp_localseo'); ?></label></th>
                        <td>
                            <input type="text" name="wpl_reset_id" value="<?php $wpl_reset_id; ?>"/>
                            <span class="howto"><?php _e('Reset the settings of these Blogs. Seperate several Blog IDs with comma: 1,2,3', 'wp_localseo'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="checkbox" name="wpl_reset_all" value="1"/> <label for="wpl_reset_all"><?php _e('Reset all blogs', 'wp_localseo'); ?>
                            <span class="howto"><?php _e('Reset the settings of all Blogs.', 'wp_localseo'); ?></span>
                        </td>
                    </tr>            
                </table>
                <p><input type="submit" name="wpl_ms_reset" class="button-primary" value="<?php _e('Reset settings', 'wp_localseo'); ?>" /></p>
                
            </form>
        </div>
        <?php
    
    }
    
    /**
     * admin_menu 
     * adds admin menu page
     *
     * @since 1.0.
     *
     */

    function admin_menu() {
        add_options_page(__('WP Local Seo'), __('WP Local Seo'), 'manage_options', 'wp-localseo-settings', array($this, 'options_page'));   
    }

    /**
     * network_admin_menu 
     * adds network admin menu page
     *
     * @since 1.0.
     *
     */    
    function network_admin_menu() {
		add_menu_page(__('WP Local Seo'), __('WP Local Seo'), 'delete_users', 'wp-localseo-network-settings', array(&$this,'network_options_page'));
	}
    
    /**
     * input_text 
     * template for text input fields
     *
     * @since 1.0.
     *
     */
   
    function input_text($args) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $help = html_entity_decode(esc_attr( $args['help'] ));     
        echo "<input type='text' name='$name' value='$value' class='regular-text' />";
        if ($help)
            echo "<span class='howto'>$help</span>";
    }
    
    /**
     * input_textarea
     * template for textarea fields
     *
     * @since 2.2.
     *
     */
   
    function input_textarea($args) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $help = html_entity_decode(esc_attr( $args['help'] ));     
        echo "<textarea name='$name' class='large-text' rows=10>$value</textarea>";
        if ($help)
            echo "<span class='howto'>$help</span>";
    }

    
    /**
     * input_checkbox 
     * template for checkbox input fields
     *
     * @since 1.0.
     *
     */
       
    function input_checkbox($args) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $help = html_entity_decode(esc_attr( $args['help'] ));        
        $disabled = ($args['disabled']) ? "disabled='disabled' " : '';        
        $checked = ($value) ? "checked='checked' " : '';
        echo "<input type='checkbox' name='$name' value='true' $checked$disabled/>";
        if ($disabled)
            echo "<input type='hidden' name='$name' value='".$args['value']."'/>";
        if ($help)
            echo "<span class='howto'>{$help}</span>";
       
    }    
    
     /**
     * select_business 
     * template for checkbox input fields
     *
     * @since 2.0.
     *
     */
       
    function select_business($args) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $help = html_entity_decode(esc_attr( $args['help'] ));
        echo $this->get_business_list($name, $value);
        if ($help)
            echo "<span class='howto'>{$help}</span>";        
    } 
    
     /**
     * input_multiple
     * multiple input fields
     *
     * @since 2.2.
     *
     */    
    function input_multiple($args) {
        $fields =$args['fields'];
        $help = html_entity_decode(esc_attr( $args['help'] ));        
        foreach ($fields as $k => $field) {
            if ($k > 0) print " | ";
            echo '<label for='.$field['name'].'>'.$field['label'].'</label>';
            switch ($field['type']) {
                case 'text':
                    echo ' <input type="text" name="'.$field['name'].'" value="'.$field['value'].'" class="small-text" />';
                    break;
                case 'checkbox':
                    $checked = ($field['value']) ? "checked='checked' " : '';
                    echo ' <input type="checkbox" name="'.$field['name'].'" value="true" '.$checked.'/>';
                    break;                    
            }
        }
        if ($help)
            echo "<span class='howto'>{$help}</span>";
       
    }     
  
    /**
     * additional_settings 
     * head info for additional settings
     *
     * @since 1.0.
     *
     */
       
    function additional_settings () {
           
?>
        <p><?php _e('The plugin supports, next to the default address fields, additional SEO relevant fields.', 'wp_localseo') ?></p>
        <p><?php _e('<strong>Note:</strong> The Schema.org notation is implemented in the default template and can be overridden through a custom template (see below).', 'wp_localseo') ?></p>
<?php    
    }

  
    /**
     * sitemap_settings 
     * head info for sitemap settings
     *
     * @since 1.0.
     *
     */    
    function sitemap_settings () {
        global $blog_id;
        $sitemap_url = home_url('geo_sitemap.xml');
       
?>
        <p><?php _e('The plugin automatically creates a sitemap with geo information that can ie. be submitted to Google Webmasters:', 'wp_localseo') ?> <a href="<?php echo $sitemap_url?>" target="_blank"><?php echo $sitemap_url?></a></p>
        <p><?php printf(__('<strong>Note:</strong> If the sitemap is not avaiable you might have to <a href="%s">flush the rewrite rules</a>.', 'wp_localseo'), get_admin_url($blog_id,'options-general.php?page=wp-localseo-settings&flush_rewrite_rules=1')); ?></p>
<?php      
    }
   
   
    /**
     * template_settings 
     * head info for template settings
     *
     * @since 1.0.
     *
     */    
    function template_settings () {
        
        
        $template_info = '<strong>'.__('Location Template', 'wp_localseo').'</strong><br/>';
        if (!file_exists($template_path = get_stylesheet_directory().'/location-template.php')) {
            $template_path = plugin_dir_path(__FILE__).'location-template.php';
            $template_info .= sprintf(__('You are currently using the default template for displaying the location information. You can override the template in your theme folder. Just copy the default template from <code>%s</code>.', 'wp_localseo'), $template_path);
        } else
            $template_info .= sprintf(__('You are currently using a custom template for displaying the location information. To use the default, just delete the custom template from <code>%s</code>', 'wp_localseo'), $template_path);
        
        $template_info .= '<br/><br/><strong>'.__('Location Template "Mini" (Google Map Infobox)', 'wp_localseo').'</strong><br/>';
        if (!file_exists($template_path = get_stylesheet_directory().'location-template-mini.php')) {
            $template_path = plugin_dir_path(__FILE__).'location-template-mini.php';
            $template_info .= sprintf(__('You are currently using the default template for displaying the location information. You can override the template in your theme folder. Just copy the default template from <code>%s</code>.', 'wp_localseo'), $template_path);
        } else
            $template_info .= sprintf(__('You are currently using a custom template for displaying the location information. To use the default, just delete the custom template from <code>%s</code>', 'wp_localseo'), $template_path);
                
        
?>
        <p><?php echo $template_info ?></p>
        <p><?php _e('The plugin can append the template automatically using <code>the_content</code> filter. You can also add the template to your theme manually using the function <code>print $wp_localseo->show_locations($post_id)</code> or insert it directly into the post content using the shortcode <code>[wp_localseo id=POST_ID]</code>. If no post id is set, the global variable <code>$post->ID</code> will be used.', 'wp_localseo') ?></p>
<?php
        
    }    
    
    /**
     * add_meta_boxes
     * Adds the Location information meta boxes to all activated post types
     *
     * @since 1.0.
     *
     */

    function add_meta_boxes() {     
        
        $screens = $this->get_enabled_post_types();
        
        if ($this->settings->adv_config) {
            if(!empty($screens)) foreach ($screens as $screen) {
                
                if ($screen == 'location')add_meta_box(
                    'wp_localseo-meta-box',
                    __( 'Location information', 'wp_localseo' ),
                    array($this, 'location_meta_box'),
                    $screen
                ); 
                else add_meta_box(
                    'wp_localseo-meta-box',
                    __( 'Location information', 'wp_localseo' ),
                    array($this, 'advanced_meta_box'),
                    $screen
                );
            }        
        } else {
            if(!empty($screens)) foreach ($screens as $screen) {
                add_meta_box(
                    'wp_localseo-meta-box',
                    __( 'Location information', 'wp_localseo' ),
                    array($this, 'location_meta_box'),
                    $screen
                );
            }
        }
    }

  
    /**
     * location_meta_box
     * Shows location meta box form
     *
     * @since 1.0.
     *
     */
     
    function location_meta_box () {
        global $post;
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'wp_localseo_nonce' );

        // The actual fields for data entry
        // Use get_post_meta to retrieve an existing value from the database and use the value for the form
      
        $meta = (object) array();
      
        foreach ($this->fields as $field => $name) {           
            $meta->$field = get_post_meta( $post->ID, $name, true);
        }
        
        $this->show_location_form($meta);

    }
    
    
    /**
     * advanced_meta_box
     * Shows location meta box form
     *
     * @since 2.0.
     *
     */
     
    function advanced_meta_box () {
        global $post;
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'wp_localseo_nonce' );
        
        $meta = (object) array();
        $meta->locations = get_post_meta( $post->ID, '_wpl_locations', true );
        ?>
        <div id="wpl_locations_admin"> 
        <?php
        if ($meta->locations) foreach ($meta->locations as $location_id) {
            if (get_post_status($location_id) == 'trash') {
                print '<div class="not_avaiable">'.sprintf(__('The requested location "%s" is in the trash and not avaiable.<br/>It will be unlinked from this post with the next save.', 'wp_localseo'), get_the_title($location_id) ).'</div>';
            } else {
                if (get_post_status($location_id) != 'publish')
                    print '<div class="not_avaiable">'.__('This location is not published and will not be shown on the website.', 'wp_localseo').'</div>';
                print $this->show_location_template($location_id, false, true);
            }
        }
        ?>
        </div>
        <h2><?php _e('Add location', 'wp_localseo') ?></h2>
        <?php
        
        /*foreach ($this->fields as $field => $name) {           
            $meta->$field = get_post_meta( $post->ID, $name, true);
        }  */    
        
        $this->show_location_form($meta, true);

    }

    /**
     * save_meta_boxes
     * saves meta box inputs
     *
     * @since 1.0.
     *
     */
     
    function save_meta_boxes( $post_id ) {
        global $current_user;

        // First we need to check if the current user is authorised to do this action. 
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) )
                return;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
        }

        // Secondly we need to check if the user intended to change this value.
        if ( ! (isset( $_POST['wp_localseo_nonce'] ) || ! wp_verify_nonce( $_POST['wp_localseo_nonce'], plugin_basename( __FILE__ ) ))  )
            return;

            
        // Thirdly we can save the value to the database

        //if saving in a custom table, get post_id
        $post_id = $_POST['post_ID'];
        
        if ($_POST['post_type'] == 'location' || !$this->settings->adv_config) {
            foreach ($this->fields as $field => $name) {
            
                if ($field == "openingHours") {
                    if (!empty($_POST[$name])) {
                        ksort($_POST[$name]);
                        foreach ($_POST[$name] as $k => $v) {
                            usort($v, array('WPLocalSeo', 'cmp_time'));
                            $_POST[$name][$k] = $v;
                        }
                    }
                }
                update_post_meta( $post_id, $name, $_POST[$name]);
            }
            
        } else {
            //first save locations that are already in
            
            if ($locations = $_POST['_wpl_locations']) {
                foreach ($locations as $key => $value) {
                    if ($_POST['_wpl_locations_delete'][$key]) {
                        unset($locations[$key]);
                    }
                }
                 
            }
                        
            //now see if there is a new location to create
            if ($_POST['_wpl_name']) {
                
                //create new location post
                $location = array(
                  'post_title'    => $_POST['_wpl_name'],
                  'post_status'   => 'publish',
                  'post_type' => 'location',
                  'tax_input' => $_REQUEST['tax_input'],
                );
                
                // Insert the post into the database, we need to remove the action, else there will be a recursive disaster
                remove_action( 'save_post', array($this, 'save_meta_boxes') ); 
                $location_id = wp_insert_post( $location ); 
                $locations[] = $location_id;
                

                //now fill the meta fields
                
                
                foreach ($this->fields as $field => $name) {
                   
                    if ($field == "openingHours") {
                        if (!empty($_POST[$name])) {
                            ksort($_POST[$name]);
                            foreach ($_POST[$name] as $k => $v) {
                                usort($v, array('WPLocalSeo', 'cmp_time'));
                                $_POST[$name][$k] = $v;
                            }
                        }
                    }  
                    update_post_meta( $location_id, $name, $_POST[$name]);
                } 
        
            }
            update_post_meta( $post_id, '_wpl_locations', $locations);                
        }    
    }
    
    /**
     * show_location_form
     * shows the location input form
     *
     * @since 2.0.
     *
     */    
    function show_location_form ($meta, $advanced = false) {
    
        $this->enqueue_scripts(true);
    
    
?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="_wpl_name"><?php _e('Name', 'wp_localseo');?></label></th>
                <td><input type="text" id="wpl_name" name="_wpl_name" value="<?php print $meta->name  ?>" class="regular-text <?php if($advanced) print "ui-autocomplete-input" ?>" <?php if($advanced) print "autocomplete=\"off\"" ?>/><br/>
                <span class="howto"><?php _e('Name of the location', 'wp_localseo');?></span></td>
            </tr> 
            <?php if($this->settings->enable_type_of_business): ?>
            <tr valign="top">
                <th scope="row"><label for="_wpl_business"><?php _e('Type of location', 'wp_localseo');?></label></th>
                <td><?php print $this->get_business_list('_wpl_business', ($meta->business) ? $meta->business : $this->settings->default_business); ?>
                <span class="howto"><?php _e('Select a Schema.org valid location type', 'wp_localseo');?></span></td>
            </tr>
            <?php endif; ?>
           
            <?php if($advanced): ?>
            <tr valign="top">
                <th scope="row"><label for="_wpl_name"><?php _e('Categories', 'wp_localseo');?></label></th>
                <td><ul id="location_categorychecklist" class="location_categorychecklist categorychecklist">
                    <?php print wp_terms_checklist( null, array( //'selected_cats'         => true,
                                                            //popular_cats'          => true,
                                                            'taxonomy' => 'location_category') ); ?></ul></td>
            </tr>   
            <?php endif; ?>            
            
            <tr valign="top">
                <th scope="row"><label for="_wpl_logo"><?php _e('Logo', 'wp_localseo');?></label></th>
                <td class="wpl_logo">
                    <input type="hidden" id="wpl_logo" name="_wpl_logo" value="<?php print $meta->logo  ?>" /> 
                    <input id="upload_logo_button" type="button" value="<?php _e('Select Logo', 'wp_localseo');?>" />
                    <input id="remove_logo_button" type="button" value="<?php _e('Remove Logo', 'wp_localseo');?>"<?php if (!$meta->logo) : ?> style="display:none"<?php endif; ?>/>
                    <?php if ($meta->logo) : ?> <img id="wpl_logo_preview" src="<?php print $meta->logo  ?>" /> <?php endif; ?>
                    
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            /*jQuery('#upload_logo_button').click(function() {
                                formfield = jQuery('#wpl_logo').attr('name');
                                tb_show('<?php _e('Select Logo', 'wp_localseo'); ?>', 'media-upload.php?referer=wpl_logo&type=image&TB_iframe=1');
                                return false;
                            });

                            jQuery('#remove_logo_button').click(function() {
                                jQuery('#wpl_logo_preview').remove();
                                jQuery('#wpl_logo').val('');
                                jQuery(this).hide();
                                
                                return false;
                            });
                            
                            window.send_to_editor = function(html) {
                                imgurl = jQuery('img',html).attr('src');
                                jQuery('#wpl_logo').val(imgurl);
                                
                                if (jQuery('#wpl_logo_preview').length < 1)
                                    jQuery('.wpl_logo').append('<img id="wpl_logo_preview" src="'+imgurl+'" />');
                                else
                                    jQuery('#wpl_logo_preview').attr('src', imgurl);
                                
                                jQuery('#remove_logo_button').show();
                                 
                                tb_remove();
                            }*/
                        });   
                    </script>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="_wpl_streetAddress"><?php _e('Street', 'wp_localseo');?></label></th>
                <td><input type="text" id="wpl_streetAddress" name="_wpl_streetAddress" value="<?php print $meta->streetAddress  ?>" class="regular-text" /><br/>
                <span class="howto"><?php _e('Street and no. of the location', 'wp_localseo');?></span></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="_wpl_postalCode"><?php _e('Postal code and city', 'wp_localseo');?></label></th>
                <td><input type="text" id="wpl_postalCode" name="_wpl_postalCode" value="<?php print $meta->postalCode  ?>" style="width: 80px;" />  <input type="text" id="wpl_addressLocality" name="_wpl_addressLocality" value="<?php print $meta->addressLocality  ?>" style="width: 215px;" />  <br/>
                <span class="howto"><?php _e('Postal code and city', 'wp_localseo');?></span></td>
            </tr>    
            <tr valign="top">
                <th scope="row"><label><?php _e('Google map', 'wp_localseo');?></label></th>
                <td>
                <input type="submit"id="checkAddress" value="<?php _e('Check address', 'wp_localseo');?>"/><br/>
                 <span class="howto"><?php _e('Address needs to be checked to update Google Map data', 'wp_localseo');?></span>
                 <span class="howto invalid_geodata" style="display: none;color:#ff0000"><?php _e('Geodata was reset due to empty or invalid adress.', 'wp_localseo');?></span>
                <div id="map-canvas_admin" class="wpl_admin_map" style="width: 320px; height: 240px;"></div>
                <label><?php _e('Latitude', 'wp_localseo');?></label><input type="text" id="wpl_latitude" name="_wpl_latitude" value="<?php print $meta->latitude  ?>" style="width: 80px;" readonly="readonly"/>  <label><?php _e('Longitude', 'wp_localseo');?></label><input type="text" id="wpl_longitude" name="_wpl_longitude" value="<?php print $meta->longitude  ?>" style="width: 80px;" readonly="readonly"/>  <br/>
                <span class="howto"><?php _e('Data is retrieved automatically', 'wp_localseo');?></span></td>
            </tr>
            <?php if($this->settings->enable_telephone): ?>
            <tr valign="top">
                <th scope="row"><label for="_wpl_telephone"><?php _e('Phone', 'wp_localseo');?></label></th>
                <td><?php if (true): $this->dynamicInput($meta->telephone, 'telephone', true); else: ?><input type="text" id="wpl_telephone" name="_wpl_telephone" value="<?php print $meta->telephone  ?>" class="regular-text" /><?php endif; ?></td>
            </tr> 
            <?php endif; ?>
            <?php if($this->settings->enable_faxNumber): ?>            
            <tr valign="top">
                <th scope="row"><label for="_wpl_faxNumber"><?php _e('Fax', 'wp_localseo');?></label></th>
                <td><?php if (true): $this->dynamicInput($meta->faxNumber, 'faxNumber', true); else: ?><input type="text" id="wpl_faxNumber" name="_wpl_faxNumber" value="<?php print $meta->faxNumber  ?>" class="regular-text" /><?php endif; ?></td>
            </tr>  
            <?php endif; ?>
            <?php if($this->settings->enable_email): ?>                    
            <tr valign="top">
                <th scope="row"><label for="_wpl_email"><?php _e('Email', 'wp_localseo');?></label></th>
                <td><?php if (true): $this->dynamicInput($meta->email, 'email', true); else: ?><input type="text" id="wpl_email" name="_wpl_email" value="<?php print $meta->email  ?>" class="regular-text" /><?php endif; ?></td>
            </tr> 
            <?php endif; ?>
            <?php if($this->settings->enable_url): ?>                   
            <tr valign="top">
                <th scope="row"><label for="_wpl_url"><?php _e('Website', 'wp_localseo');?></label></th>
                <td><?php if (true): $this->dynamicInput($meta->url, 'url', true); else: ?><input type="text" id="wpl_url" name="_wpl_url" value="<?php print $meta->url  ?>" class="regular-text" /><?php endif; ?></td>
            </tr> 
            <?php endif; ?>
            <?php if($this->settings->enable_description): ?>       
            <tr valign="top">
                <th scope="row"><label for="_wpl_description"><?php _e('Description', 'wp_localseo');?></label></th>
                <td><textarea id="wpl_description" style="width: 25em" rows="7" name="_wpl_description" ><?php print $meta->description ?></textarea><br/>
                    <span class="howto"><?php _e('HTML is allowed, linebreaks are set automatically.', 'wp_localseo');?></span></td>
            </tr>  
            <?php endif; ?>
            <?php if($this->settings->enable_openingHours): ?>       
            <tr valign="top">
                <th scope="row"><label for="_wpl_openingHours"><?php _e('Opening hours', 'wp_localseo');?></label></th>  
                <td>
            <?php
            $openingHours = $meta->openingHours;

      ?> 
                    <div id="openingHours">
                    <div id="openingHours_template"  class="openingHours_entity" style="display:none">
                      <select class="day">
                        <option value="1"><?php _e('Monday', 'wp_localseo'); ?></option>
                        <option value="2"><?php _e('Tuesday', 'wp_localseo'); ?></option>
                        <option value="3"><?php _e('Wednesday', 'wp_localseo'); ?></option>
                        <option value="4"><?php _e('Thursday', 'wp_localseo'); ?></option>
                        <option value="5"><?php _e('Friday', 'wp_localseo'); ?></option>
                        <option value="6"><?php _e('Saturday', 'wp_localseo'); ?></option>
                        <option value="7"><?php _e('Sunday', 'wp_localseo'); ?></option>
                      </select>
                      <input type="text" class="textfield from_hr mini" maxlength="2">:<input type="text" class="textfield from_min mini" maxlength="2"> <?php _e('to', 'wp_localseo'); ?> <input type="text" class="textfield to_hr mini" maxlength="2">:<input type="text" class="textfield to_min mini" maxlength="2">
                      <a class="del" href="#">[x]</a>
                    </div>
                    <?php      
                    $counter = 0; if(is_array($openingHours) && !empty($openingHours)): foreach ($openingHours as $k => $t_inner): if(is_array($t_inner) && !empty($t_inner)): foreach ($t_inner as  $kk => $v):  ?>
                    <div class="openingHours_entity">
                      <select class="day" name="_wpl_openingHours[<?php print $k?>][<?php print $kk?>][day]">
                        <option value="1"<?php if ($v['day'] == 1) print ' selected="selected"'; ?>><?php _e('Monday', 'wp_localseo'); ?></option>
                        <option value="2"<?php if ($v['day'] == 2) print ' selected="selected"'; ?>><?php _e('Tuesday', 'wp_localseo'); ?></option>
                        <option value="3"<?php if ($v['day'] == 3) print ' selected="selected"'; ?>><?php _e('Wednesday', 'wp_localseo'); ?></option>
                        <option value="4"<?php if ($v['day'] == 4) print ' selected="selected"'; ?>><?php _e('Thursday', 'wp_localseo'); ?></option>
                        <option value="5"<?php if ($v['day'] == 5) print ' selected="selected"'; ?>><?php _e('Friday', 'wp_localseo'); ?></option>
                        <option value="6"<?php if ($v['day'] == 6) print ' selected="selected"'; ?>><?php _e('Saturday', 'wp_localseo'); ?></option>
                        <option value="7"<?php if ($v['day'] == 7) print ' selected="selected"'; ?>><?php _e('Sunday', 'wp_localseo'); ?></option>
                      </select>
                      <input name="_wpl_openingHours[<?php print $k?>][<?php print $kk?>][from_hr]" type="text" class="textfield from_hr mini" maxlength="2" value="<?php print $v['from_hr']?>">:<input name="_wpl_openingHours[<?php print $k?>][<?php print $kk?>][from_min]" type="text" class="textfield from_min mini" maxlength="2" value="<?php print $v['from_min']?>"> <?php _e('to', 'wp_localseo'); ?> <input name="_wpl_openingHours[<?php print $k?>][<?php print $kk?>][to_hr]" type="text" class="textfield to_hr mini" maxlength="2" value="<?php print $v['to_hr']?>">:<input name="_wpl_openingHours[<?php print $k?>][<?php print $kk?>][to_min]" type="text" class="textfield to_min mini" maxlength="2" value="<?php print $v['to_min']?>">
                      <a class="del" href="#">[x]</a>
                    </div>             
                    <?php $counter++; endforeach;endif;endforeach;endif; ?>
                    <a id="add_openingHours" href="#"><?php _e('Add opening hours', 'wp_localseo'); ?></a><br/>
                    <style type="text/css">.mini { width: 30px} .error {border-color: red!important} .message_error2 {color: red}</style>
                    <script type="text/javascript">
                      jQuery(document).ready(function() {
                      
                        jQuery('.openingHours_entity .day').change(function() {
                            var day = jQuery(this);
                            day.attr('name',  jQuery(this).attr('name').replace(/openingHours\[[0-9]{1}\]/, 'openingHours['+day.val()+']'));
                            day.parent().find('input').each(function(){jQuery(this).attr('name',  jQuery(this).attr('name').replace(/openingHours\[[0-9]{1}\]/, 'openingHours['+day.val()+']'))});
                        });
                          
                        jQuery('.openingHours_entity .del').click(function() {
                          jQuery(this).parent().remove();
                          return false;
                        });
                     
                      
                        var counter = <?php print $counter ?>;
                        jQuery('#add_openingHours').click(function() {
                          openingHours_entity = jQuery('#openingHours_template').clone();
                          //openingHours_entity.Attr('id', 'entity-'+$counter);
                          openingHours_entity.find('.day').attr('name', '_wpl_openingHours[1]['+counter+'][day]');
                          openingHours_entity.find('.day').change(function() {
                            var day = jQuery(this);
                            day.attr('name',  jQuery(this).attr('name').replace(/_wpl_openingHours\[[0-9]{1}\]/, '_wpl_openingHours['+day.val()+']'));
                            day.parent().find('input').each(function(){jQuery(this).attr('name',  jQuery(this).attr('name').replace(/_wpl_openingHours\[[0-9]{1}\]/, '_wpl_openingHours['+day.val()+']'))});
                          });
                          openingHours_entity.find('.from_hr').attr('name', '_wpl_openingHours[1]['+counter+'][from_hr]');
                          openingHours_entity.find('.from_min').attr('name', '_wpl_openingHours[1]['+counter+'][from_min]');
                          openingHours_entity.find('.to_hr').attr('name', '_wpl_openingHours[1]['+counter+'][to_hr]');
                          openingHours_entity.find('.to_min').attr('name', '_wpl_openingHours[1]['+counter+'][to_min]');
     
                          openingHours_entity.find('.del').click(function() {
                            jQuery(this).parent().remove();
                            return false;
                          });                      
     
                          
                          jQuery('#add_openingHours').before(openingHours_entity.show()); 
                                              
                          //On Keypress
                          jQuery(this).find('.from_min, .to_min, .from_hr, .to_hr').keyup(function(){validate_openingHours()});

                          //On Blur
                           jQuery(this).find('.from_min, .to_min, .from_hr, .to_hr').blur(function(){validate_openingHours()});
                          
                          counter++;
                          return false;                     
                        });
                        
                        
                        //On Keypress
                        jQuery('.from_min, .to_min, .from_hr, .to_hr').keyup(function(){validate_openingHours()});

                        //On Blur
                        jQuery('.from_min, .to_min, .from_hr, .to_hr').blur(function(){validate_openingHours()});
                                        
                        
                        function validate_openingHours()
                        {
                          var myerr = 0;
                          
                         
                          jQuery('.openingHours_entity:not(#openingHours_template)').each(function() {
                            var entity = jQuery(this);
                            entity.find('.from_hr, .to_hr').each(function() {
                            
                              if (jQuery(this).val() == '' || isNaN(jQuery(this).val()) || jQuery(this).val() < 0 || jQuery(this).val() > 24) {
                                jQuery(this).addClass('error');
                                myerr++;
                              }else
                                jQuery(this).removeClass('error');
                                
                            });
                            entity.find('.from_min, .to_min').each(function() {
                              if (jQuery(this).val() == '' || isNaN(jQuery(this).val()) || jQuery(this).val() < 0 || jQuery(this).val() > 59) {
                                jQuery(this).addClass('error');
                                myerr++;
                              } else
                                 jQuery(this).removeClass('error');
                            });     
                          });

                          if (myerr > 0) {
                            jQuery('#property_openingHours_span').text("Bitte überprüfen Sie die Zeitangaben.");
                            jQuery('#property_openingHours_span').addClass("message_error2");  
                            return false;
                                
                          }
                          else {
                            jQuery('#property_openingHours_span').text("");
                            jQuery('#property_openingHours_span').removeClass("message_error2");  
                            return true;
                          }
                        }
                        
                        
                      });
                      function setNameperDay(entity, count) {
                        jQuery(entity).attr('name', '_wpl_openingHours['+jQuery(this).val()+']['+count+'][day]');
                      }
                    </script>
                  </div>    
                  <span class="message_error2" id="property_openingHours_span"></span>
              </td>
            </tr>
            <?php endif; ?>
        </table>
    <?php
    
    }

    /**
     * ajax_get_location_list
     * get a list of all locations matching the search term
     *
     * @since 1.0.
     *
     * @include includes the html template either from plugin or from theme root
     *
     * @return formated html of location data
     *
     */    
    function ajax_get_location_list() {
        global $wpdb;
                
        if($term = $_GET['term'])
            $w_term = "`post_title` LIKE '%{$term}%' AND ";
        
        if ($exclude = $_GET['exclude'])
             $excl_string = "`ID` NOT IN ({$exclude}) AND ";
             
        $query = ("SELECT ID, post_title FROM {$wpdb->posts} 
                                        WHERE
                                        {$w_term} 
                                        {$excl_string}
                                        `post_status` LIKE 'publish'
                                        AND `post_type` LIKE 'location'");
        $results = $wpdb->get_results($query);
        $key = 0;
        foreach ($results as $location) {
            if ($_GET['output'] == 'full')
                $output[$key] = (array)get_post($location->ID);
            else {
                $output[$key]['label'] = $location->post_title;
                $output[$key]['name'] = get_post_meta($location->ID, '_wpl_name', true);;
                $output[$key]['location_id'] = $location->ID;
                $output[$key]['longitude'] = get_post_meta($location->ID, '_wpl_longitude', true);
                $output[$key]['latitude'] = get_post_meta($location->ID, '_wpl_latitude', true);
                $output[$key]['street'] = get_post_meta($location->ID, '_wpl_streetAddress', true);
                $output[$key]['town'] = get_post_meta($location->ID, '_wpl_postalCode', true).' '.get_post_meta($location->ID, '_wpl_addressLocality', true);
                $output[$key]['template'] = $this->show_location_template($location->ID, 'mini');
            }
            $key++;
        }
        
        echo json_encode($output);
       
        die();
    } 

    /**
     * ajax_get_location
     * Shows the location data of a post
     *
     * @since 1.0.
     *
     * @include includes the html template either from plugin or from theme root
     *
     * @return formated html of location data
     *
     */    
    function ajax_get_location() {
        global $wpdb;
        
        $location_id = $_POST['location_id'];
        
        echo $this->show_location_template($location_id, false, true);
       
        die();
    } 
    
    function ajax_get_wpl_logo_url() { 
        echo $this->get_wpl_logo_url($_POST['wpl_logo_id']);
        die();
    } 

    function get_wpl_logo_url($id) {
        $wpl_logo = wp_get_attachment_image_src( $id, 'wpl_logo' );
        return $wpl_logo[0];
    }     
    
    /**
     * localize_script
	 * Localize the script vars that require PHP intervention, removing the need for inline JS.
	 */
	function localize_script(){
        global $wpl_localized_js;
        
        $wpl_localized_js['ajaxurl'] =  admin_url('admin-ajax.php');
        $wpl_localized_js['locationsajaxurl'] = admin_url('admin-ajax.php?action=wpl_get_location_list');
                
        wp_localize_script('wp-localseo','WPL', apply_filters('wpl_localize_script', $wpl_localized_js));

    }
    
    
    /**
     * show_location_template
     * Shows the location data of a post
     *
     * @since 1.0.
     *
     * @include includes the html template either from plugin or from theme root
     *
     * @return formated html of location data
     *
     */

    function show_location_template($wpl_id = null, $template = null, $admin = null) {
        global $post;
        if (!$wpl_id)
            $wpl_id = $post->ID;
            
        if ($template)
            $tpl_add = "-".$template;
       
        $this->enqueue_scripts($admin);
        
        if ($this->settings->enable_location_content && (!is_single() && !is_archive()) || $post->post_type != 'location') {
            $ipost = get_post($wpl_id);
            if ($ipost->post_content)
                $wpl_excerpt = $this->trim_excerpt($ipost->post_content);
            
        }
            

        ob_start();
        if ($admin):
            ?>
                <div id="wpl_location_admin_<?php print $wpl_id ?>" class="wpl_location_admin">
            <?php 
        endif;
        if (file_exists(get_stylesheet_directory().'/location-template'.$tpl_add.'.php'))
            include (get_stylesheet_directory().'/location-template'.$tpl_add.'.php');
        
        else if (file_exists(plugin_dir_path(__FILE__).'location-template'.$tpl_add.'.php'))
            include(plugin_dir_path(__FILE__).'location-template'.$tpl_add.'.php');
        
        else include(plugin_dir_path(__FILE__).'location-template.php');
        
        if ($admin):
            ?>
            <input name="_wpl_locations[<?php print $wpl_id ?>]" class="active_locations" type="hidden" value="<?php print $wpl_id ?>" />
            <a class="wpl_button" href="<?php  print get_edit_post_link( $wpl_id ); ?>" target="_blank" alt=""><?php _e("edit", 'wp_localseo') ?><span><?php _e("opens in a new tab/window", 'wp_localseo'); ?></span></a>
            <a class="wpl_button" href="#" onClick="jQuery('#wpl_location_admin_<?php print $wpl_id ?>').remove();return false;"><?php _e("Remove", 'wp_localseo') ?><span><?php _e("will be saved on post update only", 'wp_localseo'); ?></span></a>
        </div>
            <?php 
        endif;            
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }
    
    
    
    /**
     * show_locations
     * Adds the locations via function call
     *
     * @since 2.2.     
     *
     * @return content as html
     *
     */      
    function show_locations($pid = null) {
        global $post;
        
        if ($pid)
            $ipost = get_post($pid);
        else
            $ipost = $post;
        

        $content = "";
        
       
        if (!$this->settings->adv_config || $ipost->post_type == 'location')
          return $content .= $this->show_location_template($ipost->ID);
          
        
        if (!in_array($ipost->post_type, $this->get_enabled_post_types()))
            return $content;
        
        $locations = get_post_meta($ipost->ID, '_wpl_locations', true);
            
        if (is_array($locations)) foreach ($locations as $location_id) {
            if (get_post_status($location_id) == 'publish')
                $content .= $this->show_location_template($location_id);
        }
        return $content;
        
    } 
    
    /**
     * the_content
     * Adds the location data to "the_content" filter
     *
     * @since 1.0.     
     *
     * @return content (html) for the_content filter    
     *
     */    
    
    function the_content($content) {
        global $post;

        return $content.$this->show_locations($post->ID);
        
    }   
    
    function shortcode( $atts ) {
        global $post;
        if (isset($atts['id']))
            $wpl_id = $atts['id'];
        if (!$wpl_id)
            $wpl_id = $post->ID;
        
        //if location id is set return it
        if ($wpl_id)
            return $this->show_locations($wpl_id);

    }
   
    
    /**
     * openingHours
     * creates opening hours table
     *
     * @since 1.0.
     *
     * @return formated html-table with all opening hours
     */    
    
    function openingHours ($timing) {
        if (is_array($timing)) { 
            $output = '<table class="wpl_openingHours">';
            foreach ($timing as $k => $t_inner) {
                $output .= '<tr><td><strong>';
                    switch ($k) {
                      case 1: $dtday = "Mo"; $day = __("Monday", 'wp_localseo');break;
                      case 2: $dtday = "Tu"; $day = __("Tuesday", 'wp_localseo');break;
                      case 3: $dtday = "We"; $day = __("Wednesday", 'wp_localseo');break;
                      case 4: $dtday = "Th"; $day = __("Thursday", 'wp_localseo');break;
                      case 5: $dtday = "Fr"; $day = __("Friday", 'wp_localseo');break;
                      case 6: $dtday = "Sa"; $day = __("Saturday", 'wp_localseo');break;
                      case 7: $dtday = "So"; $day = __("Sunday", 'wp_localseo');break;
                    } 
                $output .= $day.'</strong></td><td>';
                foreach ($t_inner as $v) {
                  $output .= '<meta  itemprop="openingHours" content="'.$dtday.' '.$v['from_hr'].':'.$v['from_min'].'-'.$v['to_hr'].':'.$v['to_min'].'"/>'.$v['from_hr'].':'.$v['from_min'].' - '.$v['to_hr'].':'.$v['to_min'].'<br/>';
                }
                $output .= '</td></tr>';
                
            } 
            $output .= '</table>';
        }
        
        return $output;
    }
    
    /**
     * dynamicInput
     * creates dynamic input fields
     *
     * @since 2.0.
     *
     * @return formatted content for dynamic input fields (admin or template)
     */    
    
    function dynamicInput ($meta, $name, $admin = false) {
        
        if ($meta && !is_array($meta))
            $meta = array($meta);
        
        if ($admin) {
?>
                <div id="<?php print $name; ?>" class="dynamic_input">
                    <div class="dynamic_entity entity_template" style="display:none">
                      <input name="_wpl_<?php print $name ?>[]" type="text" class="regular-text" disabled="disabled">
                      <a class="del" href="#">[x]</a>
                    </div> 
                    <?php if ($meta) foreach ($meta as $value): ?>
                    <div class="dynamic_entity">
                      <input name="_wpl_<?php print $name ?>[] type="text" class="regular-text" value="<?php print $value; ?>">
                      <a class="del" href="#">[x]</a>
                    </div> 
                    <?php endforeach; ?>
                    <a class="add_entity" href="#"><?php _e('Add item', 'wp_localseo'); ?></a><br/>                        
                    
                </div>
<?php        
        } else {
            if (is_array($meta)){
?>
        <ul  class="wpl_<?php print $name; ?> wpl_list">
            <?php foreach ($meta as $value): ?>
            <li itemprop="<?php print $name; ?>">
                <?php if ($name == 'email'): ?><a href="mailto:<?php print $value;?>"><?php endif; ?>
                <?php if ($name == 'url'): ?><a href="<?php print ((!(strpos($value, 'http://') === 0) && !(strpos($value, 'https://')) ) ? 'http://' : '').$value;?>" target="_blank"><?php endif; ?>
                <?php print $value;?>
                 <?php if ($name == 'email' ||$name == 'url'): ?></a><?php endif; ?>
            </li>
            <?php  endforeach; ?>
        </ul>
<?php
            }
        }
    }
    
    
    /**
     * cmp_time
     * helper function for ksort to compare opening hours
     *
     * @since 1.0.
     *
     * @return 0,1 or -1
     */     
    function cmp_time($a, $b)
    {
        if ($a['from_min'].$a['from_min'] == $b['from_min'].$b['from_min']) {
            return 0;
        }
        return ($a['from_hr'].$a['from_min'] < $b['from_min'].$b['from_min']) ? -1 : 1;
    }
    

   /**
     * show_location_map
     * returns formated html content for a google map that shows all locations
     *
     * @since 2.0.
     *
     *
     */   
     
    function show_location_map($width = null, $height = null) {
        
        if(!$this->settings->adv_config)
            return __("This function is only avaiable for advanced features.", 'wp_localseo');

         $this->enqueue_scripts();
        
        if (!$width) $width ="100%";
        if (!$height) $height = "350px";
        ob_start();
    ?>
        <div id="map_locations" class="wpl_locations_map" style="width: <?php print $width; ?>;height: <?php print $height; ?>;"></div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                console.log("start");
                jQuery.ajax({
                    url: WPL.locationsajaxurl,
                    dataType: "json",
                    data: {
                        exclude: function () { 
                                            var ids = new Array();
                                            jQuery(".active_locations").each(function() {
                                                //console.log(jQuery(this).val());
                                                ids.push(jQuery(this).val());
                                            });
                                            return ids;
                        }
                    },
                    success: function(data) {
                        console.log(data);

                        var mapOptions = {
                          zoom: 12,
                          center: new google.maps.LatLng(0, 0),
                          mapTypeId: google.maps.MapTypeId.ROADMAP,
                          disableDefaultUI: false,
                        }
                        var map = new google.maps.Map(document.getElementById("map_locations"), mapOptions);
                        
                        var bound = new google.maps.LatLngBounds();
                        var markers = [];
                        var infowindow;
                        jQuery.each(data, function(i, item) {
                            if (item.latitude && item.longitude) {
                                bound.extend( new google.maps.LatLng(item.latitude, item.longitude) );
                                var marker_temp = new google.maps.Marker({
                                    map: map,
                                    position: new google.maps.LatLng(item.latitude, item.longitude),
                                    title: item.label,
                                    clickable: true,
                                    draggable: false,
                                });
                                markers.push(marker_temp);
                                
                                google.maps.event.addListener(marker_temp, 'click', function() {
                                    if (infowindow) infowindow.close();
                                    infowindow = new google.maps.InfoWindow(
                                    { content: String(item.template)
                                    });
                                    
                                    infowindow.open(map,marker_temp);
                                })      
                                console.log(marker_temp);
                            }
                        }); 
                        map.fitBounds(bound);
                        //var markerCluster = new MarkerClusterer(map, markers, {gridSize: 1});
                    }
                });

            });       
        </script>
    <?php            
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }     
    function shortcode_map( $atts ) {
        if (is_array($atts))
            extract($atts);
        return $this->show_location_map($width, $height);
    } 

    function get_custom_css() {

        if ($this->settings->map_size['width'] || $this->settings->map_size['height'] || $this->settings->custom_css) {
            $style = '<style type="text/css">';
            
            if ($this->settings->map_size['width'] || $this->settings->map_size['height']) {
                $style .= '.wpl_map {';
                if($width = $this->settings->map_size['width']) {
                    if ((int)$width != 0)
                        $width .= 'px';
                    $style .= "    width: $width !important;";
                }
                if($height = $this->settings->map_size['height']) {
                    if ((int)$height != 0)
                        $height .= 'px';
                    $style .= "    height: $height !important;";
                } 
                $style .= '}';
            }
                
            $style .= $this->settings->custom_css;
            
            $style .= '</style>';
        }
        
        print $style;
    }
    
    
    /**
     * create_sitemap
     * Creates XML-Sitemap with included kml file
     *
     * @since 1.0.
     *
     *
     */      

    function create_sitemap () {
        global $wpdb;
        
        //get which post types are to be considered
        
        $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish'", 'location' ) );
        

        echo '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0">';
        
        for ($i = 0; $i <= ($count/1000);$i++) {
            
            echo ' 
            <url>
                <loc>'.home_url( 'locations'.($i+1).'.kml' ).'</loc>
            </url>';
        }
        echo '</urlset>
        ';
        die();
    }
    
       
    
   /**
     * create_kml
     * Creates KML-Sitemap with geodata
     *
     * @since 1.0.
     *
     *
     */      

    function create_kml () {
        global $wpdb,$wp_query;
        
        if ($this->settings->adv_config)
            $locations = array('location');
        else
            $locations = $this->get_enabled_post_types();
        
        
        $n = (int) $wp_query->query_vars['kml_n'];
        $offset = ($n > 1) ? ($n - 1) * 1000 : 0;
        $total = $offset + 1000;

        
        echo '<?xml version="1.0" encoding="UTF-8"?>
        <kml xmlns="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
            <Document>
                <name>'.get_bloginfo('name').'</name>
                <atom:link rel="related" href="'.home_url().'" />
                <Folder>';
        
        $query = "SELECT ID, post_title, post_content, post_name
            FROM $wpdb->posts p
            JOIN $wpdb->postmeta pm
            ON pm.post_id = p.ID
            WHERE p.post_status = 'publish'
            AND	p.post_password = ''
            AND p.post_type in ('".implode("','", $locations)."')
            AND (pm.meta_key = '_wpl_latitude' AND pm.meta_value != 0 AND pm.meta_value != '')
            LIMIT 1000 OFFSET $offset";        

        $posts = $wpdb->get_results($query);
        
        $srcharr = array("&#038;"); 
        $replarr = array("&");

        foreach ( $posts as $p ) {
               
               
            echo '      <Placemark id="'.$p->post_name.'">
                            <name><![CDATA['.get_post_meta($p->ID, '_wpl_name', true).']]></name>
                            <address><![CDATA['.get_post_meta($p->ID, '_wpl_streetAddress', true).', '.get_post_meta($p->ID, '_wpl_postalCode', true).' '.get_post_meta($p->ID, '_wpl_addressLocality', true).']]></address>
                            <description><![CDATA[';
                                ?><?php if (get_post_meta($p->ID,'_wpl_name',true)): ?>
                                    <h2 class="wpl_name" itemprop="name" ><?php print get_post_meta($p->ID, '_wpl_name', true); ?></h2>
                                <?php endif; ?>
                                 <?php if (get_post_meta($p->ID,'_wpl_streetAddress',true) || get_post_meta($p->ID,'_wpl_postalCode',true) || get_post_meta($p->ID,'_wpl_addressLocality',true) ): ?>
                                <p class="wpl_address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <?php if (get_post_meta($p->ID,'_wpl_streetAddress',true)): ?><span class="wpl_streetAddress" itemprop="streetAddress"><?php print get_post_meta($p->ID,'_wpl_streetAddress',true) ?></span><br/><?php endif; ?>
                                    <?php if (get_post_meta($p->ID,'_wpl_postalCode',true)): ?><span class="wpl_postalCode" itemprop="postalCode"><?php print get_post_meta($p->ID,'_wpl_postalCode',true) ?></span><?php endif; if (get_post_meta($p->ID,'_wpl_addressLocality',true)): ?> <span  class="wpl_addressLocality" itemprop="addressLocality"><?php print get_post_meta($p->ID,'_wpl_addressLocality',true) ?></span><?php endif; ?>
                                </p>  
                                <?php endif; ?>    
                                
                                <?php if (get_post_meta($p->ID,'_wpl_telephone',true) && $this->settings->enable_telephone):?>
                                    <h2><?php _e('Phone', 'wp_localseo');?></h2>
                                    <p class="wpl_telephone" itemprop="telephone"><?php echo get_post_meta($p->ID,'_wpl_telephone',true);?></p>
                                <?php endif; ?>
                                
                                <?php if (get_post_meta($p->ID,'_wpl_faxNumber',true) && $this->settings->enable_faxNumber):?>
                                    <h2><?php _e('Fax', 'wp_localseo');?></h2>
                                    <p class="wpl_faxNumber" itemprop="faxNumber"><?php echo get_post_meta($p->ID,'_wpl_faxNumber',true);?></p>        
                                <?php endif; ?>
                                
                                <?php if (get_post_meta($p->ID,'_wpl_email',true) && $this->settings->enable_email):?>
                                    <h2><?php _e('Email address', 'wp_localseo');?></h2>
                                    <p class="wpl_email" itemprop="email"><a href="mailto:<?php echo get_post_meta($p->ID,'_wpl_email',true);?>"><?php echo get_post_meta($p->ID,'_wpl_email',true);?></a></p>        
                                <?php endif; ?>  
                                
                                <?php if (get_post_meta($p->ID,'_wpl_url',true) && $this->settings->enable_url):?>
                                    <h2><?php _e('Website', 'wp_localseo');?></h2>
                                    <p class="wpl_url" itemprop="url"><a href="<?php echo get_post_meta($p->ID,'_wpl_url',true);?>" target="_blank"><?php echo get_post_meta($p->ID,'_wpl_url',true);?></a></p>        
                                <?php endif; ?>                                
                                
                                <?php if (get_post_meta($p->ID,'_wpl_description',true) && $this->settings->enable_description):?>
                                    <h2><?php _e('Description', 'wp_localseo');?></h2>
                                    <p class="wpl_description" itemprop="description"><?php echo nl2br(get_post_meta($p->ID,'_wpl_description',true));?></p>        
                                <?php endif; ?>
                                
                                <?php if (get_post_meta($p->ID,'_wpl_openingHours',true)):?>
                                    <h2><?php _e('Opening hours', 'wp_localseo');?></h2>
                                    <?php print $this->openingHours(get_post_meta($p->ID,'_wpl_openingHours',true)); ?>
                                <?php endif; ?>    
            
                                <a href="<?php print get_permalink($p->ID) ?>"><?php printf(__('Detailled information on %s', 'wp_localseo'), get_bloginfo('name'))?></a></p>
<?php       echo '              ]]></description>
                            <Point>
                                <coordinates>'.get_post_meta($p->ID, '_wpl_longitude', true).','.get_post_meta($p->ID, '_wpl_latitude', true).',0</coordinates>
                            </Point>
                        </Placemark>
                        ';
        }
        echo '  </Folder>
            </Document>
        </kml>';
        die();
    }    
    
    /**
     * add_rewrite_rules
     * add rewrites to generate sitemap.xml / locations.kml
     *
     * @since 1.0
     *
     *
     */   

    function add_rewrite_rules() {
        
        
        $GLOBALS['wp']->add_query_var( 'wpl_sitemap' );
        add_rewrite_rule( 'geo_sitemap\.xml$', 'index.php?wpl_sitemap=1', 'top' );
        
        $GLOBALS['wp']->add_query_var( 'kml' );
        $GLOBALS['wp']->add_query_var( 'kml_n' );
        add_rewrite_rule( 'locations([0-9]+)?\.kml$', 'index.php?kml=$matches[1]&kml_n=$matches[2]', 'top' );
        
        if ($_REQUEST['flush_rewrite_rules'])
            update_option('wpl_rewrite_rules', false);
        
        if (!get_option('wpl_rewrite_rules')) {
            flush_rewrite_rules();
            update_option('wpl_rewrite_rules', true);
            add_action( 'admin_notices', array($this, 'admin_notice_flush_rewrite_rules') );   
        }        
        
        
    }
 

    /**
     * get_business_list
     * gets the select list of the LocalBusiness property
     *
     * @since 2.0
     *
     *
     */ 
     
    function get_business_list($fieldname, $selected_option) {
        $output = '<select name="'.$fieldname.'">';
        foreach ($this->business_list as $business) {
            $selected = "";
            if ($selected_option == $business['name'])
                $selected = ' selected="selected"';
            $output .= '<option class="wpl_'.$business['level'].'" value="'.$business['name'].'"'.$selected.'>'.$business['label'].' ('.$business['name'].')</option>';
        }
        $output.= '</select>';
        
        return $output;
    }
    
    function admin_notice_flush_rewrite_rules() {
        ?>
        <div class="updated">
            <p><?php _e( 'The rewrite rules were flushed successfully.', 'wp_localseo' ); ?></p>
        </div>
        <?php
    }

    function admin_notice_install() {
        ?>
        <div class="updated">
            <p><?php _e( '<strong>WP Local SEO</strong> was successfully installed.', 'wp_localseo' ); ?></p>
        </div>
        <?php
    }      
    
    
    function admin_notice_update_11() {
        ?>
        <div class="updated">
            <p><?php _e( '<strong>WP Local SEO</strong> was successfully updated to <strong>Version 1.1</strong>', 'wp_localseo' ); ?></p>
            <p><?php _e( '<strong>Note:</strong> We took care of all variables set through the Wordpress. If you have any function calls in your theme, you need to change them manually.', 'wp_localseo' ); ?></p>
        </div>
        <?php
    }      
    
    function admin_notice_update_20() {
        ?>
        <style>
            .updated.wp_local_seo li {
                list-style: disc;
                margin-left:30px;
            }
        </style>
        <div class="updated wp_local_seo">
            <p><?php _e( '<strong>WP Local SEO</strong> was successfully updated to <strong>Version 2.0</strong>', 'wp_localseo' ); ?></p>
            <p><strong><?php _e( 'New in Version 2.0: ', 'wp_localseo' ); ?></strong></p>
            <ul>
                <li><?php _e( 'Multiple phone & fax numbers, email adresses and websites', 'wp_localseo' ); ?></li>
                <li><?php _e( 'Possibility to define any valid Schema.org location category (any child of http://schema.org/LocalBusiness or http://schema.org/CivicStructure)', 'wp_localseo' ); ?></li>
                <li><?php _e( 'Two configuration modes:', 'wp_localseo' ); ?></li>
            </ul>    
            <p><strong><?php _e( 'Standard configuration:', 'wp_localseo' ); ?></strong></p>
            <ul><li><?php _e( 'provides an easy to use interface adding the location information directly into any post', 'wp_localseo' ); ?></li></ul>
            <p><strong><?php _e( 'Advanced features:', 'wp_localseo' ); ?></strong></p>
            <ul>
                <li><?php _e( 'Creates locations as instances (custom post type) and lets you just add them to any post (multiple locations per post are possible)', 'wp_localseo' ); ?></li>
                <li><?php _e( 'Enables categories for locations', 'wp_localseo' ); ?></li>
                <li><?php _e( 'Enables Google Map with all locations via shortcode or function call', 'wp_localseo' ); ?></li>
            </ul>
            <p><?php _e( '<strong>Note:</strong> We took care of all variables set through the Wordpress. If you have any function calls in your theme, you need to change them manually.', 'wp_localseo' ); ?></p>
            <?php if($this->settings->adv_config): ?> <p><?php _e( '<strong>Advanced features:</strong> We automatically activated advanced features, because you had the location post type activated.', 'wp_localseo' ); ?></p><?php endif; ?>
        </div>
        <?php
    }  

    function admin_notice_update_22() {
        ?>
        <div class="updated">
            <p><?php printf(__( '<strong>WP Local SEO</strong> was successfully updated to <strong>Version %s</strong>', 'wp_localseo' ), '2.2'); ?></p>
            <p><strong><?php printf(__( 'New in <strong>Version %s</strong>', 'wp_localseo' ), '2.2'); ?></strong></p>
            <ul>
                <li><?php _e( 'Custom size for maps and uploaded logos', 'wp_localseo' ); ?></li>
                <li><?php _e( 'Custom css styles for advanced layouting', 'wp_localseo' ); ?></li>
            </ul>                
        </div>
        <?php
    }      

    function admin_notice_update_23() {
        ?>
        <div class="updated">
            <p><?php printf(__( '<strong>WP Local SEO</strong> was successfully updated to <strong>Version %s</strong>', 'wp_localseo' ), '2.3'); ?></p>
            <p><strong><?php printf(__( 'New in <strong>Version %s</strong>', 'wp_localseo' ), '2.3'); ?></strong></p>
            <ul>
                <li><?php _e( 'Enable content for location post type', 'wp_localseo' ); ?></li>
            </ul>   
            <p><?php _e( '<strong>Note:</strong>There was an update in the location template you might need to take care of in your theme.', 'wp_localseo' ); ?></p>            
        </div>
        <?php
    }  
    
    function admin_notice_adv_config() {
        ?>
        <div class="updated">
            <p><?php _e( '<strong>Advanced features were successfully activated</strong>', 'wp_localseo' ); ?></p>
            <p><?php _e( '<strong>Note:</strong> We automatically migrated all your locations into the new post type.', 'wp_localseo' ); ?></p>
        </div>
        <?php
    } 
    
    function get_enabled_post_types () {
        if ($this->settings->adv_config)
            $screens[] = 'location';
        if (!empty($this->settings->enable_post_types))foreach ($this->settings->enable_post_types as $name => $val)
            $screens[] = $name;
        return $screens;
    }
    
    /**
     * Allows for excerpt generation outside the loop.
     * 
     * @since 2.3
     * @param string $text  The text to be trimmed
     * @return string       The trimmed text
     */
    function trim_excerpt( $text='' ) {
        $text = strip_shortcodes( $text );
        //$text = apply_filters('the_content', $text); //is messing it up somehow?!
        $text = str_replace(']]>', ']]&gt;', $text);
        $excerpt_length = apply_filters('excerpt_length', 55);
        $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
        return wp_trim_words( $text, $excerpt_length, $excerpt_more );
    }

}

//create instance of class, avaiable as global variable
$wp_localseo = new WPLocalSeo();







   
    /* function replace_thickbox_text($translated_text, $text, $domain) {
        die("here");
        if (__('Insert into Post') == $text) {
            $referer = strpos( wp_get_referer(), 'wpl_logo' );
            if ( $referer != '' ) {
                return __('Insert Logo', 'wp_localseo' );
            }
        }
        return $translated_text;
    }   */