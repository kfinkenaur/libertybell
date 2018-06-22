<?php

/*
  Plugin Name: Swift Signature
  Plugin URL: http://SwiftSignature.com?pr=89
  Description: Electronic Digital Signatures in Wordpress. Make any Wordpress page signable online with data fields, signatures, initials and more.
  Version: 1.5.21
  Author: Roger Vaughn, Tejas Hapani
  Author URI: https://swiftcloud.ai/
  Text Domain: swiftsign
  Domain Path: /swiftsign/
 */

define('SWIFTSIGN_VERSION', '1.5.21');
define('SWIFTSIGN_MINIMUM_WP_VERSION', '4.5');
define('SWIFTSIGN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SWIFTSIGN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SWIFTSIGN_PLUGIN_PREFIX', 'ssing_');

register_activation_hook(__FILE__, 'ssign_install');

function ssign_install() {
    if (version_compare($GLOBALS['wp_version'], SWIFTSIGN_MINIMUM_WP_VERSION, '<')) {
        add_action('admin_notices', create_function('', "
        echo '<div class=\"error\"><p>" . sprintf(esc_html__('Swift Signature %s requires WordPress %s or higher.', 'swiftsign'), SWIFTSIGN_VERSION, SWIFTSIGN_MINIMUM_WP_VERSION) . "</p></div>'; "));

        add_action('admin_init', 'ssign_deactivate_self');

        function ssign_deactivate_self() {
            if (isset($_GET["activate"]))
                unset($_GET["activate"]);
            deactivate_plugins(plugin_basename(__FILE__));
        }

        return;
    }
    update_option('swift_sign_version', SWIFTSIGN_VERSION);

    /**
     *      Add table ssing log
     */
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $tab_ssing_local_capture = $wpdb->prefix . 'ssing_log';
    $ssing_log = "CREATE TABLE IF NOT EXISTS $tab_ssing_local_capture (
		 `ssign_id` mediumint(9) NOT NULL AUTO_INCREMENT,
                 `ssign_capture_name` varchar(255) NOT NULL,
                 `ssign_capture_email` varchar(255) NOT NULL,
		 `ssign_capture_data` LONGTEXT NULL,
                 `ssign_status` TINYINT DEFAULT '0' NOT NULL,
		 `date_time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		 PRIMARY KEY (`ssign_id`)
	) $charset_collate;";

    dbDelta($ssing_log);

    /* PDFs table */
    $table_pdf = $wpdb->prefix . 'ssign_pdfs';
    $create_table_pdf = "CREATE TABLE IF NOT EXISTS `$table_pdf` (
      `pdf_id` int(11) NOT NULL AUTO_INCREMENT,
      `pdf_name` varchar(255) NOT NULL,
      `pdf_url` varchar(255) NOT NULL,
      `pdf_path` varchar(255) NOT NULL,
      `pdf_shortcode` varchar(255) NOT NULL,
      `date_time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY (`pdf_id`)
      ) $charset_collate ;";
    dbDelta($create_table_pdf);


    /* Envelope table */
    $table_envelope = $wpdb->prefix . 'ssign_envelope';
    $create_table_envelope = "CREATE TABLE IF NOT EXISTS `$table_envelope` (
      `envelope_id` int(11) NOT NULL AUTO_INCREMENT,
      `envelope_name` varchar(255) NOT NULL,
      `envelope_docs` varchar(255) NOT NULL,
      `envelope_shortcode` varchar(255) NOT NULL,
      `date_time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY (`envelope_id`)
      ) $charset_collate ;";
    dbDelta($create_table_envelope);

    $table_lead_report = $wpdb->prefix . 'ssing_lead_report';
    $create_table_lead_report = "CREATE TABLE IF NOT EXISTS `$table_lead_report` (
                    `id` bigint(20) NOT NULL AUTO_INCREMENT,
                    `lead_date` date NOT NULL DEFAULT '0000-00-00',
                    `lead_pageid` int(11) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) $charset_collate ;";
    dbDelta($create_table_lead_report);

    /**
     *  Set default settings
     */
    $setting_options = array(
        "credit_text" => array("option_name" => "swift_sign_credit_text", "option_value" => "Powerd by SwiftSignature"),
        "credit_text_link" => array("option_name" => "swift_sign_credit_text_link", "option_value" => "http://swiftsignature.com/"),
        "consent_text" => array("option_name" => "swift_sign_consent_text", "option_value" => "By clicking Sign & Send below you agree to the terms contained herein, and that terms are binding in your jurisdiction as defined in our Electronic Signature Disclosure & Consent."),
        "testingformID" => array("option_name" => SWIFTSIGN_PLUGIN_PREFIX . "testingformID", "option_value" => "659"),
        "capture_mode" => array("option_name" => SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode", "option_value" => "fh.php"),
        "auto_sign_flag" => array("option_name" => "ssing_auto_generate_sign", "option_value" => "1"),
    );

    if (!empty($setting_options)) {
        foreach ($setting_options as $key => $option) {
            update_option($option['option_name'], $option['option_value']);
        }
    }
}

function ssign_initial_data() {
    /**
     *   Auto generate pages
     */
    //eSign page content
    $eSignContent = '';
    $eSignContent .= '[swiftsign swift_form_id="SWIFTFORMIDHERE"]<br/>';
    $eSignContent .= 'I, [swift_name size="medium"], and YOURCOMPANYHERE agree to the following awesome text:<br/>';
    $eSignContent .= '<ol><li>Penguins are cute</li><li>Dolphins are fun</li><li>Great whites are not cute.</li><li>Replace this area with whatever you want agreement on.</li></ol>';
    $eSignContent .= '<h3>Conditional / Branching Logic Example here:</h3><br/>';
    $eSignContent .= 'Do you like cats? [swift_radio name="likecats" options="yes, no"]<br/>';
    $eSignContent .= '[swift_showhide default="hide" trigger="likecats" value="yes"]<br/>';
    $eSignContent .= 'What\'s your favorite type of cat? (Notice this question only shows if you click yes to liking cats.)<br/>';
    $eSignContent .= '[swift_circleword name="catfavorite" options="calico, siamese, tiger, lynx"]<br/>';
    $eSignContent .= '[/swift_showhide]<br/>';
    $eSignContent .= '[swiftsignature]<br/>';
    $eSignContent .= 'Signed and agreed on this [swift_date_long].<br/>';
    $eSignContent .= 'Addendum A:<br/>';
    $eSignContent .= '[swift_initials] I also warrant I am not a great white shark.<br/>';
    $eSignContent .= 'Primary Email: [swift_email name="email" required]<br/>';
    $eSignContent .= '[swift_button]<br/>';
    $eSignContent .= '[/swiftsign]';

    $pages_array = array(
        "thankspage" => array("title" => "Thanks (return page after e-signature)", "content" => "<h2>Thanks [swiftsign_capture_name]!</h2><p>We have received your document and will be in touch soon, usually within one business day.</p>", "slug" => "signedthanks"),
        "esignpage" => array("title" => "eSign", "content" => nl2br($eSignContent), "slug" => "esign")
    );
    $ssign_pages_id = '';
    foreach ($pages_array as $key => $page) {
        $page_data = array(
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_title' => $page['title'],
            'post_name' => $page['slug'],
            'post_content' => $page['content'],
            'comment_status' => 'closed'
        );
        $page_id = wp_insert_post($page_data);
        $ssign_pages_id .= $page_id . ",";
    }

    if (!empty($ssign_pages_id)) {
        update_option('swiftsign_pages', rtrim($ssign_pages_id, ","));
    }

    // default set dashboard widget to ON
    update_option('ssing_dashboard_widget_flag', 1);
}

/**
 *  Update checking
 */
function ssign_update_check() {
    if (get_option("swift_sign_version") != SWIFTSIGN_VERSION) {
        ssign_install();
    }
    load_plugin_textdomain('swiftsign', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}

add_action('plugins_loaded', 'ssign_update_check');

/**
 *  Update process
 * */
add_action('upgrader_process_complete', 'ssign_update_process');

function ssign_update_process($upgrader_object, $options = '') {
    $current_plugin_path_name = plugin_basename(__FILE__);

    if (isset($options) && !empty($options) && $options['action'] == 'update' && $options['type'] == 'plugin' && $options['bulk'] == false && $options['bulk'] == false) {
        foreach ($options['packages'] as $each_plugin) {
            if ($each_plugin == $current_plugin_path_name) {
                ssign_install();
                ssign_initial_data();
            }
        }
    }
}

/**
 *      Deactive plugin
 *      Remove Tabel sb_email_template
 */
register_deactivation_hook(__FILE__, 'ssign_deactive_plugin');

function ssign_deactive_plugin() {

}

/**
 *      Uninstall plugin
 */
register_uninstall_hook(__FILE__, 'swiftsign_uninstall_callback');
if (!function_exists('swiftsign_uninstall_callback')) {

    function swiftsign_uninstall_callback() {
        delete_option("swift_sign_version");
        delete_option("ssign_notice");

        global $wpdb;
        $table_pdf = $wpdb->prefix . 'ssign_pdfs';
        $wpdb->query("DROP TABLE IF EXISTS $table_pdf");

        $table_log = $wpdb->prefix . 'ssing_log';
        $wpdb->query("DROP TABLE IF EXISTS $table_log");

        $table_envelope = $wpdb->prefix . 'ssign_envelope';
        $wpdb->query("DROP TABLE IF EXISTS $table_envelope");

        // delete pages
        $pages = get_option('swiftsign_pages');
        if ($pages) {
            $pages = explode(",", $pages);
            foreach ($pages as $pid) {
                wp_delete_post($pid, true);
            }
        }
        delete_option("swiftsign_pages");
    }

}

/**
 *  Frontend css
 */
add_action('wp_enqueue_scripts', 'ss_enqueue_scripts_styles');

function ss_enqueue_scripts_styles() {
    wp_enqueue_style('ss-style', plugins_url('css/swiftsignature-style.css', __FILE__), '', '', '');
    wp_enqueue_script('ssing-script', plugins_url('js/swiftsignature-script.js', __FILE__), array('jquery'), '', true);

    wp_localize_script('ssing-script', 'ssign_ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'ssing_plugin_home_url' => SWIFTSIGN_PLUGIN_URL));

    if (wp_style_is('bootstrap.css', 'enqueued') || wp_style_is('bootstrap.min.css', 'enqueued')) {
        return;
    } else {
        wp_enqueue_style('swift-bs-modal', plugins_url('/css/ssing_bs_modal.min.css', __FILE__), '', '', '');
    }
}

include('swiftsign-pagetemplater.php');
include('admin/swiftsignature-admin.php');
include('shortcode-generator/swiftsignature_shortcode_generator.php');
include('section/swiftsignature-form-shortcode.php');
include('section/swiftsignature-form-capture.php');
include('section/swiftsignature-shortcode.php');
include('section/swiftsignature-callback.php');
include('section/swift-form-error-popup.php');
include('section/swiftsignature-front-messages.php');

/* Init cron job */
add_action('init', 'ssign_init_callback');

function ssign_init_callback() {
    //wp_enqueue_script('ssing-auto-post', plugins_url('js/ssign_auto_post.js', __FILE__), array('jquery'), '', true);
    //wp_localize_script('ssing-auto-post', 'ssign_auto_post_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

?>