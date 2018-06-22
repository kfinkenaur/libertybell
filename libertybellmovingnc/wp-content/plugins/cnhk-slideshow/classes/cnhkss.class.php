<?php
/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists('CNHKSS_CLASS')) {
    
    class CNHKSS {
    
        private $data_obj = null;
        
        private $ajax_obj = null;
        
        private $nonce = null;
        
        private $admin_notices = '';
        
        private $incl_template = null;
        
        public $common_texts = array();
        
        /**
        * Constructor, setup filters and actions.
        */
        public function __construct() 
        {
            /**
            * Commonly used translated texts.
            */
            $this->common_texts['Slides'] = __('Slides', CNHK_TEXTDOMAIN);
            $this->common_texts['Slideshow'] = __('Slideshow', CNHK_TEXTDOMAIN);
            $this->common_texts['Settings'] = __('Settings', CNHK_TEXTDOMAIN);
            $this->common_texts['Select'] = __('Select', CNHK_TEXTDOMAIN);
            $this->common_texts['flash_yes'] = sprintf(__('You are using the flash uploader. Problems? Try the <a href="%s">browser uploader</a> instead.', CNHK_TEXTDOMAIN), CNHK_SLIDES_URL . '&noflash=1');
            $this->common_texts['flash_no'] = sprintf(__('You are using the default browser uploader. <a href="%s" id="switch-to-flash">Switch to the flash uploader ?</a>', CNHK_TEXTDOMAIN), CNHK_SLIDES_URL . '&noflash=0');
            $this->common_texts['Security'] = __('Please refresh the page and try again.', CNHK_TEXTDOMAIN);
            $this->common_texts['file_types'] = __('This file type is not allowed.', CNHK_TEXTDOMAIN);
            $this->common_texts['Edit'] = __('Edit', CNHK_TEXTDOMAIN);
            $this->common_texts['Delete'] = __('Delete', CNHK_TEXTDOMAIN);
            $this->common_texts['Cancel'] = __('Cancel', CNHK_TEXTDOMAIN);
            $this->common_texts['Create'] = __('Create', CNHK_TEXTDOMAIN);
            $this->common_texts['Save'] = __('Save', CNHK_TEXTDOMAIN);
            $this->common_texts['Proceed'] = __('Proceed ?', CNHK_TEXTDOMAIN);
            $this->common_texts['Title'] = __('Title', CNHK_TEXTDOMAIN);
            $this->common_texts['Link'] = __('Link', CNHK_TEXTDOMAIN);
            $this->common_texts['NoLink'] = __('No Link', CNHK_TEXTDOMAIN);
            $this->common_texts['updated'] = __('Data updated.', CNHK_TEXTDOMAIN);
            $this->common_texts['invalid_slide_title'] = __("The chosen title matches another existing slide's filename.", CNHK_TEXTDOMAIN);
            $this->common_texts['NoCaption'] = __('No Caption' , CNHK_TEXTDOMAIN);
            $this->common_texts['NoUpdate'] = __('An error occurred. No data updated' , CNHK_TEXTDOMAIN);
            
            $this->data_obj = new CNHKSS_DATA($this);
            
            $this->ajax_obj = new CNHKSS_AJAX($this, $this->data_obj);
            
            if (!empty($_SESSION['cnhk']['notices'])) {
                $this->admin_notices .= $_SESSION['cnhk']['notices'];
                unset($_SESSION['cnhk']['notices']);
            }
            
            if (!empty($_SESSION['cnhk']['template'])) {
                $this->incl_template = $_SESSION['cnhk']['template'];
                unset($_SESSION['cnhk']['template']);
            }
            
            
            add_action('wp_head', array($this, 'wp_head'));
            add_action('wp_enqueue_scripts', array($this, 'front_script'));
            add_shortcode('cnhk_slideshow', array($this, 'shortcode'));
            
            // Back-end functions.
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'admin_script'));
            add_action('admin_print_scripts', array($this, 'admin_print_scripts'));
            add_action('admin_init', array($this, 'admin_init'));
            add_action('widgets_init', array($this, 'register_widget'));
        }
        
        /**
        * Display slideshow in front-end.
        * @param string name, the name of the called slideshow
        */
        public function show($name)
        {
            include(CNHK_INCL_DIR . 'slideshow.php');
        }
        
        /**
        * The shortcode function
        */
        public function shortcode($atts, $content = null)
        {
            extract(shortcode_atts(array('name' => ''), $atts));
            if (empty($content)) {
                ob_start();
                $this->show($name);
                return ob_get_clean();
            } else {
                ob_start();
                $this->show(addslashes($content));
                return ob_get_clean();
            }
        }
        
        /**
        * Print scripts in <head /> section of front-end pages
        */
        public function wp_head()
        {
            $options = $this->data_obj->get_data();
            foreach ($options['slides'] as $slug => $value) {
                $options['slides'][$slug]['link'] = esc_js(rawurldecode($options['slides'][$slug]['link']));
                $options['slides'][$slug]['title'] = stripslashes($options['slides'][$slug]['title']);
            }
            foreach ($options['slideshows'] as $slug => $value) {
                $options['slideshows'][$slug]['name'] = stripslashes($options['slideshows'][$slug]['name']);
                $options['slideshows'][$slug]['ratio'] = $this->get_ratio($slug);
                $options['slideshows'][$slug]['hasCaption'] = false;
                foreach ($value['slides'] as $slide) {
                    if ($this->common_texts['NoCaption'] != $options['slides'][$slide]['caption']) {
                        $options['slideshows'][$slug]['hasCaption'] = true;
                        break;
                    }
                }
            }
            $options['transient']= array(
                'uploadUrl' => CNHK_UPLOAD_URL,
                'imageUrl' => CNHK_IMG_URL,
                'noLink' => $this->common_texts['NoLink'],
                'noCaption' => $this->common_texts['NoCaption'],
            );
            ?>
            <script type="text/javascript">
                var cnhkOptions = <?php echo json_encode($options); ?>
            </script>
            <?php
        }
        
        /**
        * Enqueue front scripts (and styles)
        */
        public function front_script()
        {
            $iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
            $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
            $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
            $iOS6 = stripos($_SERVER['HTTP_USER_AGENT'],"1001");
            wp_enqueue_script('jquery');
            wp_enqueue_script('cnhk-cycle', CNHK_SCRIPT_URL . 'jquery.cycle2.min.js', array('jquery'));
            wp_enqueue_script('cnhk-cycle-swipe', CNHK_SCRIPT_URL . 'jquery.cycle2.swipe.min.js', array('cnhk-cycle'));
            wp_enqueue_script('cnhk-cycle-tile', CNHK_SCRIPT_URL . 'jquery.cycle2.tile.min.js', array('cnhk-cycle'));
            if (($iPod || $iPhone || $iPad) && $iOS6) {
                wp_enqueue_script('cnhk-cycle-ios6', CNHK_SCRIPT_URL . 'ios6fix.js', array('cnhk-cycle'));
            }
            wp_enqueue_script('cnhk-front-js', CNHK_SCRIPT_URL . 'front.js', array('cnhk-cycle'));
            wp_enqueue_style('cnhk-front-css', CNHK_SCRIPT_URL . 'front-css.css');
            wp_enqueue_style('cnhk-overlay-css', CNHK_SCRIPT_URL . 'overlay-css.css');
        }
        
        /**
        * Admin menu hook's function
        */
        public function admin_menu()
        {
            $icon_url = CNHK_IMG_URL . 'slides16.png';
            
            global $cnhk_slide_page;
            global $cnhk_ss_page;
                        
            add_menu_page($this->common_texts['Settings'], __('Cnhk Slideshow', CNHK_TEXTDOMAIN), 'manage_options', 'cnhk-slides', array($this, 'slides_page_cb'), $icon_url);
            $cnhk_slide_page = add_submenu_page('cnhk-slides', $this->common_texts['Slides'], $this->common_texts['Slides'], 'manage_options', 'cnhk-slides', array($this, 'slides_page_cb'));
            $cnhk_ss_page = add_submenu_page('cnhk-slides', $this->common_texts['Slideshow'], $this->common_texts['Slideshow'], 'manage_options', 'cnhk-slideshow', array($this, 'slideshow_page_cb'));
            add_action('load-' . $cnhk_slide_page, array($this, 'help_tabs'));
            add_action('load-' . $cnhk_ss_page, array($this, 'help_tabs'));
        }
        
        /**
        * Register the Widget
        */
        public function register_widget()
        {
            register_widget('CNHKSS_WIDGET');
        }
        
        /**
        * "slides" page callback
        */
        public function slides_page_cb()
        {
            $options = $this->data_obj->get_data();
            if (isset($_GET['action']) && isset($_GET['key']) && isset($_GET['id'])) {
                if (1 === wp_verify_nonce($_GET['key'], 'slides-action-nonce') && isset($options['slides'][$_GET['id']])) {
                    switch ($_GET['action']) {
                        case 'edit' :
                            $display_data['slug'] = $_GET['id'];
                            include_once(CNHK_INCL_DIR . 'admin-slides-edit.php');
                            break;
                        case 'delete' :
                            $display_data['slug'] = $_GET['id'];
                            include_once(CNHK_INCL_DIR . 'admin-slides-delete.php');
                            break;
                        default :
                            include_once(CNHK_INCL_DIR . 'admin-slides.php');
                    }
                } else {
                    include_once(CNHK_INCL_DIR . 'admin-slides.php');
                }
            } else {
                if (!empty($this->incl_template)) {
                    if (!empty($this->incl_template['data'])) {
                        $display_data = $this->incl_template['data'];
                    }
                    include_once(CNHK_INCL_DIR . $this->incl_template['name']);
                } else {
                    include_once(CNHK_INCL_DIR . 'admin-slides.php');
                }
            }
        }
        
        /**
        * "slideshow" page callback
        */
        public function slideshow_page_cb()
        {
            $options = $this->data_obj->get_data();
            $tab_list = array('setting', 'slides');
            if (!isset($_GET['tab']) || !in_array($_GET['tab'], $tab_list)) {
                $_GET['tab'] = 'setting';
            }
            $target = (isset($_POST['target'])) ? $_POST['target'] : '';
            $target = (isset($_GET['target']) && '' == $target) ? $_GET['target'] : $target;
            if ('' == $target && !empty($options['slideshows'])) {
                $keys = array_keys($options['slideshows']);
                $target = $keys[0];
            }
            if (!isset($options['slideshows'][$target])) {
                $target = '';
            }
            $target_url = ('' == $target) ? '' : "&target=$target";
            ?>
            <div id="wrap-slideshow" class="wrap"> 
                <div id="icon-slideshow" class="icon32"></div>
                <h2 class="nav-tab-wrapper">
                    <a href="<?php echo esc_url(CNHK_SLIDESHOW_URL . $target_url); ?>" class="nav-tab<?php if ('setting' == $_GET['tab']) echo " nav-tab-active"; ?>"><?php echo $this->common_texts['Slideshow']; ?></a>
                    <a href="<?php echo esc_url(CNHK_SLIDESHOW_URL . '&tab=slides' . $target_url); ?>" class="nav-tab<?php if ('slides' == $_GET['tab']) echo " nav-tab-active"; ?>"><?php _e('Slides order', CNHK_TEXTDOMAIN); ?></a>
                </h2>
            <?php
            $this->display_notices();
            if (!empty($this->incl_template)) {
                if (!empty($this->incl_template['data'])) {
                    $display_data = $this->incl_template['data'];
                }
                include_once(CNHK_INCL_DIR . $this->incl_template['name']);
            } else {
                include_once(CNHK_INCL_DIR . 'admin-slideshow.php');
            }
            ?>
            </div><!-- #wrap-slideshow.wrap -->
            <?php
        }
        
        /**
        * Enqueue admin scripts (and styles)
        */
        public function admin_script()
        {
            global $cnhk_slide_page;
            global $cnhk_ss_page;
            
            $screen = get_current_screen();
            
            if ($screen->id == $cnhk_slide_page) {
                wp_enqueue_style('cnhk-admin-css', CNHK_SCRIPT_URL . 'admin-css.css');
                wp_enqueue_script('jquery');
                wp_enqueue_script('cnhk-uploadify-js', CNHK_UPLOADIFY_URL . 'jquery.uploadify-3.1.min.js', array('jquery'));
                wp_enqueue_style('cnhk-uploadify-css', CNHK_UPLOADIFY_URL . 'uploadify.css', false);
                wp_enqueue_script('cnhk-slide-js', CNHK_SCRIPT_URL . 'slides-page.js', array('cnhk-uploadify-js'));
            }
            if ($screen->id == $cnhk_ss_page) {
                wp_enqueue_style('cnhk-admin-css', CNHK_SCRIPT_URL . 'admin-css.css');
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-widget');
                wp_enqueue_script('jquery-ui-mouse');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('cnhk-slideshow-js', CNHK_SCRIPT_URL . 'slideshow-page.js');
            }
        }
        
        /**
        * Add contextual help text in admin pages
        */
        public function help_tabs()
        {
            global $cnhk_slide_page;
            global $cnhk_ss_page;
            $scr = get_current_screen();
            
            if ($cnhk_slide_page == $scr->id) {
                $text = '<h4>' . __('Slides Admin Page', CNHK_TEXTDOMAIN) . '</h4>';
                $text .= '<p>' . __('You can use any title you want but remember that the filename is derived from the title, and each filename must be unique.', CNHK_TEXTDOMAIN) . ' ';
                $text .= __('For instance, "A $100 bill" and "A £100 bill" will result to the same filename.', CNHK_TEXTDOMAIN) . '</p>';
                $text .= '<p>' . __('If you encounter problems with the dynamic title or link edition, refresh the page or use the links on the "Action" column.', CNHK_TEXTDOMAIN) . ' ';
                $text .= __('When you delete a slide, it will be removed automatically from any slideshow where it\'s used.', CNHK_TEXTDOMAIN) . '</p>';
                $scr->add_help_tab(array(
                    'id'		=> 'Overview',
                    'title'		=> __('Overview', CNHK_TEXTDOMAIN),
                    'content'	=> $text,
                ));
            }
            
            if ($cnhk_ss_page == $scr->id) {
                $ss = '<h4>' . __('Slideshow Admin Page', CNHK_TEXTDOMAIN) . '</h4>';
                $ss .= '<p>' . __('Like for slides names, you can use any name you want for slideshows.', CNHK_TEXTDOMAIN) . ' ';
                $ss .= __('But using some sensible characters such as "(double quote), \'(single quote), <(less than) >(greater than) and some others will make the slideshow not callable via shortcode.', CNHK_TEXTDOMAIN) . ' ';
                $ss .= __('You are still able to use it as Widget or with direct template tag, but if you plan to use the slideshow via shortcode within the content of a page or post, avoid using those characters in your slideshow\'s name.', CNHK_TEXTDOMAIN) . '</p>';
                $ss .= '<p>' . __('Deleting a slideshow does not affect slides data and files.', CNHK_TEXTDOMAIN) . '</p>';
                
                $sl = '<h4>' . __('Slideshow Admin Page', CNHK_TEXTDOMAIN) . '</h4>';
                $sl .= '<p>' . __('Drag a thumbnail from the left to the right column to add it in a slideshow.', CNHK_TEXTDOMAIN) . ' ';
                $sl .= __('Always check that you are currently editing the correct slideshow.', CNHK_TEXTDOMAIN) . ' ';
                $sl .= __('Drag the slide back to the left column to remove it from the slideshow.', CNHK_TEXTDOMAIN) . '</p>';
                $sl .= '<p>' . __('Each slide can be used any time you want, in single or multiple slideshow.', CNHK_TEXTDOMAIN) . ' ';
                $sl .= __('Do not forget to save changes you\'ve made.', CNHK_TEXTDOMAIN) . '</p>';
                $scr->add_help_tab(array(
                    'id'		=> 'Slideshow',
                    'title'		=> $this->common_texts['Slideshow'],
                    'content'	=> $ss,
                ));
                $scr->add_help_tab(array(
                    'id'		=> 'Slides',
                    'title'		=> $this->common_texts['Slides'],
                    'content'	=> $sl,
                ));
            }
        }
        
        /**
        * Print scripts in <head /> section of admin pages.
        */
        public function admin_print_scripts()
        {
            global $cnhk_slide_page;
            global $cnhk_ss_page;
            
            $options = $this->data_obj->get_data();
            $screen = get_current_screen();
            if ($screen->id == $cnhk_slide_page) {
                $flash = 'true';
                if ((isset($_GET['noflash']) && 1 == $_GET['noflash']) || false == $options['options']['flash'])
                    $flash = 'false';
                ?>
                    <script type="text/javascript">
                        var cnhkSlidesData = 
                        {
                            sid : '<?php echo session_id(); ?>',
                            url	: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                            uploadifyUrl : '<?php echo CNHK_UPLOADIFY_URL; ?>',
                            flash : <?php echo $flash; ?>,
                            flashYes : '<?php echo $this->common_texts['flash_yes']; ?>',
                            uploadDir : '<?php echo rawurlencode(CNHK_UPLOAD_DIR); ?>',
                            adminSlidesUrl : '<?php echo CNHK_SLIDES_URL; ?>',
                            uploadUrl : '<?php echo CNHK_UPLOAD_URL; ?>',
                            nonce : '<?php echo $this->get_nonce(); ?>',
                            fileTypeError : '<?php echo $this->common_texts['file_types']; ?>',
                            textEdit : '<?php echo $this->common_texts['Edit']; ?>',
                            textUpdated : '<?php echo $this->common_texts['updated']; ?>',
                            textDelete : '<?php echo $this->common_texts['Delete']; ?>',
                            textSave : '<?php echo $this->common_texts['Save']; ?>',
                            textCancel : '<?php echo $this->common_texts['Cancel']; ?>',
                            textTitle : '<?php echo $this->common_texts['Title']; ?>',
                            textLink : '<?php echo $this->common_texts['Link']; ?>',
                            textNoCaption : '<?php echo $this->common_texts['NoCaption']; ?>',
                            textSecurity : '<?php echo $this->common_texts['Security']; ?>',
                            imgUrl : '<?php echo CNHK_IMG_URL; ?>',
                        }
                    </script>
                <?php
            }
            
            if ($screen->id == $cnhk_ss_page) {
            ?>
            <script type="text/javascript">
                var cnhkSlideshowData =
                {
                    nonce : '<?php echo $this->get_nonce(); ?>',
                }
            </script>
            <?php
            }
            
        }
        
        /**
        * Return the css class for slide's thumbnail
        * @param string $scr, the file name with absolute path
        */
        public function thumb_class($src)
        {
            if (file_exists(CNHK_UPLOAD_DIR . $src)) {
                $size = getimagesize(CNHK_UPLOAD_DIR . $src);
                if ($size[0] >= $size[1]) {
                    return 'thumb-400';
                } else {
                    return 'thumb-220';
                }
            } else {
                return false;
            }
        }
        
        /**
        * Admin panel init
        */
        public function admin_init()
        {
            $this->form_submission();
            if (isset($_SESSION['cnhk']['savepost'])) {
                $_POST = $_SESSION['cnhk']['savepost'];
                unset($_SESSION['cnhk']['savepost']);
            }
            $this->nonce = wp_create_nonce('cnhk_nonce');
        }
        
        /**
        * Returns the nonce value
        */
        public function get_nonce()
        {
            return $this->nonce;
        }
        
        /**
        * Refresh the page after form submission
        */
        public function redirect()
        {
            $_SESSION['cnhk']['notices'] = $this->admin_notices;
            $_SESSION['cnhk']['template'] = $this->incl_template;
            $_SESSION['cnhk']['savepost'] = $_POST;
            $running = $_SERVER['PHP_SELF'];
            if (! empty($_SERVER['QUERY_STRING']))
            {
                $running .= '?' . $_SERVER['QUERY_STRING'];
            }
            wp_redirect($running);
            die();
        }
        
        /**
        * Treatment of the submited form data and dipsplay the next page in the process.
        */
        public function form_treatment()
        {
            $options = $this->data_obj->get_data();
            
            if (isset($_POST['cnhk-nonce-edit'])) {
                $current_slug = $_POST['slug'];
                $new_title = $_POST['title'];
                $new_link = $_POST['link'];
                $new_caption = $_POST['slidecaption'];
                if ($this->data_obj->is_valid_slide_title($new_title, $current_slug)) {
                    // No filename conflict
                    if ($this->data_obj->edit_slide($new_title, $new_link, $current_slug, $new_caption)) {
                        $this->append_notice($this->common_texts['updated'], 'updated');
                        $this->incl_template['name'] = 'admin-slides.php';
                    } else {
                        $this->append_notice(__('The file could not be renamed.', CNHK_TEXTDOMAIN));
                        $this->incl_template['name'] = 'admin-slides-edit.php';
                        $data = array(
                            'slide' => $options['slides'][$current_slug],
                            'slug' => $current_slug,
                        );
                        $this->incl_template['data'] = $data;
                    }
                } else {
                    // The new slug matches with another existing file
                    $this->append_notice($this->common_texts['invalid_slide_title']);
                    $this->incl_template['name'] = 'admin-slides-edit.php';
                    $data = array(
                        'slide' => $options['slides'][$current_slug],
                        'slug' => $current_slug,
                    );
                    $this->incl_template['data'] = $data;
                }
            } // END isset $_POST['cnhk-nonce-edit']
            
            if (isset($_POST['cnhk-nonce-delete'])) {
                $slide = $options['slides'][$_POST['slug']];
                if (file_exists(CNHK_UPLOAD_DIR . $slide['src'])) {
                    if (unlink(CNHK_UPLOAD_DIR . $slide['src'])) {
                        $this->data_obj->delete_slide($_POST['slug']);
                        $this->append_notice($this->common_texts['updated'], 'updated');
                    } else {
                        $this->append_notice(__('The file could not be removed.', CNHK_TEXTDOMAIN));
                    }
                } else {
                
                }
            } // END isset $_POST['cnhk-nonce-delete']
            
            if (isset($_POST['cnhk-nonce-setting'])) {
                if (isset($_POST['create-ss']) && !empty($_POST['new-ss'])) {
                    // Add new slideshow
                    $slug = $this->data_obj->sanitize($_POST['new-ss']);
                    if (!isset($options['slideshows'][$slug])) {
                        $this->data_obj->add_slideshow($_POST['new-ss']);
                        $_POST['target'] = $slug;
                        $this->append_notice($this->common_texts['updated'], 'updated');
                    } else {
                        $this->append_notice(__('Another slideshow uses an approximately similar name. Please choose another one.', CNHK_TEXTDOMAIN));
                    }
                } // END slideshow creation
                
                if (isset($_POST['delete-ss']) && isset($options['slideshows'][$_POST['target']])) {
                    $this->incl_template['name'] = 'admin-slideshow-delete.php';
                } // END slideshow deletion
                
                if (isset($_POST['delete-ss-submit'])) {
                    if (isset($options['slideshows'][$_POST['target']])) {
                        $this->data_obj->delete_slideshow($_POST['target']);
                        $this->append_notice($this->common_texts['updated'], 'updated');
                    } else {
                        $this->append_notice($this->common_texts['Security']);
                    }
                } // END slideshow deletion confirmation
                
                if (isset($_POST['save-ss']) && isset($options['slideshows'][$_POST['target']])) {
                    if (isset($_POST['order'])) {
                        $this->data_obj->edit_slides_order($_POST['target'], $_POST['order']);
                        $this->append_notice($this->common_texts['updated'], 'updated');
                    } // END save slides order
                    
                    if (isset($_POST['fx'])) {
                        $setting = array();
                        
                        $effects = $this->data_obj->get_effects();
                        if (in_array($_POST['fx'], $effects)) {
                            $setting['fx'] = $_POST['fx'];
                        }
                        
                        $speed = $this->data_obj->parse_int($_POST['speed']);
                        if (false !== $speed) {
                            $setting['speed'] = abs($speed);
                        }
                        
                        $timeout = $this->data_obj->parse_int($_POST['timeout']);
                        if (false !== $timeout) {
                            $setting['timeout'] = abs($timeout);
                        }
                        
                        if (isset($_POST['pager'])) {
                            $setting['pager'] = true;
                        } else {
                            $setting['pager'] = false;
                        }
                        
                        if (isset($_POST['nav'])) {
                            $setting['nav'] = true;
                        } else {
                            $setting['nav'] = false;
                        }
                        
                        $delay = $this->data_obj->parse_int($_POST['delay']);
                        if (false !== $delay) {
                            $setting['delay'] = $delay;
                        }
                        
                        if (isset($_POST['skip'])) {
                            $setting['skip'] = true;
                        } else {
                            $setting['skip'] = false;
                        }
                        
                        $this->data_obj->slideshow_settings($setting, $_POST['target']);
                        $this->append_notice($this->common_texts['updated'], 'updated');
                        
                    }// END save setting
                } // END slideshow saving
                
                $this->redirect();
                
            } // END isset $_POST['cnhk-nonce-setting']
            
        }
        
        /**
        * Refresh the page after a form submission
        */
        public function form_submission()
        {
            if (isset($_POST['cnhk-slides-nonce'])) {
                if (empty($_FILES['slides-file']['name'])) {
                    $this->append_notice(__('Please choose a file.', CNHK_TEXTDOMAIN));
                    $this->redirect();
                }
                if (1 === wp_verify_nonce($_POST['cnhk-slides-nonce'], 'cnhk_nonce')) {
                    $tmp_name = $_FILES['slides-file']['tmp_name'];
                    $nb = 1;
                    while (file_exists(CNHK_UPLOAD_DIR . "slide{$nb}.jpg") || file_exists(CNHK_UPLOAD_DIR . "slide{$nb}.png")) {
                        $nb++;
                    }
                    $has_error = false;
                    $erro_html = '';
                    $file_types = array('jpeg', 'jpg', 'png');
                    $file_parts = pathinfo($_FILES['slides-file']['name']);
                    $file_ext = strtolower($file_parts['extension']);
                    
                    if (!in_array($file_ext, $file_types)) {
                        $has_error = true;
                        $error_html = $this->common_texts['file_types'];
                    }
                    
                    $extension = 'png';
                    if ('jpeg' == $file_ext || 'jpg' == $file_ext)
                        $extension = 'jpg';
                    
                    $target_file_name = 'slide' . $nb . '.' . $extension;
                    $target = CNHK_UPLOAD_DIR . $target_file_name;
                    
                    if (!$has_error) {
                        if (move_uploaded_file($tmp_name, $target)) {
                            $this->data_obj->add_slide('slide' . $nb, $extension);
                            $this->append_notice(__('New slide added', CNHK_TEXTDOMAIN), 'updated');
                        } else {
                            $this->append_notice(__('There was a problem when processing. Please try again.', CNHK_TEXTDOMAIN));
                        }
                    } else {
                        $this->append_notice($this->common_texts['file_types']);
                    }
                }
                $this->redirect();
            }
            
            if (isset($_POST['cnhk-nonce-edit'])) {
                if (1 === wp_verify_nonce($_POST['cnhk-nonce-edit'], 'cnhk-nonce-edit')) {
                    $this->form_treatment();
                    $this->redirect();
                }
            }
            
            if (isset($_POST['cnhk-nonce-delete'])) {
                if (1 === wp_verify_nonce($_POST['cnhk-nonce-delete'], 'cnhk-nonce-delete')) {
                    $this->form_treatment();
                    $this->redirect();
                }
            }
            
            if (isset($_POST['cnhk-nonce-setting'])) {
                if (1 === wp_verify_nonce($_POST['cnhk-nonce-setting'], 'cnhk_nonce')) {
                    $this->form_treatment();
                    $this->redirect();
                }
            }
        }
        
        /**
        * add an admin notice
        * @param string $message, the message to display
        * @param string type
        */
        public function append_notice($message, $type='error')
        {
            $this->admin_notices .= "<div class='$type'><p>$message</p></div>";
        }
        
        /**
        * Display admin notice
        */
        public function display_notices()
        {
            if (!empty($this->admin_notices)) {
                echo $this->admin_notices;
            }
        }
        
        /**
        * Return the w/h ratio of the first slide in a slideshow
        */
        public function get_ratio($slug) {
            $options = $this->data_obj->get_data();
            if (!isset($options['slideshows'][$slug]) || array() == $options['slideshows'][$slug]['slides']) {
                return false;
            }
            $first = &$options['slideshows'][$slug]['slides'][0];
            $size = getimagesize(CNHK_UPLOAD_DIR . $options['slides'][$first]['src']);
            return $size[0]/$size[1];
        }        
        
    }
}
