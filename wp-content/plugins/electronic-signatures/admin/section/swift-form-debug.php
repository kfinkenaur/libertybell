<?php
/*
 *      Debugging swift form
 */

function ssing_testing_mode_message() {
    return array(
        "btn_save_settings" => __('Save Settings', 'swiftsign'),
        "label_beta_testing" => __('Beta Sandbox Testing Mode (Not Recommended; used by staff for debugging)', 'swiftsign'),
        "alert_beta_testing_msg" => __('Alert: SwiftCloud is in Sandbox Testing Mode: %s to end beta testing mode and use the stable release.', 'swiftsign'),
        "label_testing_formid" => __('Testing formID', 'swiftsign'),
        "label_testing_capture_mode" => __('Testing capture mode', 'swiftsign'),
        "msg_testing_mode" => __('Testing mode is on.', 'swiftsign'),
        "msg_testing_mode_off" => __('Testing mode is off.', 'swiftsign'),
    );
}

if (!function_exists('ssing_testing_mode')) {

    function ssing_testing_mode() {
        $MSG = ssing_testing_mode_message();

        wp_enqueue_style('swift_form_debug_style', SWIFTSIGN_PLUGIN_URL . 'admin/css/swift-form-debug.css', '', '', '');
        wp_enqueue_script(SWIFTSIGN_PLUGIN_PREFIX . 'form_script', SWIFTSIGN_PLUGIN_URL . 'admin/js/swift-form-debug.js', array('jquery'), '', true);
        $beta_testing_mode = get_option(SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode');
        $testing_formid = get_option(SWIFTSIGN_PLUGIN_PREFIX . "testingformID");
        $testing_capture_mode = get_option(SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode");
        ?>
        <div class="swift_testing_msg_wrap">
            <?php
            if ($beta_testing_mode == 1) {
                ?>
                <div id="swift-testing-error-msg" class="notice notice-error">
                    <p><?php echo sprintf($MSG['alert_beta_testing_msg'], '<a href="javascript:void(0);" class="ssing_off_testing_mode" onclick="swiftOffTestingMode()">click here</a>'); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if (isset($_POST['save_' . SWIFTSIGN_PLUGIN_PREFIX . 'testing_mode_settings']) && wp_verify_nonce($_POST['save_' . SWIFTSIGN_PLUGIN_PREFIX . 'testing_mode_settings'], 'save_' . SWIFTSIGN_PLUGIN_PREFIX . 'testing_mode_settings')) {
            $testing_formid = sanitize_text_field($_POST[SWIFTSIGN_PLUGIN_PREFIX . 'testingformID']);
            $testing_capturemode = sanitize_text_field($_POST[SWIFTSIGN_PLUGIN_PREFIX . 'testingcapturemode']);

            $testing_mode_update1 = update_option(SWIFTSIGN_PLUGIN_PREFIX . "testingformID", $testing_formid);
            $testing_mode_update2 = update_option(SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode", $testing_capturemode);

            if ($testing_mode_update1 || $testing_mode_update2) {
                wp_redirect(home_url() . "/wp-admin/admin.php?page=ssign_help_setup&tab=ssign-setp-support");
            }
        }

        if (isset($_GET['update']) && !empty($_GET['update'])) {
            ?>
            <div id="message" class="notice notice-success is-dismissible below-h2">
                <?php if ($_GET['update'] == 'modeon') {
                    ?>
                    <p><?php echo $MSG['msg_testing_mode']; ?></p>
                    <?php
                } else if ("modeoff" == $_GET['update']) {
                    ?>
                    <p><?php echo $MSG['msg_testing_mode_off']; ?></p>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>

        <div class="inner_content">
            <div class="swift_beta_testing_mode_wrap">
                <?php
                $testing_mode = ($beta_testing_mode == 1 ? 'checked="checked"' : "");
                $testing_mode_toggle = ($beta_testing_mode == 1 ? 'display:block' : 'display:none');
                ?>
                <label><?php echo $MSG['label_beta_testing']; ?></label>
                <input type="checkbox" value="1" data-ontext="ON" data-offtext="OFF" name="<?php echo SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode'; ?>" id="<?php echo SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode'; ?>" class="swift_beta_testing" <?php echo $testing_mode; ?>>

                <div class="swift_testing_mode_form" style="<?php echo $testing_mode_toggle; ?>">
                    <form method="post" id="<?php echo 'frm_' . SWIFTSIGN_PLUGIN_PREFIX . '_testing_mode' ?>">
                        <div class="swift_field">
                            <label for="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingformID" ?>"><?php echo $MSG['label_testing_formid']; ?></label>
                            <input type="text" name="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingformID" ?>" id="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingformID" ?>" class="swift_input" value="<?php echo (!empty($testing_formid) ? $testing_formid : "659"); ?>"/>
                        </div>
                        <div class="swift_field">
                            <label for="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode" ?>"><?php echo $MSG['label_testing_capture_mode']; ?></label>
                            <select name="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode" ?>" id="<?php echo SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode" ?>" class="swift_input">
                                <option <?php echo selected($testing_capture_mode, 'fh.php'); ?> value="fh.php">NULL</option>
                                <option <?php echo selected($testing_capture_mode, 'fh_beta.php'); ?> value="fh_beta.php">beta</option>
                                <option <?php echo selected($testing_capture_mode, 'fh_alpha.php'); ?> value="fh_alpha.php">alpha</option>
                            </select>
                        </div>
                        <div class="swift_field">
                            <?php wp_nonce_field('save_' . SWIFTSIGN_PLUGIN_PREFIX . 'testing_mode_settings', 'save_' . SWIFTSIGN_PLUGIN_PREFIX . 'testing_mode_settings'); ?>
                            <button type="submit" class="button-primary" value="Save Settings" name="<?php echo SWIFTSIGN_PLUGIN_PREFIX ?>testing_mode_settings_submit" /><?php echo $MSG['btn_save_settings']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

}


/*
 *  Beta testing mode action
 *  ON
 */
add_action('wp_ajax_' . SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_on', SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_on_callback');
add_action('wp_ajax_nopriv_' . SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_on', SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_on_callback');

function ssing_beta_testing_mode_on_callback() {
    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_on') {
        $MSG = ssing_testing_mode_message();
        $mode = sanitize_text_field($_POST['data']);
        if ($mode == 1) {
            $update_flag = update_option(SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode', $mode);
            if ($update_flag) {
                echo json_encode(
                        array(
                            'status' => 'on',
                            'msg' => $MSG['alert_beta_testing_msg']
                        )
                );
            }
        }
    }
    wp_die();
}

/*
 *  Beta testing mode action
 *  OFF
 */
add_action('wp_ajax_' . SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_off', SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_off_callback');
add_action('wp_ajax_nopriv_' . SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_off', SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_off_callback');

function ssing_beta_testing_mode_off_callback() {

    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode_off') {
        $mode = sanitize_text_field($_POST['data']);
        if ($mode == 0) {
            update_option(SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode', $mode);
        }
    }
    wp_die();
}
?>