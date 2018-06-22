<?php

if (!current_user_can('activate_plugins')) {
    die('The account you\'re logged in to doesn\'t have permission to access this page.');
}

function grw_has_valid_nonce() {
    $nonce_actions = array('grw_reset', 'grw_settings', 'grw_active');
    $nonce_form_prefix = 'grw-form_nonce_';
    $nonce_action_prefix = 'grw-wpnonce_';
    foreach ($nonce_actions as $key => $value) {
        if (isset($_POST[$nonce_form_prefix.$value])) {
            check_admin_referer($nonce_action_prefix.$value, $nonce_form_prefix.$value);
            return true;
        }
    }
    return false;
}

if (!empty($_POST)) {
    $nonce_result_check = grw_has_valid_nonce();
    if ($nonce_result_check === false) {
        die('Unable to save changes. Make sure you are accessing this page from the Wordpress dashboard.');
    }
}

// Reset
if (isset($_POST['reset'])) {
    foreach (grw_options() as $opt) {
        delete_option($opt);
    }
    if (isset($_POST['reset_db'])) {
        grw_reset_db();
    }
    unset($_POST);
?>
<div class="wrap">
    <h3><?php echo grw_i('Google Reviews Widget Reset'); ?></h3>
    <form method="POST" action="?page=grw">
        <?php wp_nonce_field('grw-wpnonce_grw_reset', 'grw-form_nonce_grw_reset'); ?>
        <p><?php echo grw_i('Google Reviews Widget has been reset successfully.') ?></p>
        <ul style="list-style: circle;padding-left:20px;">
            <li><?php echo grw_i('Local settings for the plugin were removed.') ?></li>
        </ul>
        <p>
            <?php echo grw_i('If you wish to reinstall, you can do that now.') ?>
            <a href="?page=grw">&nbsp;<?php echo grw_i('Reinstall') ?></a>
        </p>
    </form>
</div>
<?php
die();
}

// Post fields that require verification.
$valid_fields = array(
    'grw_active' => array(
        'key_name' => 'grw_active',
        'values' => array('Disable', 'Enable')
    ));

// Check POST fields and remove bad input.
foreach ($valid_fields as $key) {

    if (isset($_POST[$key['key_name']]) ) {

        // SANITIZE first
        $_POST[$key['key_name']] = trim(sanitize_text_field($_POST[$key['key_name']]));

        // Validate
        if ($key['regexp']) {
            if (!preg_match($key['regexp'], $_POST[$key['key_name']])) {
                unset($_POST[$key['key_name']]);
            }

        } else if ($key['type'] == 'int') {
            if (!intval($_POST[$key['key_name']])) {
                unset($_POST[$key['key_name']]);
            }

        } else {
            $valid = false;
            $vals = $key['values'];
            foreach ($vals as $val) {
                if ($_POST[$key['key_name']] == $val) {
                    $valid = true;
                }
            }
            if (!$valid) {
                unset($_POST[$key['key_name']]);
            }
        }
    }
}

if (isset($_POST['grw_active']) && isset($_GET['grw_active'])) {
    update_option('grw_active', ($_GET['grw_active'] == '1' ? '1' : '0'));
}

if (isset($_POST['grw_setting'])) {
    update_option('grw_google_api_key', $_POST['grw_google_api_key']);
}

wp_enqueue_script('jquery');

wp_register_script('grp_bootstrap_js', plugins_url('/static/js/bootstrap.min.js', __FILE__));
wp_enqueue_script('grp_bootstrap_js', plugins_url('/static/js/bootstrap.min.js', __FILE__));
wp_register_style('grp_bootstrap_css', plugins_url('/static/css/bootstrap.min.css', __FILE__));
wp_enqueue_style('grp_bootstrap_css', plugins_url('/static/css/bootstrap.min.css', __FILE__));

wp_register_script('grp_place_finder_js', plugins_url('/static/js/grp-place-finder.js', __FILE__));
wp_enqueue_script('grp_place_finder_js', plugins_url('/static/js/grp-place-finder.js', __FILE__));

wp_register_style('grp_setting_css', plugins_url('/static/css/grp-setting.css', __FILE__));
wp_enqueue_style('grp_setting_css', plugins_url('/static/css/grp-setting.css', __FILE__));
wp_register_style('grp_place_widget_css', plugins_url('/static/css/grp-place-widget.css', __FILE__));
wp_enqueue_style('grp_place_widget_css', plugins_url('/static/css/grp-place-widget.css', __FILE__));

