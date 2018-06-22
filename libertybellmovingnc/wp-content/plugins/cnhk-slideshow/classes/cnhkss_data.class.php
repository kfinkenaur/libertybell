<?php
/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists('CNHKSS_DATA')) {
    class CNHKSS_DATA
    {        
        /**
        * Default options
        */        
        protected $default_options = array(
            'options' => array(
                'version' => CNHK_VERSION,
                'flash' => true,
            ),
            'slides' => array(),
            'slideshows' => array(),
        );        
        
        /**
        * The default setting for each new slideshow created (without the name field)
        */
        protected $default_settings = array(
            'fx' => 'fade',
            'speed' => 1500,
            'timeout' => 4000,
            'pager' => true,
            'nav' => true,
            'delay' => 15,
            'skip' => false,
            'slides' => array(),
        );
        
        /**
        * The main data.
        */
        private $options = null;
        
        /**
        * Effect list. Each name is associated with his corresponding value within the jQuery.Cycle2 plugin.
        */
        private $effect_list = array(
            'Fade' => 'fade',
            'Scroll' => 'scrollHorz',
            'Tile Slide' => 'tileSlide',
            'Tile Blind' => 'tileBlind',
            'None' => 'none',
        );
        
        private $plugin = null;
        
        /**
        * Constructor
        */
        public function __construct(&$plugin)
        {
            $this->plugin = $plugin;
            $this->check_version();
            // $this->check_structure();
            $this->readDB();
        }
                
        /**
        * Plugin upgrade
        */
        private function check_version()
        {
            if (!file_exists(CNHK_UPLOAD_DIR)) {
                if (!mkdir(CNHK_UPLOAD_DIR, 0777, true)) {
                    $this->plugin->append_notice('<strong>' . __('Cnhk Slideshow could not access to the WordPress Upload Directory. The plugin can not work correctly.', CNHK_TEXTDOMAIN) . '</strong>');
                }
            }
            $options = get_option('cnhk_options');
            if (!isset($options['options']['version'])) {
                delete_option('cnhk_options_slides');
                delete_option('cnhk_options_ss');
                update_option('cnhk_options', $this->default_options);
            } elseif (CNHK_VERSION != $options['options']['version']) {
                $this->check_structure();
            }
        }
        
        /**
        * Update data structure
        */
        private function check_structure()
        {
            // Upgrade data structure
            $options = get_option('cnhk_options');
            
            // Update instructions here!!
            if (!empty($options['slides'])) {
                foreach ($options['slides'] as $key => $value) {
                    if (isset($options['slides'][$key]['date'])) unset($options['slides'][$key]['date']);
                    if (!isset($options['slides'][$key]['caption'])) $options['slides'][$key]['caption'] = $this->plugin->common_texts['NoCaption'];
                }
            }
            
            $options['options']['version'] = CNHK_VERSION;
            update_option('cnhk_options', $options);
        }
        
        /**
        * Get options
        */
        public function readDB()
        {
            $this->options = get_option('cnhk_options');
        }
        
        /**
        * Save options
        */
        public function saveDB()
        {
            update_option('cnhk_options', $this->options);
        }
        
        /**
        * Delete one slide
        */
        public function delete_slide($slug)
        {
            if (isset($this->options['slides'][$slug])) {
                unset($this->options['slides'][$slug]);
                foreach ($this->options['slideshows'] as $id => $ss) {
                    $index = array_search($slug, $ss['slides']);
                    if (false !== $index) {
                        array_splice($this->options['slideshows'][$id]['slides'], $index, 1);
                    }
                }
                $this->saveDB();
            } else {
                return false;
            }
        }
        
        /**
        * Delete one slideshow
        */
        public function delete_slideshow($slug)
        {
            unset($this->options['slideshows'][$slug]);
            $this->saveDB();
        }
        
        /**
        * Add one slide
        */
        public function add_slide($title, $type)
        {
            $new_slide = array(
                'src' => $title . '.' . $type,
                'title' => $title,
                'link' => rawurlencode($this->plugin->common_texts['NoLink']),
                'caption' => $this->plugin->common_texts['NoCaption'],
                'type' => $type,
            );
            $this->options['slides'][$title] = $new_slide;
            $this->saveDB();
        }
        
        /**
        * Save slideshow settings
        * @param array $setting, array of settings
        * @param string $slug, the slideshow's id
        */
        public function slideshow_settings($setting, $slug)
        {
            $new_setting = $setting + $this->options['slideshows'][$slug];
            $this->options['slideshows'][$slug] = $new_setting;
            $this->saveDB();
        }
        
        /**
        * Change slide properties
        */
        public function edit_slide($title, $link, $current_slug, $caption)
        {
            $new_slug = $this->sanitize($title);
            $new_slide = $this->options['slides'][$current_slug];
            $new_slide['title'] = $title;
            $new_slide['link'] = (empty($link)) ? rawurlencode($this->plugin->common_texts['NoLink']) : rawurlencode($link);
            $new_slide['src'] = $new_slug . '.' . $this->options['slides'][$current_slug]['type'];
            $new_slide['caption'] = ('' == $caption) ? $this->plugin->common_texts['NoCaption'] : stripslashes($caption);
            $slide_list = array();
            
            foreach ($this->options['slides'] as $key => $slide) {
                if ($current_slug == $key) {
                    $slide_list[$new_slug] = $new_slide;
                } else {
                    $slide_list[$key] = $slide;
                }
            }
            $this->options['slides'] = $slide_list;            
            $rename_error = false;
            if ($new_slug != $current_slug) {
                try {
                    rename(
                        CNHK_UPLOAD_DIR . $current_slug . '.' . $this->options['slides'][$new_slug]['type'],
                        CNHK_UPLOAD_DIR . $new_slug . '.' . $this->options['slides'][$new_slug]['type']
                    );
                } catch (Exception $ex) {
                    $rename_error = true;
                }
            }
            if ($rename_error) {
                $this->readDB();
                return false;
            } else {
                foreach ($this->options['slideshows'] as $ss_slug => $slideshow) {
                    foreach ($slideshow['slides'] as $id => $value) {
                        if ($current_slug == $value) {
                            $this->options['slideshows'][$ss_slug]['slides'][$id] = $new_slug;
                        }
                    }
                }
                $this->saveDB();
                return true;
            }
        }
        
        /**
        * Edit slides order
        */
        public function edit_slides_order($slideshow, $slides)
        {
            $slides_order = ('' != $slides) ? explode('.', $slides) : array();
            $this->options['slideshows'][$slideshow]['slides'] = $slides_order;
            $this->saveDB();
        }
        
        /**
        * Check if the new slide title is valid
        */
        public function is_valid_slide_title($title, $current_slug)
        {
            $slug = $this->sanitize($title);
            if (!empty($this->options['slides'][$slug]) && $slug != $current_slug) {
                return false;
            } else {
                return true;
            }
        }
        
        /**
        * Create a slideshow
        */
        public function add_slideshow($name)
        {
            $ss = $this->default_settings;
            $ss['name'] = $name;
            $slug = $this->sanitize($name);
            $this->options['slideshows'][$slug] = $ss;
            $this->saveDB();
        }
        
        /**
        * Sanitize a name (slide or slideshow) to make a slug
        */
        public function sanitize($name)
        {
            $sch = array( "#(\s){1,}#iu", "#[éêèë]#iu", "#[îï]#iu", "#[öô]#iu", "#[ùüû]#iu", "#[àâä]#iu", "#ç#iu", "#[^éêèëïîöôùüûàâäç0-9a-zA-Z_ -]#iu" );
            $rpl = array( "_", "e", "i", "o", "u", "a", "c", "-" );
            return preg_replace( $sch, $rpl, $name );
        }
        
        /**
        * Return the clean integer value from a string
        */
        public function parse_int($value)
        {
            $trimmed = str_ireplace(' ', '', $value);
            if (preg_match('#^-?[0-9]+$#', $trimmed)) {
                return intval($trimmed);
            } else {
                return false;
            }
        }
        
        /**
        * Return data
        */
        public function get_data()
        {
            return $this->options;
        }
        
        /**
        * Return effect list 
        */
        public function get_effects()
        {
            return $this->effect_list;
        }
        
        /**
        * Switch on/off the flash uploader
        */
        public function noflash($flash)
        {
            if (1 == $flash) {
                $this->options['options']['flash'] = false;
            } else {
                $this->options['options']['flash'] = true;
            }
            $this->saveDB();
        }
    }
}
