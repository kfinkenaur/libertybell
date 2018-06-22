<?php
/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
if (!class_exists('CNHKSS_AJAX')) {
    class CNHKSS_AJAX
    {        
        /**
        * Reference to the slideshow object
        */
        private $ss_obj = null;
        
        /**
        * Reference to the data object
        */
        private $data_obj = null;
        
        /**
        * Constructor
        * @param &$ss, an instance of the main plugin class
        * @param &$data, an instance of the data class
        */
        public function __construct(&$ss, &$data)
        {
            $this->ss_obj = $ss;
            $this->data_obj = $data;            
            
            add_action('wp_ajax_cnhk_after_upload', array($this, 'after_upload'));
            add_action('wp_ajax_cnhk_switch_flash', array($this, 'switch_flash'));
            add_action('wp_ajax_cnhk_title_action', array($this, 'title_action'));
            add_action('wp_ajax_cnhk_link_action', array($this, 'link_action'));
            add_action('wp_ajax_cnhk_caption_action', array($this, 'caption_action'));
        }
        
        /**
        * Add new slide in database after uploading a slide.
        */
        public function after_upload()
        {
            if (isset($_POST['nonce']) && $_POST['nonce'] == $_SESSION['cnhk']['nonce']) {
                
                $this->data_obj->add_slide($_POST['name'], $_POST['extension']);
                
                $css_class = $_POST['css'];
                
                $response = json_encode(array(
                        'status' => true,
                        'slug' => $_POST['name'],
                        'type' => $_POST['extension'],
                        'caption' => $this->ss_obj->common_texts['NoCaption'],
                        'css' => $css_class,
                    )
                );
                
                header("Content-Type: application/json");
                echo $response;
                exit;
            } else {
                $response = json_encode(array(
                        'status' => false,
                        'error' => $ss_obj->common_texts['Security'],
                    )
                );
                
                header("Content-Type: application/json");
                echo $response;
                exit;
            }
        }
        
        /**
        * Switch to the flash uploader 
        */
        public function switch_flash()
        {
            if (isset($_POST['nonce']) && 1 === wp_verify_nonce($_POST['nonce'], 'cnhk_nonce')) {
                $this->data_obj->noflash(0);
            }
        }
        
        /**
        * Dynamic title edition
        */
        public function title_action()
        {
            $options = $this->data_obj->get_data();
            if (isset($_POST['nonce']) && 1 === wp_verify_nonce($_POST['nonce'], 'cnhk_nonce')) {
                switch ($_POST['step']) {
                    case 'init' :
                        $response = json_encode(array(
                                'status' => true,
                                'slug' => $_POST['slug'],
                                'title' => stripslashes($options['slides'][$_POST['slug']]['title']),
                            )
                        );
                        
                        header("Content-Type: application/json");
                        echo $response;
                        exit;
                        break;
                    case 'submit' :
                        $current = $_POST['current_slug'];
                        if ($this->data_obj->is_valid_slide_title($_POST['value'], $current)) {
                            $old_title = esc_html($options['slides'][$current]['title']);
                            $this->data_obj->edit_slide($_POST['value'], rawurldecode($options['slides'][$current]['link']), $current, $options['slides'][$current]['caption']);
                            $new_slug = $this->data_obj->sanitize($_POST['value']);
                            $response = json_encode(array(
                                    'status' => true,
                                    'message' => $this->ss_obj->common_texts['updated'],
                                    'oldSlug' => $current,
                                    'newSlug' => $new_slug,
                                    'newSrc' => CNHK_UPLOAD_DIR . $options['slides'][$current]['src'],
                                    'oldTitle' => $old_title,
                                    'title' => esc_html(stripslashes($_POST['value'])),
                                    'link' => rawurldecode($options['slides'][$current]['link']),
                                    'caption' => $options['slides'][$current]['caption'],
                                )
                            );
                            
                            header("Content-Type: application/json");
                            echo $response;
                            exit;
                            break;
                        } else {
                            $response = json_encode(array(
                                    'status' => false,
                                    'error' => $this->ss_obj->common_texts['invalid_slide_title'],
                                )
                            );
                            
                            header("Content-Type: application/json");
                            echo $response;
                            exit;
                            break;
                        }
                    default :
                }
            }
        }
        
        /**
        * Dynamic link edition
        */
        public function link_action()
        {
            $options = $this->data_obj->get_data();
            if (isset($_POST['nonce']) && 1 === wp_verify_nonce($_POST['nonce'], 'cnhk_nonce')) {
                switch ($_POST['step']) {
                    case 'init' :
                        $link = ($this->ss_obj->common_texts['NoLink'] == rawurldecode($options['slides'][$_POST['slug']]['link'])) ? '' : rawurldecode($options['slides'][$_POST['slug']]['link']);
                        $response = json_encode(array(
                                'status' => true,
                                'slug' => $_POST['slug'],
                                'link' => $link,
                            )
                        );
                        
                        header("Content-Type: application/json");
                        echo $response;
                        exit;
                        break;
                    case 'submit' :
                    $current = $_POST['current_slug'];
                        $this->data_obj->edit_slide($options['slides'][$current]['title'], $_POST['value'], $current, $options['slides'][$current]['caption']);
                        $new_link = (empty($_POST['value'])) ? $this->ss_obj->common_texts['NoLink'] : $_POST['value'];
                        $response = json_encode(array(
                                'status' => true,
                                'message' => $this->ss_obj->common_texts['updated'],
                                'oldSlug' => $current,
                                'newSlug' => $current,
                                'title' => esc_html(stripslashes($options['slides'][$current]['title'])),
                                'link' => $new_link,
                                'caption' => $options['slides'][$current]['caption'],
                            )
                        );
                        
                        header("Content-Type: application/json");
                        echo $response;
                        exit;
                        break;
                    default :
                }
            }
        }
        
        /**
        * Dynamic Caption edition
        */
        public function caption_action()
        {
            $options = $this->data_obj->get_data();
            if (isset($_POST['nonce']) && 1 === wp_verify_nonce($_POST['nonce'], 'cnhk_nonce')) {
                $slide = $options['slides'][$_POST['slug']];
                $response = null;
                $caption = (empty($_POST['caption'])) ? $this->ss_obj->common_texts['NoCaption'] : $_POST['caption'];
                if ($this->data_obj->edit_slide($slide['title'], rawurldecode($slide['link']), $_POST['slug'], $caption)) {
                    $response = json_encode(array(
                            'status' => true,
                            'message' => $this->ss_obj->common_texts['updated'],
                            'slug' => $_POST['slug'],
                            'caption' => $caption,
                        )
                    );
                } else {
                    $response = json_encode(array(
                            'status' => false,
                            'slug' => $_POST['slug'],
                            'message' => $this->ss_obj->common_texts['NoUpdate'],
                        )
                    );
                }
                
                header("Content-Type: application/json");
                echo $response;
                exit;
                
            }
        }
    }
}
