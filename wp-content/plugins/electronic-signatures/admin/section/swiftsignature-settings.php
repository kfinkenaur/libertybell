<?php
/*
 *      Swift Signature Setting page
 */

function ssign_settings_cb() {
    $SSIGN_MESSAGES = swiftsign_global_msg();

    wp_enqueue_style('swift-toggle-style', plugins_url('/css/sc_rcswitcher.css', __FILE__), '', '', '');
    wp_enqueue_script('swift-toggle', plugins_url('/js/sc_rcswitcher.js', __FILE__), array('jquery'), '', true);

    $get_ssing_date_format = get_option("ssing_date_format");
    $get_ssing_work_with = get_option("ssing_work_with");
    $ssing_auto_generate_sign = get_option("ssing_auto_generate_sign");
    $ssing_google_map_api_key = get_option("ssing_google_map_api_key");
    $ssing_dashboard_widget_flag = get_option("ssing_dashboard_widget_flag");

    if (isset($_POST['save_ssing_settings']) && wp_verify_nonce($_POST['save_ssing_settings'], 'save_ssing_settings')) {
        $ssing_date_format = (isset($_POST['ssing_google_map_api_key']) && !empty($_POST['ssing_google_map_api_key'])) ? $_POST['ssing_date_format'] : "mm-dd-yy";
        $ssing_work_with = (isset($_POST['ssing_work_with']) && !empty($_POST['ssing_work_with'])) ? $_POST['ssing_work_with'] : "Consumers";
        $ssing_auto_generate_sign = (isset($_POST['ssing_auto_generate_sign']) && !empty($_POST['ssing_auto_generate_sign'])) ? 1 : 0;
        $ssing_google_map_api_key = (isset($_POST['ssing_google_map_api_key']) && !empty($_POST['ssing_google_map_api_key'])) ? sanitize_text_field($_POST['ssing_google_map_api_key']) : "";
        $ssing_dashboard_widget_flag = (isset($_POST['ssing_dashboard_widget_flag']) && !empty($_POST['ssing_dashboard_widget_flag'])) ? 1 : 0;

        $update1 = update_option('ssing_date_format', $ssing_date_format);
        $update2 = update_option('ssing_auto_generate_sign', $ssing_auto_generate_sign);
        $update3 = update_option('ssing_google_map_api_key', $ssing_google_map_api_key);
        $update4 = update_option('ssing_work_with', $ssing_work_with);
        $update5 = update_option('ssing_dashboard_widget_flag', $ssing_dashboard_widget_flag);

        if ($update1 || $update2 || $update3 || $update4 || $update5) {
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_control_panel&update=1");
        }
    }
    ?>
    <div class="wrap ss-setting">
        <h2><?php echo $SSIGN_MESSAGES['ssing_page_title_setting']; ?></h2>
        <hr/>
        <?php
        if (isset($_GET['update']) && !empty($_GET['update'])) {
            if ($_GET['update'] == 1) {
                ?>
                <div id="message" class="notice notice-success is-dismissible below-h2">
                    <p><?php echo $SSIGN_MESSAGES['ssing_update_message']; ?></p>
                </div>
                <?php
            }
        }
        ?>
        <div class="inner_content">
            <div id="ssign-general-settings" class="panel">
                <form name="FrmSsignSettings" id="FrmSsignSettings" method="post">
                    <table class="form-table">
                        <tr>
                            <th><label><?php echo $SSIGN_MESSAGES['ssing_label_we_mostly_work_with']; ?> <span class="dashicons dashicons-editor-help ttip"  title="<?php echo $SSIGN_MESSAGES['ssing_label_we_mostly_work_with_tooltip']; ?>"></span>: </label></th>
                            <td>
                                <?php $checked = $get_ssing_work_with ? $get_ssing_work_with : "Consumers"; ?>
                                <label for="ssing_work_with_consumer"><input type="radio" value="Consumers" <?php checked($checked, 'Consumers'); ?> id="ssing_work_with_consumer"  name="ssing_work_with" /> Consumers</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="ssing_work_with_business"><input type="radio" value="Businesses" <?php checked($checked, 'Businesses'); ?> id="ssing_work_with_business"  name="ssing_work_with" /> Businesses</label>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php echo $SSIGN_MESSAGES['ssing_label_date_format']; ?>: </label></th>
                            <td>
                                <?php $checked = $get_ssing_date_format ? $get_ssing_date_format : "mm-dd-yy"; ?>
                                <label for="ssing_mdy_format"><input type="radio" value="mm-dd-yy" <?php checked($checked, 'mm-dd-yy'); ?> id="ssing_mdy_format"  name="ssing_date_format" /> MM-DD-YY</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="ssing_dmy_format"><input type="radio" value="dd-mm-yy" <?php checked($checked, 'dd-mm-yy'); ?> id="ssing_dmy_format"  name="ssing_date_format" /> DD-MM-YY</label>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php echo $SSIGN_MESSAGES['ssing_label_auto_generate_sign']; ?> <span class="dashicons dashicons-editor-help ttip"  title="<?php echo $SSIGN_MESSAGES['ssing_label_auto_generate_sign_tooltip']; ?>"></span>: </label></th>
                            <td>
                                <?php $ssing_auto_generate_sign_flag = ($ssing_auto_generate_sign == 1 ) ? 'checked="checked"' : ''; ?>
                                <input type="checkbox" value="1" data-ontext="ON" data-offtext="OFF" name="ssing_auto_generate_sign" id="ssing_auto_generate_sign" <?php echo $ssing_auto_generate_sign_flag; ?>>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="ssing_google_map_api_key"><?php echo $SSIGN_MESSAGES['ssing_label_google_map_api_key']; ?> <span class="dashicons dashicons-editor-help ttip"  title="<?php echo $SSIGN_MESSAGES['ssing_label_google_map_api_key_tooltip']; ?>"></span>: </label><br /><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><?php echo $SSIGN_MESSAGES['ssing_label_click_to_generate_google_api']; ?></a></th>
                            <td>
                                <input type="text" value="<?php echo $ssing_google_map_api_key; ?>" name="ssing_google_map_api_key" id="ssing_google_map_api_key" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th><label for="ssing_dashboard_widget_flag"><?php echo $SSIGN_MESSAGES['ssing_label_show_dashboard_widget']; ?></label></th>
                            <td>
                                <input type="checkbox" value="1" <?php echo (isset($ssing_dashboard_widget_flag) && !empty($ssing_dashboard_widget_flag) ? 'checked' : ''); ?> name="ssing_dashboard_widget_flag" id="ssing_dashboard_widget_flag" />
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <?php wp_nonce_field('save_ssing_settings', 'save_ssing_settings'); ?>
                                <button type="submit" class="button-primary" value="Save Settings" name="ssing_submit_settings" /><?php echo $SSIGN_MESSAGES['ssing_btn_save_settings']; ?></button>
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#ssing_auto_generate_sign:checkbox').rcSwitcher();
        });
    </script>
<?php } ?>