$grw_enabled = get_option('grw_active') == '1';
$grw_google_api_key = get_option('grw_google_api_key');
if (strlen($grw_google_api_key) == 0) {
    $grw_google_api_key = grw_google_api_key();
}
?>

<span class="version"><?php echo grw_i('Free Version: %s', esc_html(GRW_VERSION)); ?></span>
<div class="grp-setting container-fluid">
    <img src="<?php echo GRW_PLUGIN_URL . '/static/img/google.png'; ?>" alt="Google">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#about" aria-controls="about" role="tab" data-toggle="tab"><?php echo grw_i('About'); ?></a>
        </li>
        <li role="presentation">
            <a href="#setting" aria-controls="setting" role="tab" data-toggle="tab"><?php echo grw_i('Setting'); ?></a>
        </li>
        <li role="presentation">
            <a href="#shortcode" aria-controls="shortcode" role="tab" data-toggle="tab"><?php echo grw_i('Shortcode Builder'); ?></a>
        </li>
        <li role="presentation">
            <a href="#mod" aria-controls="mod" role="tab" data-toggle="tab"><?php echo grw_i('Review Moderation'); ?></a>
        </li>
        <li role="presentation">
            <a href="#support" aria-controls="support" role="tab" data-toggle="tab"><?php echo grw_i('Live Support'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="about">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?php echo grw_i('Google Reviews Widget for WordPress'); ?></h4>
                    <p><?php echo grw_i('Google Reviews plugin is an easy and fast way to integrate Google business reviews right into your WordPress website. This plugin works instantly and keep all Google places and reviews in WordPress database thus it has no depend on external services.'); ?></p>
                    <h4>Use cases</h4>
                    <p>There have two main use cases of using Google Reviews Widget. Use as widget in sidebar or shortcode in any side.</p>
                    <h5>Sidebar widget</h5>
                    <p>To use it as a widget, please do follow:</p>
                    <ol>
                        <li>Go to menu <b>"Appearance"</b> -> <b>"Widgets"</b></li>
                        <li>Move "Google Reviews Widget" widget to sidebar</li>
                        <li>Enter search query of your business place in "Google Place Search Query" field and click "Search Place"</li>
                        <li>Select your found place in the panel below and click "Save Place and Reviews"</li>
                        <li>"Google Place Name" and "Google Place ID" must be filled, if so click "Save" button below</li>
                    </ol>
                    <h5>Shortcode</h5>
                    <p>Available in Google Reviews Pro version: <a href="https://richplugins.com/google-reviews-pro-wordpress-plugin" target="_blank" style="color:#00bf54;font-size:16px;text-decoration:underline;"><?php echo grw_i('Upgrade to Pro'); ?></a></p>
                    <p><?php echo grw_i('Feel free to contact us by email <a href="mailto:support@richplugins.com">support@richplugins.com</a>.'); ?></p>
                    <p><?php echo grw_i('<b>Like this plugin? Give it a like on social:</b>'); ?></p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.6&appId=1501100486852897";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-like" data-href="https://richplugins.com/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                        </div>
                        <div class="col-sm-4 twitter">
                            <a href="https://twitter.com/richplugins" class="twitter-follow-button" data-show-count="false">Follow @RichPlugins</a>
                            <script>!function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = p + '://platform.twitter.com/widgets.js';
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }
                                }(document, 'script', 'twitter-wjs');</script>
                        </div>
                        <div class="col-sm-4 googleplus">
                            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="200" data-href="https://plus.google.com/101080686931597182099"></div>
                            <script type="text/javascript">
                                window.___gcfg = { lang: 'en-US' };
                                (function () {
                                    var po = document.createElement('script');
                                    po.type = 'text/javascript';
                                    po.async = true;
                                    po.src = 'https://apis.google.com/js/plusone.js';
                                    var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(po, s);
                                })();
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <br>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="//www.youtube.com/embed/lmaTBmvDPKk?rel=0" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Get More Features with Google Reviews Pro!</h4>
            <p><a href="https://richplugins.com/google-reviews-pro-wordpress-plugin" target="_blank" style="color:#00bf54;font-size:16px;text-decoration:underline;">Upgrade to Google Reviews Pro</a></p>
            <p>* Pure self-hosted plugin, keep all reviews in  WordPress database</p>
            <p>* Auto-download new Google reviews daily</p>
            <p>* Collect more than 5 Google reviews</p>
            <p>* Supports Google Rich Snippets (schema.org)</p>
            <p>* Grid theme to show G+ reviews in testimonials section</p>
            <p>* 'Write a review' button to available leave Google review on your website</p>
            <p>* Minimum Rating filter</p>
            <p>* Custom business place photo</p>
            <p>* Pagination, Sorting</p>
            <p>* Priority support</p>
        </div>
        <div role="tabpanel" class="tab-pane" id="setting">
            <h4><?php echo grw_i('Google Reviews Widget Setting'); ?></h4>
            <!-- Configuration form -->
            <form method="POST" enctype="multipart/form-data">
            <?php wp_nonce_field('grw-wpnonce_grw_settings', 'grw-form_nonce_grw_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row" valign="top"><?php echo grw_i('Google API Key'); ?></th>
                        <td>
                            <input type="text" name="grw_google_api_key" value="<?php echo esc_attr($grw_google_api_key); ?>"/>
                            <br>
                            <?php echo grw_i('Google Places API Key. To get own key go to <a href="https://console.developers.google.com/flows/enableapi?apiid=places_backend&keyType=SERVER_SIDE&reusekey=true" target="_blank">Get Google API Key</a> and follow the instructions.'); ?>
                        </td>
                    </tr>
                </table>
                <p class="submit" style="text-align: left">
                    <input name="grw_setting" type="submit" value="Save" class="button-primary button" tabindex="4">
                </p>
            </form>
            <hr>
            <!-- Enable/disable Google Reviews Widget toggle -->
            <form method="POST" action="?page=grw&amp;grw_active=<?php echo (string)((int)($grw_enabled != true)); ?>">
                <?php wp_nonce_field('grw-wpnonce_grw_active', 'grw-form_nonce_grw_active'); ?>
                <span class="status">
                    <?php echo grw_i('Google Reviews Widget are currently '). ($grw_enabled ? grw_i('enable') : grw_i('disable')); ?>
                </span>
                <input type="submit" name="grw_active" class="button" value="<?php echo $grw_enabled ? grw_i('Disable') : grw_i('Enable'); ?>" />
            </form>
            <hr>
            <form action="?page=grw" method="POST">
                <?php wp_nonce_field('grw-wpnonce_grw_reset', 'grw-form_nonce_grw_reset'); ?>
                <p>
                    <input type="submit" value="Reset" name="reset" onclick="return confirm('<?php echo grw_i('Are you sure you want to reset the Google Reviews Widget plugin?'); ?>')" class="button" />
                    <?php echo grw_i('This removes all plugin-specific settings.') ?>
                </p>
                <p>
                    <input type="checkbox" id="reset_db" name="reset_db">
                    <label for="reset_db"><?php echo grw_i('Remove all data including Google Reviews'); ?></label>
                </p>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane" id="mod">
            <h4><?php echo grw_i('Moderation available in Google Reviews Pro plugin:'); ?></h4>
            <a href="https://richplugins.com/google-reviews-pro-wordpress-plugin" target="_blank" style="color:#00bf54;font-size:16px;text-decoration:underline;"><?php echo grw_i('Upgrade to Pro'); ?></a>
        </div>
        <div role="tabpanel" class="tab-pane" id="shortcode">
            <h4><?php echo grw_i('Shortcode Builder available in Google Reviews Pro plugin:'); ?></h4>
            <a href="https://richplugins.com/google-reviews-pro-wordpress-plugin" target="_blank" style="color:#00bf54;font-size:16px;text-decoration:underline;"><?php echo grw_i('Upgrade to Pro'); ?></a>
        </div>
        <div role="tabpanel" class="tab-pane" id="support">
            <h4><?php echo grw_i('Live Chat support available in Google Reviews Pro plugin:'); ?></h4>
            <a href="https://richplugins.com/google-reviews-pro-wordpress-plugin" target="_blank" style="color:#00bf54;font-size:16px;text-decoration:underline;"><?php echo grw_i('Upgrade to Pro'); ?></a>
        </div>
    </div>
</div>
