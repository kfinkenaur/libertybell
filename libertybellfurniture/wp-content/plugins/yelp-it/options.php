<?php

// Admin options page. Creates a page to set your OAuth settings for the Yelp API v2.
// @TODO: After everyone has upgraded from 0.2, take out the legacy support

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

register_activation_hook(__FILE__, 'yelpit_activate');
register_uninstall_hook(__FILE__, 'yelpit_uninstall');
add_action('admin_init', 'yelpit_init');
add_action('admin_menu', 'yelpit_add_options_page');

// Delete options when uninstalled
function yelpit_uninstall() {
    delete_option('yelpit_settings');
    delete_option('yelp_consumer_key');
    delete_option('yelp_consumer_secret');
    delete_option('yelp_token');
    delete_option('yelp_token_secret');
    delete_option('yelp_open_new_window'); // Open yelp links in new windows
}

// Instantiate array of settings when installed
function yelpit_activate() {
    $options = get_option('yelpit_settings');
    
    // If the setting isn't already an array, it was never instantiated
    if (!is_array($options)) { 
        $arr = array(
            'yelp_consumer_key'     => '',
            'yelp_consumer_secret'  => '',
            'yelp_token'            => '',
            'yelp_token_secret'     => '',
            'yelp_open_new_window'  => false
        );
        
        update_option('yelpit_settings', $arr);
    } else {
        // Adding new option to open in new window.
        if (!isset($options['yelp_open_new_window'])) {
            $options['yelp_open_new_window'] = false;
            
            update_option('yelpit_settings', $options);
        }
    }
}

// Purely for debugging, do not uncomment this unless you want to delete all your settings
// yelpit_uninstall();

function yelpit_add_options_page() {
    // Add the menu option under Settings, shows up as "Yelp API Settings" (second param)
    add_submenu_page('plugins.php', 'Yelp API Settings', 'Yelp Config', 'manage_options', 'yelpit', 'yelpit_options_form');
}

function yelpit_init() {
    // Register the yelpit settings as a group
    register_setting('yelpit_settings', 'yelpit_settings');
    // For users who installed plugin before install hook existed, 
    // remove later
    yelpit_activate(); 
    cleanup_yelpit_legacy();
}

// Cleanup old style of storing config options
function cleanup_yelpit_legacy() {
    $tmp = get_option('yelpit_settings');
    // If the new style has been set, cleanup old ones.
    if (($tmp['yelp_consumer_key']) != '') {
        delete_option('yelp_consumer_key');
    }
    
    if ($tmp['yelp_consumer_secret'] != '') {
        delete_option('yelp_consumer_secret');
    }
    
    if ($tmp['yelp_token'] != '') {
        delete_option('yelp_token');
    }
    
    if ($tmp['yelp_token_secret'] != '') {
        delete_option('yelp_token_secret');
    }
}

// Output the yelpit option setting value
function yelpit_option($setting, $options) {
    // If the old setting is set, output that
    if (get_option($setting) != '') {
        echo get_option($setting);
    } else if (is_array($options)) {
        echo $options[$setting];
    }
}

// Generate the admin form
function yelpit_options_form() {

?>
    <style type="text/css">
        .notice {
            font-weight: bold;
            font-size: 18px;
            color: green;
        }
        
        .control-group {
            margin-bottom: 10px;
        }
    
        .control-label {
            clear: left;
            width: 200px;
            display: inline-block;
            vertical-align: top;
        }
        
        .controls {
            display: inline-block;
        }
        
        input {
            width: 280px;
        }
        
        input[type=text] {
            font-family: Inconsolata, Monaco, monospace;
            font-size: 14px;
        }
        
        input.button-primary {
            clear: left;
            width: auto;
            display: block;
        }
        
        .help-block {
            color: #999;
            font-size: 85%;
            margin-top: 2px;
        }
        
        .label {
          padding: 2px 4px 3px;
          font-size: 85%;
          font-weight: bold;
          color: #fff;
          text-shadow: 0 -1px 0 rgba(0,0,0,.25);
          background-color: #B94A48;
          -webkit-border-radius: 3px;
          -moz-border-radius: 3px;
          border-radius: 3px;
        }
        
    </style>
    <div class="wrap">
        <h2>Yelp API Settings</h2>
        
        <p>Populate these fields with your Yelp API (v2) OAuth settings. You can get or manage these by going to the "<a href="http://www.yelp.com/developers/manage_api_keys" target="_blank">Manage API Keys</a>" page when you are signed in to Yelp.
        </p>
        <form id="yelp-settings" method="post" action="options.php">
            
            <?php 
                // Tells Wordpress that the options we registered are being
                // handled by this form
                settings_fields('yelpit_settings');
                
                // Retrieve stored options, if any
                $options = get_option('yelpit_settings');
                
                // Debug, show stored options
                // echo '<pre>'; print_r($options); echo '</pre>';
            ?>
            
            <div class="control-group">
                <div class="control-label">
                    <label for="yelp_consumer_key">
                        Consumer Key
                    </label>
                </div>
                <div class="controls">
                    <input type="text" id="yelp_consumer_key"
                        name="yelpit_settings[yelp_consumer_key]"
                        value="<?php yelpit_option('yelp_consumer_key', $options); ?>"
                    />
                </div>
            </div>
            
            <div class="control-group">
                <div class="control-label">
                    <label for="yelp_consumer_secret">
                        Consumer Secret
                    </label>
                </div>
                <div class="controls">
                    <input type="text" id="yelp_consumer_secret"
                        name="yelpit_settings[yelp_consumer_secret]"
                        value="<?php 
                            yelpit_option('yelp_consumer_secret', $options); 
                        ?>" 
                    />
                </div>
            </div>
            
            <div class="control-group">
                <div class="control-label">
                    <label for="yelp_token">
                        Token
                    </label>
                </div>
                <div class="controls">
                    <input type="text" id="yelp_token"
                        name="yelpit_settings[yelp_token]"
                        value="<?php yelpit_option('yelp_token', $options); ?>" 
                    />
                </div>
            </div>
            
            <div class="control-group">
                <div class="control-label">
                    <label for="yelp_token_secret">
                        Token Secret
                    </label>
                </div>
                <div class="controls">
                    <input type="text" id="yelp_token_secret"
                        name="yelpit_settings[yelp_token_secret]" 
                        value="<?php 
                            yelpit_option('yelp_token_secret', $options); 
                        ?>" 
                    />
                </div>
            </div>
            
            <div class="control-group">
                <div class="control-label">
                    <label for="yelp_open_new_window">
                        Open Yelp links in new window 
                    </label>
                </div>
                <div class="controls">
                    <input type="checkbox" id="yelp_open_new_window"
                        name="yelpit_settings[yelp_open_new_window]" 
                        value="1"
                        <?php 
                            checked(
                                1,
                                $options['yelp_open_new_window']
                            );
                        ?>
                    />
                    <p class="help-block">
                        <span class="label label-warn">Warning</span>
                        Make sure your users <a target="_blank"  href="http://uxdesign.smashingmagazine.com/2008/07/01/should-links-open-in-new-windows/">actually want this</a>
                    </p>
                </div>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <input class="button-primary" type="submit" name="submit"
                        value="<?php _e('Save Changes'); ?>" />
                </div>
            </div>
        </form>
    </div>
    <script>
        (function() {
            if (jQuery) {
                var $ = jQuery,
                    $form = $("#yelp-settings"),
                    $notice = $('<div class="notice">Saved</div>');
                    
                $form.submit(function() {
                    $form.append($notice);
                    $notice.fadeOut(5000);
                });
            }
        })();
    </script>
<?php
}
?>