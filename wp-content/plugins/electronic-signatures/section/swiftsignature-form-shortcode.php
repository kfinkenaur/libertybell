<?php
/*
 *  Shortcode :  [swiftsign method="GET/POST" action="form action" swift_form_id="" fullpagemode=""].....[/swiftsign]
 *  Generates a form.
 *      method : form method GET or POST. Default is POST
 *      action : gives action to form for submit. Default is blank.
 *      swift_form_id : form id of swift form. for ex: 266,261 etc..
 *      fullpagemode: On/Off
 */
ob_start();
if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
}

function swiftsign_shortcode($atts, $content = null) {
    wp_enqueue_style('ss-checkbox-radio-style', plugins_url('/css/checkbox_radio.css', dirname(__FILE__)), '', '', '');
    wp_enqueue_style('swiftcloud-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', '', '', '');
    wp_enqueue_script('jquery-effects-core');
    wp_enqueue_script('jquery-effects-shake');

    wp_enqueue_script('jquery-ui-tooltip');
    wp_enqueue_style('swift-jquery-ui-style', plugins_url('/css/jquery-ui.css', dirname(__FILE__)), '', '', '');

    $output = "";
    $a = shortcode_atts(
            array(
        'method' => '',
        'action' => '',
        'swift_form_id' => '',
        'fullpagemode' => ''
            ), $atts);
    extract($a);

    $form_url = "https://swiftcloud.io/forms/fh.php";

    /* testing mode value */
    $form_testing_mode_flag = get_option(SWIFTSIGN_PLUGIN_PREFIX . 'beta_testing_mode');

    /*  If testing mode on change form action and form id */
    /* if ($form_testing_mode_flag == 1) {
      $testing_formid = get_option(SWIFTSIGN_PLUGIN_PREFIX . "testingformID");

      $testing_capture_mode = get_option(SWIFTSIGN_PLUGIN_PREFIX . "testingcapturemode");
      $form_url = "https://swiftcloud.io/forms/$testing_capture_mode";
      $swift_form_id = !empty($testing_formid) ? $testing_formid : $swift_form_id;
      } */

// ***************** DEBUG MODE *****************
// check to see if we have testingformID. Do not use "Testing formID" from backend
    $testing_formid = (isset($_GET['testingformID']) && !empty($_GET['testingformID']) && ($_GET['testingformID'] == "ON" || $_GET['testingformID'] == 1)) ? 659 : '';
    $swift_form_id = !empty($testing_formid) ? $testing_formid : $swift_form_id;
    $frmMethod = (!empty($method)) ? 'method="' . $method . '"' : 'method="POST"';
    $frmAction = (!empty($action)) ? 'action="' . $action . '"' : 'action="' . $form_url . '"';
    $full_screen_mode = (!empty($fullpagemode) && $fullpagemode === 'ON') ? 'ON' : 'OFF';
    if ($full_screen_mode === 'ON') {

    } else {

    }

    $formContent = $content;

    // check to see if empty swift form id....
    if (empty($swift_form_id))
        return "<p style='color:red;font-size:18px;'>Heads up! Your form will not display until you add a form ID number in the form.</p>";

    wp_enqueue_script('swift-form-jstz', SWIFTSIGN_PLUGIN_URL . "js/jstz.min.js", '', '', true);
    $output .= '<form class="sc-swift-form v-' . str_replace('.', '-', SWIFTSIGN_VERSION) . '" name="sc_Frmswift" id="sc_Frmswift" ' . $frmAction . ' ' . $frmMethod . '>' . do_shortcode($formContent);
    $output .= '    <div id="ssign-hidden-fields">
                        <input type="hidden" name="Cache_LastChanged" id="Cache_LastChanged" value="' . get_the_modified_date('m-d-y H:i:s', get_the_ID()) . '" />
                        <input type="hidden" name="PublicKey" id="PublicKey" value="' . hash('sha256', get_the_modified_date('m-d-y H:i:s', get_the_ID())) . '" />
                        <input id="SC_fh_ip_address" type="hidden" name="extra_ip_address" value="' . $_SERVER['REMOTE_ADDR'] . '" />
                        <input type="hidden" name="browser" id="browser" value="' . $_SERVER['HTTP_USER_AGENT'] . '" />
                        <input type="hidden" name="trackingvars" class="trackingvars" id="trackingvars" >
                        <input type="hidden" id="SC_fh_timezone" name="timezone" value="" />
                        <input type="hidden" id="SC_fh_language" name="language" value="" />
                        <input type="hidden" id="SC_fh_capturepage" name="capturepage" value="" />
                        <input type="hidden" id="sc_lead_referer" name="sc_lead_referer" value="" />
                        <input type="hidden" id="browserResolution" name="browserResolution" value="" />
                        <input type="hidden" name="formid" id="formid" value="' . $swift_form_id . '" />
                        <input name="extra_signaturestatus" value="signed_singleparty" type="hidden" />
                        <input type="hidden" value="817" name="iSubscriber" />
                        <input id="sc_referer_qstring" type="hidden" value="" name="sc_referer_qstring" />
                    </div>';
    $output .= "</form>";

    //<input type="hidden" name="vThanksRedirect" value="' . home_url() . '/thanks" />

    $arrow_img = '<img src=\"' . plugins_url('electronic-signatures/images/arrow_down.gif') . '\"  style=\"max-width: 20px\" />';
    $output .= "<script type='text/javascript'>
            var arrow_img= '" . $arrow_img . "';
                    jQuery(document).ready(function() {
                        if (jQuery('#SC_fh_timezone').size() > 0) {
                            /*var offset = new Date().getTimezoneOffset();
                            var minutes = Math.abs(offset);
                            var hours = (minutes / 60);
                            var prefix = offset < 0 ? '+' : '-';
                            jQuery('#SC_fh_timezone').val('GMT'+prefix+hours);*/
                            jQuery('#SC_fh_timezone').val(jstz.determine().name());
                        }
                        if (jQuery('#SC_fh_capturepage').size() > 0) {
                            jQuery('#SC_fh_capturepage').val(window.location.origin + window.location.pathname);
                        }
                        if (jQuery('#SC_fh_language').size() > 0) {
                            jQuery('#SC_fh_language').val(window.navigator.userLanguage || window.navigator.language);
                        }
                    });
          </script>";

    return $output;
}

add_shortcode('swiftsign', 'swiftsign_shortcode');

/*
 *  shortcode : [swift_textbox class="class name" name="textbox's name" value="textbox's value" placeholder="placeholder value" required]
 *  Generate a textbox.
 *      class : add class to textbox for styling.
 *      name  : textbox name.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: textbox is required.
 *      size: medium,long , full line; size of field.
 */

add_shortcode('swift_textbox', 'swift_input_text_shortcode');

function swift_input_text_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => '',
        'size' => '',
        'readonly' => '',
        'required' => ''
            ), $atts);
    extract($a);

    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    $txtBoxName = !empty($name) ? $name == 'phone' || $name == 'zipCode' || $name == 'name' ? trim($name) : "extra_" . trim($name)  : "";
    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));
//    $txtBoxValue = (isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : "");

    $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "";
    $txtBoxId = sanitize_title($txtBoxName);
    $txtBoxSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

    if (isset($atts) && !empty($atts) && in_array('required', $atts)) {
        $required = 'ss-required ';
    }
    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readyonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
    } else {
        $output = '<input type="text" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="' . $required . $txtBoxClass . $txtBoxSize . '" placeholder="' . $txtBoxPlaceholder . '" ' . $readonly . ' />';
    }
    return $output;
}

/*
 *  shortcode : [swift_email class="class name" name="textbox's name" value="textbox's value" placeholder="placeholder value" required]
 *  Generate a textbox with type email.
 *      class : add class to textbox for styling.
 *      name  : textbox name.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: email is required.
 */
add_shortcode('swift_email', 'swift_input_email_shortcode');

function swift_input_email_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => '',
        'readonly' => '',
        'required' => '',
            ), $atts);
    extract($a);

    $required = 'ss-required ';

    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    $txtBoxName = (!empty($name)) ? trim($name) : "email";
//    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((!empty($value)) ? $value : "");
    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));

    $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "Email";
    $txtBoxId = sanitize_title($txtBoxName);
    $txtBoxId = !empty($txtBoxId) ? $txtBoxId : "email";

    $get_ssing_work_with = get_option("ssing_work_with");
    if ($get_ssing_work_with && $get_ssing_work_with == "Businesses") {
        $tooltip_text = "Please use your primary business email if signing on behalf of a business. We'll send your signed agreement to this address.";
    } else {
        $tooltip_text = "Primary personal email. We'll send your signed agreement to this address and store it online in a free SwiftCloud account for you tied to this email.";
    }

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readyonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
    } else {
        $output = '<input type="email" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ssign_tooltip ' . $required . $txtBoxClass . '" placeholder="' . $txtBoxPlaceholder . '" title="' . $tooltip_text . '" ' . $readonly . ' />';
    }
    return $output;
}

/*
 *  shortcode : [swift_phone class="class name" name="textbox's name" value="textbox's value" placeholder="placeholder value" required]
 *  Generate a textbox.
 *      class : add class to textbox for styling.
 *      name  : textbox name.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: textbox is required.
 *      size: medium, long, full line; size of field.
 */

add_shortcode('swift_phone', 'swift_phone_shortcode');

function swift_phone_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => '',
        'size' => '',
        'readonly' => '',
        'required' => ''
            ), $atts);
    extract($a);

    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    $txtBoxName = !empty($name) ? $name == 'phone' || $name == 'zipCode' || $name == 'name' ? trim($name) : sanitize_title("extra_" . trim($name))  : "";
//    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((!empty($value)) ? $value : "");
    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));

    $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "";
    $txtBoxId = sanitize_title($txtBoxName);
    $txtBoxSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

    if (isset($atts) && !empty($atts) && in_array('required', $atts)) {
        $required = 'ss-required ';
    }
    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readyonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
    } else {
        $output = '<input type="text" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="swift_phone_field ' . $required . $txtBoxClass . $txtBoxSize . '" placeholder="' . $txtBoxPlaceholder . '" ' . $readonly . ' />';
    }
    return $output;
}

/*
 *  shortcode : [swift_address class="class name" name="textbox's name" value="textbox's value" placeholder="placeholder value" required]
 *  Generate a address field.
 *      class : add class to textbox for styling.
 *      name  : textbox name.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: textbox is required.
 */

add_shortcode('swift_address', 'swift_address_shortcode');

function swift_address_shortcode($atts) {

    $ssing_google_map_api_key = get_option("ssing_google_map_api_key");
    if (empty($ssing_google_map_api_key)) {
        $output = "<span style='color:red;font-size:14px;'>Address field will not display until you add a Google Map API Key in <a href='" . admin_url('admin.php?page=ss_control_panel') . "' target='_blank' style='color:red;'>control panel</a>.</span>";
    } else {
        wp_enqueue_script('ss-address-gmap', '//maps.googleapis.com/maps/api/js?key=' . $ssing_google_map_api_key . '&libraries=places', '', '', true);
        wp_enqueue_script('ss-address-script', plugins_url('/js/jquery.geocomplete.min.js', dirname(__FILE__)), '', '', true);

        $output = "";
        $a = shortcode_atts(
                array(
            'class' => '',
            'name' => '',
            'value' => '',
            'placeholder' => '',
            'size' => '',
            'readonly' => '',
            'required' => ''
                ), $atts);
        extract($a);

        $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
        $txtBoxName = !empty($name) ? $name == 'phone' || $name == 'zipCode' || $name == 'name' ? trim($name) : sanitize_title("extra_" . trim($name))  : "";
//        $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((!empty($value)) ? $value : "");
        $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));

        $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "Enter your address";
        $txtBoxId = sanitize_title($txtBoxName);
        $txtBoxSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

        if (isset($atts) && !empty($atts) && in_array('required', $atts)) {
            $required = 'ss-required ';
        }
        if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
            $readonly = 'readonly="readonly" ';
        }

        if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
            $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
        } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
            $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readyonly" ' . $readonly . ' />';
            $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
        } else {
            $output = '<input type="text" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="' . $required . $txtBoxClass . $txtBoxSize . '" placeholder="' . $txtBoxPlaceholder . '" ' . $readonly . ' />';
            $output .= '<script>';
            $output .= 'jQuery(document).ready(function() {';
            $output .= 'jQuery("#' . $txtBoxId . '").geocomplete();';
            $output .= '});';
            $output .= '</script>';
        }
    }
    return $output;
}

/*
 *  shortcode : [swift_url class="class name" name="field name" value="field value" placeholder="placeholder value" required]
 *  Generate a field input with type URL.
 *      class : add class to field for styling.
 *      name  : field name.
 *      value : field prefill value. default is blank.
 *      placeholder : add placeholder in field.
 *      required: field is required.
 *     size: medium,long , full line; size of field.
 */
add_shortcode('swift_url', 'swift_input_url_shortcode');

function swift_input_url_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => '',
        'size' => '',
        'readonly' => '',
        'required' => '',
            ), $atts);
    extract($a);

    if (isset($atts) && !empty($atts) && in_array('required', $atts)) {
        $required = 'ss-required ';
    }
    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    $txtBoxName = (!empty($name)) ? "extra_" . trim($name) : "";
//    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((!empty($value)) ? $value : "");
    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));

    $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "";
    $txtBoxId = sanitize_title($txtBoxName);
    $txtBoxSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readyonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
    } else {
        $output = '<input type="url" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="' . $required . $txtBoxClass . $txtBoxSize . '" placeholder="' . $txtBoxPlaceholder . '" ' . $readonly . ' />';
    }
    return $output;
}

/*
 *  shortcode : [swift_checkbox name="checkbox's name" class="class name" options="option1,option2,.....,optionN" checked="option_name" required]
 *  Generate a checkbox.
 *      name  : checkbox's name.
 *      class : add class to styling checkbox.
 *      options : comma seprated list of optios, comma seprated list of optios.
 *      checked : pass option name which you want to pre-selected.
 *      required: checkbox is required.
 */

add_shortcode('swift_checkbox', 'swift_input_checkbox_shortcode');

function swift_input_checkbox_shortcode($attsChbx) {

    $output = $required = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'options' => '',
        'checked' => '',
            ), $attsChbx);
    extract($a);

    if (!empty($options)) {
        if (isset($attsChbx) && !empty($attsChbx) && in_array('required', $attsChbx)) {
            $required = 'ss-checkbox-required ';
        }

        $chkBoxName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
        $chkBoxClass = (!empty($class)) ? sanitize_title($class) : "";
        $chkOptions = explode(",", rtrim($options, ","));
        $checkedOptions = !empty($checked) ? @explode(",", $checked) : array();

        if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$chkBoxName]) && !empty($_GET[$chkBoxName])) {
            $output .= '<span class="sc_print-field">' . $_GET[$chkBoxName] . '</span>';
        } else {
            $output .= '<div class="checkbox-wrap ' . $required . '">';
            foreach ($chkOptions as $opt) {
                $chkChecked = "";
                $opt = trim($opt);
                if ((isset($_GET[$chkBoxName]) && !empty($_GET[$chkBoxName])) || (isset($_COOKIE[$chkBoxName]) && !empty($_COOKIE[$chkBoxName]) )) {
                    if ($opt == $_GET[$chkBoxName] || $opt == $_COOKIE[$chkBoxName]) {
                        $chkChecked = "checked='checked'";
                    }
                } else if (in_array($opt, $checkedOptions)) {
                    $chkChecked = "checked='checked'";
                }
                $opt_id = $chkBoxName . "_" . sanitize_title($opt);
                $output .= '<div class="pure-checkbox"><input type="checkbox" id="' . $opt_id . '" name="' . $chkBoxName . '[]" value="' . $opt . '" class="swift_check ' . $chkBoxClass . '" ' . $chkChecked . ' /><label class="ss-checkboxset" for="' . $opt_id . '">' . $opt . '</label></div>';
            }
            $output .= '</div>';
        }
        return $output;
    }
}

/*
 *  shortcode : [swift_radio name="radio button's name" class="class name" options="option1,option2,.....,optionN" checked="option_name" required]
 *  Generate a radio button.
 *      name  : radio button's name.
 *      class : add class to styling radio button.
 *      options : radio button options, comma seprated list of optios.
 *      checked : pass option name which you want to pre-selected.
 *      required: radio button is required.
 */
add_shortcode('swift_radio', 'swift_input_radio_shortcode');

function swift_input_radio_shortcode($attsRdbtn) {

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'options' => '',
        'checked' => '',
        'required' => ''
            ), $attsRdbtn);
    extract($a);

    if (!empty($options)) {
        if (isset($attsRdbtn) && !empty($attsRdbtn) && !empty($required)) {
            $required = 'ss-radio-required ';
        }

        $radioBtnName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
        $radioBtnClass = (!empty($class)) ? sanitize_title($class) : "";
        $options = explode(",", rtrim($options, ","));
        $checkedOptions = !empty($checked) ? @explode(",", $checked) : array();

        if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$radioBtnName]) && !empty($_GET[$radioBtnName])) {
            $output = '<span class="sc_print-field">' . $_GET[$radioBtnName] . '</span>';
        } else {
            $output = '<div class="radio-wrap">';
            foreach ($options as $opt) {
                $radioChecked = "";
                $opt = trim($opt);
                if ((isset($_GET[$radioBtnName]) && !empty($_GET[$radioBtnName])) || (isset($_COOKIE[$radioBtnName]) && !empty($_COOKIE[$radioBtnName]) )) {
                    if ($opt == $_GET[$radioBtnName] || $opt == $_COOKIE[$radioBtnName]) {
                        $radioChecked = "checked='checked'";
                    }
                } else if (in_array($opt, $checkedOptions)) {
                    $radioChecked = "checked='checked'";
                }
                $opt_id = $radioBtnName . "_" . sanitize_title($opt);
                $output .= '<div class="pure-radiobutton"><input type="radio" id="' . $opt_id . '" name="' . $radioBtnName . '" value="' . $opt . '" class="swift_radio ' . $radioBtnClass . '" ' . $radioChecked . ' /><label class="ss-radioset" for="' . $opt_id . '">' . $opt . '</label></div>';
            }
            $output .= '</div>';
        }
        return $output;
    }
}

/*
 *  shortcode : [swift_dropdown name="dropdown's name" class="class name" option_values="value1,value2,....,valueN" selected_option="value" required]
 *  Generate a dropdown.
 *      name  : dropdown 's name.
 *      class : add class to styling dropdown.
 *      option_values : value to select; enter comma seprated values.
 *      selected_option : pass value which you pre selected.
 *      required: this field is required.
 */
add_shortcode('swift_dropdown', 'swift_dropdown_shortcode');

function swift_dropdown_shortcode($attsDropDown) {
    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'option_values' => '',
        'selected_option' => '',
        'required' => ''
            ), $attsDropDown);
    extract($a);

    if (isset($attsDropDown) && !empty($attsDropDown) && in_array('required', $attsDropDown)) {
        $required = 'ss-required ';
    }

    $dropdownName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
    $dropdownClass = (!empty($class)) ? sanitize_title($class) : "";
    $optionVal = explode(",", rtrim($option_values, ","));
    $dropdownId = sanitize_title($dropdownName);

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$dropdownName]) && !empty($_GET[$dropdownName])) {
        $output .= '<span class="sc_print-field">' . $_GET[$dropdownName] . '</span>';
    } else {
        $output .= '<select name="' . $dropdownName . '" id="' . $dropdownId . '" class="' . $required . $dropdownClass . '"  >';
        if (!empty($optionVal)) {
            foreach ($optionVal as $val) {
                $selected = "";
                $val = trim($val);
                if ((isset($_GET[$dropdownName]) && !empty($_GET[$dropdownName])) || (isset($_COOKIE[$dropdownName]) && !empty($_COOKIE[$dropdownName]) )) {
                    if ($val == $_GET[$dropdownName] || $val == $_COOKIE[$dropdownName]) {
                        $selected = 'selected="selected"';
                    }
                } else if ($selected_option == $val) {
                    $selected = 'selected="selected"';
                }
                $output .= '<option value="' . $val . '" ' . $selected . ' >' . $val . '</option>';
            }
        }
        $output .= '</select>';
    }
    return $output;
}

/*
 *  shortcode : [swift_button name="button name" value="button value" class="button class" label="button label"]
 *  Generates  a button.
 *      name  : button's name.
 *      label : button's label.
 *      class : add class to styling button.
 *      value : button value.
 */

function swift_button_shortcode($attsBtn) {
    $SSING_MSG = swiftsign_front_messages();

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'label' => '',
        'value' => '',
            ), $attsBtn);
    extract($a);
    $buttonName = (!empty($name)) ? sanitize_title(trim($name)) : "swift_sign_submit";
    $buttonClass = (!empty($class)) ? sanitize_title($class) : "";
    $buttonLabel = (!empty($label)) ? $label : '<i class=\'fa fa-pencil\'></i>&nbsp;&nbsp;' . $SSING_MSG["btn_sign_send_one"] . '&nbsp;&nbsp;<i class=\'fa fa-paper-plane\'></i>';
    $buttonValue = (!empty($value)) ? $value : "Submit";

    $output .= '<div class="sc-submit-button">';
    $output .= '<div class="sc_credit_text">';
    $output .= '<p class="sc_consent_text">' . sprintf($SSING_MSG['msg_by_clicking_sing'], '<a href="https://SwiftCloud.ai/electronic-signature?utm_source=viral&utm_medium=eSignatureInstalled&utm_content=eSignatureInstalled&utm_campaign=eSignatureInstalled&pr=88&button=CCTAO" target="_blank">Electronic Signature</a>', '<a href="https://SwiftCloud.ai/electronic-signature?utm_source=viral&utm_medium=eSignatureInstalled&utm_content=eSignatureInstalled&utm_campaign=eSignatureInstalled" target="_blank">Disclosure & Consent</a>') . ' </p></div>';

    $output .= '<div id="btnContainer"></div>';
    $output .= '<script type="text/javascript">';
    $output .= 'var button = document.createElement("button");button.innerHTML = "' . $buttonLabel . '";';
    $output .= 'var body = document.getElementById("btnContainer");body.appendChild(button);';
    $output .= 'button.id = "swift_sign_submit";';
    $output .= 'button.name = "' . $buttonName . '";';
    $output .= 'button.className = "swift_sign_submit checkValidation ' . $buttonClass . '";';
    $output .= 'button.value = "' . $buttonValue . '";';
    $output .= 'button.type = "button";';
    $output .= '</script>';
    $output .= '<noscript>';
    $output .= '<p style=\'color:red;font-size:18px;\'>JavaScript must be enabled to sign this document. Please check your browser settings and reload this page to continue.</p>';
    $output .= '</noscript>';

    $output .= '</div>';
    $output .= '<div id="consentModal" class="swiftsign-modal">
                    <div class="swiftsign-modal-overlay"></div>
                    <div class="swiftsign-modal-content">
                        <span class="swiftsign-modal-close"><img src="' . plugins_url('../images/close.png', __FILE__) . '"/></span>
                        <div class="sc_consent_text_link">
                            <h2>E-Sign Act Disclosure and Agreement</h2>
                            <h4><strong>Your Consent To Use Electronic Records and&nbsp;<a href="https://wordpress.org/plugins/electronic-signatures/" style="border-bottom: 1px solid rgb(51, 51, 51); color: rgb(51, 51, 51); text-decoration: none;">Electronic Signatures</a></strong></h4>
                            <p>This&nbsp;website has elected to use&nbsp;<a href="http://swiftsignature.com?utm_source=content&utm_medium=WP_Installed_TermsPage&utm_campaign=WP_Installed_TermsPage" target="_blank" style="border-bottom: 1px solid rgb(51, 51, 51); color: rgb(51, 51, 51); text-decoration: none;">electronic signatures</a>&nbsp;as the default choice in lieu of paper. Be advised that according to the U.S. Federal E-SIGN Act in addition to various state laws an electronic signature is legally the same as a paper and ink signature. Also be advised in event enforcement is needed, all signatures are held in trust by SwiftSignature.com, as a neutral 3rd party, and may be legally enforced in court of law as per the terms of your respective contract.</p>
                            <p>Federal law requires certain safeguards to ensure that both consumers and vendors have the capability to receive copies of documents upon signature and are advised of the consequences of agreeing to receive documents electronically. Federal law also requires your consent to use e-mail and electronic versions of said contract and/or agreements, disclosures, and other documents and records, herein referred to as simply &quot;electronic documents&quot; that would otherwise be legally binding only if provided to you on paper as a printed physical document.</p>
                            <p>Electronic Documents for purpose of this disclosure include any documents signed using the Swift Signature service. All documents once signed cannot be revoked or canceled and will be stored for a minimum period of ten (10) years, and are available to either party at any time through our electronic web portal.</p>
                            <h3><strong>Free Document Storage Account</strong></h3>
                            <p>All signors are automatically entitled to a free document storage account within Swift Signature, the cost of which is given to you by the owner of this website. After signature, you may follow the prompts to save your document to your free account, where it will be accessible for a minumum of 10 years. This account is optional and available as a courtesy to you.</p>
                            <h4><strong>Right to withdraw consent</strong></h4>
                            <p>Note you do have the right to withdraw your consent to receive and/or use electronic documents, but be advised this does not cancel or revoke any prior documents for which permission existed at that time. The legal validity and enforcement&nbsp;of electronic documents, signatures, and deliveries used prior to revocation of consent will not be affected. To withdraw your consent, please contact the owner of this website.</p>
                            <h4><strong>Right to receive paper document</strong></h4>
                            <p>You have the right to have any document in paper form, should you choose at no charge to you. To request paper documents, please contact the party who referred you to this service.</p>
                            <p>By clicking &quot;Sign and Send&quot; on any document posting to SwiftCloud servers, you are agreeing to the terms contained herein, and are providing your consent to the use of electronic documents and signatures, as well as e-mail or sms phone message delivery of related electronic documents. You are also acknowledging receipt of this disclosure.</p>
                            <p><strong>Hardware &amp; Software Requirements</strong></p>
                            <h3>Use of this Service Requirements</h3>
                            <ol>
                                <li>Connection to the internet</li>
                                <li>Any internet web browser with graphical interface and a pointing device, aka &quot;a mouse&quot; for desktop computers or a touch screen for tablets or modern phones common after 2004</li>
                                <li>a PDF reader or browser capable of displaying Adobe PDF documents</li>
                                <li>A printer, should you wish to print and retain a paper copy of signed documents.</li>
                            </ol>
                            <p>Acknowledgement of your access and consent to electronic records and electronic signature</p>
                            <p>By clicking &quot;Sign &amp; Send&quot; on any document posting to this service, you agree that</p>
                            <ul>
                                <li>You were able to read this E-SIGN Act Disclosure &amp; Agreement</li>
                                <li>Should you desire, &nbsp;you were able to print on paper or electronically save this agreement for future reference</li>
                                <li>You have an active email on file with the owner of this website</li>
                                <li>That the device on which you indicated your agreement or signature, including both your hardware and your software comply with the terms above and were able to render the agreement in a&nbsp;fashion functionally equivalent to paper, and that the document agreed to was both readable and understandable.</li>
                                <li>That any indication of signature and/or initials in addition to information provided is wholly yours and subject to the terms above.</li>
                                <li>You consent to receive electronically any records, notices, agreements or disclosures made to you by our client, the referring service, during the course of your relationship with that company, subject to revocation per terms above.</li>
                            </ul>
                            <p style="text-align:center;">
                                <a href="https://SwiftCloud.ai/electronic-signature/?utm_source=viral&utm_medium=eSignatureInstalled&utm_content=eSignatureInstalled&utm_campaign=eSignatureInstalled&pr=88&button=CCTAO" target="_blank">Electronic Signature</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="https://SwiftCloud.ai/electronic-signature/consent?utm_source=viral&utm_medium=eSignatureInstalled&utm_content=eSignatureInstalled&utm_campaign=eSignatureInstalled" target="_blank">Disclosure & Consent</a>
                            </p>
                        </div>
                    </div>
                </div>';
    return $output;
}

add_shortcode('swift_button', 'swift_button_shortcode');

/*
 *  shortcode : [swift_date_today]
 *  Display current date in dd/mm/yyyy format.
 */

add_shortcode('swift_date_today', 'swift_date_today_shortcode');

function swift_date_today_shortcode() {
    $output = "";
    $get_ssing_date_format = get_option("ssing_date_format");
    $date_format = $get_ssing_date_format ? $get_ssing_date_format : "mm-dd-yy";
    $date = '';
    if ($date_format == "dd-mm-yy") {
        $date = date('d-m-Y');
    } else {
        $date = date('m-d-Y');
    }

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET['swift_date_today']) && !empty($_GET['swift_date_today'])) {
        $output .= '<span class="sc_print-field">' . $_GET['swift_date_today'] . '</span>';
    } else {
        $output .= '<input type="text" value="' . $date . '" name="extra_swift_date_today" class="swift_date_today" id="extra_swift_date_today" readonly />';
    }
    return $output;
}

/*
 *  shortcode : [swift_date name="field name" class="field class" required]
 *  Generates  a datepicker.
 *      name : field's name.
 *      class : add class to styling field.
 *      required: this field is required.
 */
add_shortcode('swift_date', 'swift_date_shortcode');

function swift_date_shortcode($attsDate) {
    wp_enqueue_style('swift-jquery-ui-style', plugins_url('/css/jquery-ui.css', dirname(__FILE__)), '', '', '');
    wp_enqueue_script('jquery-ui-datepicker');

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => '',
        'placeholder' => '',
        'required' => ''
            ), $attsDate);
    extract($a);

    if (!empty($attsDate) && !empty($attsDate) && in_array('required', $attsDate)) {
        $required = 'ss-required ';
    }

    $dateName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
    $dateClass = (!empty($class)) ? sanitize_title($class) : "";
    $dateValue = (!empty($value)) ? $value : "";
    $datePlaceholder = (!empty($placeholder)) ? $placeholder : 'choose date';
    $dateId = $dateName;

    $get_ssing_date_format = get_option("ssing_date_format");
    $date_format = $get_ssing_date_format ? $get_ssing_date_format : "mm-dd-yy";

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$dateName]) && !empty($_GET[$dateName])) {
        $output .= '<span class="sc_print-field">' . $_GET[$dateName] . '</span>';
    } else {
        $output .= '<input type="text" name="' . $dateName . '" id="' . $dateId . '" class="swift_datepicker ' . $required . $dateClass . '" value="' . $dateValue . '" placeholder="' . $datePlaceholder . '" />';
        $output .= '<script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery(".swift_datepicker").datepicker({
                            dateFormat: "' . $date_format . '",
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-100:+50"
                        });
                    });
               </script>';
    }
    return $output;
}

/**
 *  shortcode : [swift_circleword name="field's name" class="field's class" options="option1,option2,option3,....,optionN" checked="option name" required]
 *  Generates  a circleword. Radio button
 *      name : field's name.
 *      class : add class to styling field.
 *      options : radio button options, comma seprated list of optios.
 *      checked : pass option name which you want to pre-selected.
 *      required: this field is required.
 */
add_shortcode('swift_circleword', 'swift_circleword_shortcode');

function swift_circleword_shortcode($attscircles) {
    wp_enqueue_style('ss-cw-style', plugins_url('/css/jquery-labelauty.css', dirname(__FILE__)), '', '', '');
    wp_enqueue_script('ss-cw-script', plugins_url('/js/jquery-labelauty.js', dirname(__FILE__)), '', '', true);

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'options' => '',
        'checked' => '',
        'required' => ''
            ), $attscircles);
    extract($a);

    if (!empty($options)) {
        if (isset($attscircles) && !empty($attscircles) && in_array('required', $attscircles)) {
            $required = ' ss-cw-required ';
        }

        $cwName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
        $cwClass = (!empty($class)) ? sanitize_title($class) : "";
        $cwOptions = explode(",", rtrim($options, ","));

        if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$cwName]) && !empty($_GET[$cwName])) {
            $output .= '<span class="sc_print-field">' . $_GET[$cwName] . '</span>';
        } else {
            $output .= '<div class="cw-wrap ' . $required . '">';
            foreach ($cwOptions as $opt) {
                $cwChecked = "";
                $opt = trim($opt);
                if ((isset($_GET[$cwName]) && !empty($_GET[$cwName])) || (isset($_COOKIE[$cwName]) && !empty($_COOKIE[$cwName]) )) {
                    if ($opt == $_GET[$cwName] || $opt == $_COOKIE[$cwName]) {
                        $cwChecked = 'checked="checked"';
                    }
                } else if ($opt == $checked) {
                    $cwChecked = 'checked="checked"';
                }
                $opt_id = $cwName . "_" . sanitize_title($opt);
                $output .= '<input type="radio"  name="' . $cwName . '" id="' . $opt_id . '" data-labelauty="' . ucfirst($opt) . '|' . ucfirst($opt) . '" value="' . $opt . '" class="swift_cw_radio ' . $cwClass . '" ' . $cwChecked . ' />';
            }
            $output .= '</div>';
        }
        return $output;
    }
}

/**
 *      Shortcode: [swiftsignature size="small/medium/large"]
 *      - Display signature box with clear button
 *          size : signature box size; small/medium/large; default to small
 */
add_shortcode('swiftsignature', 'swift_signature_shortcode');

function swift_signature_shortcode($atts, $content = null) {
    wp_enqueue_style('ss-admin-style', plugins_url('/css/signature-pad.css', dirname(__FILE__)), '', '', '');
    wp_enqueue_script('ss-signature-pad', plugins_url('/js/signature_pad.js', dirname(__FILE__)), '', '', true);
    wp_enqueue_script('ss-signature-modal', plugins_url('/js/bootstrap.modal.min.js', dirname(__FILE__)), '', '', true);
    wp_enqueue_style('swift-typing-font', '//fonts.googleapis.com/css?family=Bilbo+Swash+Caps|Calligraffitti|Italianno|Loved+by+the+King|Mr+De+Haviland|Nothing+You+Could+Do|Reenie+Beanie', '', '', '');

    $output = "";
    $a = shortcode_atts(
            array(
        'size' => '',
            ), $atts);
    extract($a);

    $ss_size = "ss-size-small";
    $ss_cavas_size = "small";
    $ss_height = 100;
    $ss_width = 345;
    if (!empty($size)) {
        $ss_size = "ss-size-" . strtolower($size);
        switch ($size) {
            case 'medium': {
                    $ss_height = 155;
                    $ss_width = 525;
                    $ss_cavas_size = "medium";
                    break;
                }
            case 'large': {
                    $ss_height = 300;
                    $ss_width = 645;
                    $ss_cavas_size = "large";
                    break;
                }
        }
    }

    $rand_id = rand(1, 999999);
    $ssId = "signature-pad-" . $rand_id;
    $ssSignDataURL = "ss_signDataURL" . $rand_id;
    $ssSignClearId = "ss_signClear" . $rand_id;
    $ssSignTypingId = "ss_signType" . $rand_id;
    $ssing_auto_generate_sign_flag = get_option("ssing_auto_generate_sign");
    $arrow_img = '<img src=\"' . plugins_url('electronic-signatures/images/arrow_down.gif') . '\"  style=\"max-width: 20px\" />';
    $output .= '<div id="signature-box' . $rand_id . '" class="swift-signed-doc"><div id="' . $ssId . '" class="m-signature-pad ' . $ss_size . '">
                    <div class="m-signature-pad--body" id="signaturePad_' . $rand_id . '" data-id="' . $rand_id . '">
                        <canvas height="' . $ss_height . '" width="' . $ss_width . '"></canvas>
                    </div>
                    <div class="m-signature-pad--footer">
                        <button type="button" class="button clear" title="Clear" name="' . $ssSignClearId . '" id="' . $ssSignClearId . '" data-action="clear" value="Clear"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="button sign-typing" data-boxtype="sign" title="Type sign" name="' . $ssSignClearId . '" id="' . $ssSignTypingId . '" value="Type" data-pad-size="' . $ss_cavas_size . '"><i class="fa fa-keyboard-o"></i></button>
                        <input type="hidden" name="' . $ssSignDataURL . '" id="' . $ssSignDataURL . '" class="swift-sign-pad ss-sign-dataurl"/>
                        <input type="hidden" name="ssing_auto_generate_sign_flag" class="ssing_auto_generate_sign_flag" value="' . $ssing_auto_generate_sign_flag . '" />
                    </div>
                </div></div>';

    $output .= '
            <script type="text/javascript">
                window.addEventListener("load", function() {
                    var wrapper_' . $rand_id . ' = document.getElementById("' . $ssId . '");
                    if (typeof wrapper_' . $rand_id . ' !== "undefined" && wrapper_' . $rand_id . ' !== null) {
                        var clearButton = wrapper_' . $rand_id . '.querySelector("[data-action=clear]"),
                            saveButton  = wrapper_' . $rand_id . '.querySelector("[data-action=save]"),
                            canvas_' . $rand_id . ' = wrapper_' . $rand_id . '.querySelector("canvas"),
                            signaturePad_' . $rand_id . ';

                        signaturePad_' . $rand_id . ' = new SignaturePad(canvas_' . $rand_id . ',{
                            backgroundColor: "#fff",
                            penColor:"#053485",
                            minWidth:3.0,
                            onEnd:function(){
                                jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                            }
                        });

                        function resizeCanvas() {
                            var windowWidth = jQuery(window).outerWidth();
                            if(windowWidth <= 480){
                                var ratio = Math.max(window.devicePixelRatio || 1, 1);

                                jQuery("#signaturePad_' . $rand_id . '").css("width" , windowWidth - 30);
                                jQuery(".m-signature-pad, .m-signature-pad--body").css("width" , windowWidth - 30);
                                jQuery(".m-signature-pad--body canvas").css("width" , windowWidth - 30);
                                canvas_' . $rand_id . '.width = canvas_' . $rand_id . '.offsetWidth * ratio;
                                canvas_' . $rand_id . '.height = canvas_' . $rand_id . '.offsetHeight * ratio;
                                canvas_' . $rand_id . '.getContext("2d").scale(ratio, ratio);
                                signaturePad_' . $rand_id . '.clear();
                                jQuery("#' . $ssSignDataURL . '").val("");
                            }
                        }

                        window.onresize = resizeCanvas;
                        resizeCanvas();


                        jQuery("#' . $ssSignClearId . '").click(function() {
                            signaturePad_' . $rand_id . '.clear();
                            jQuery("#' . $ssSignDataURL . '").val("");
                            signaturePad_' . $rand_id . '.on();
                        });
                    }


                    //typing box submit
                    jQuery(document).on("click","#swiftsign-font-submit", function() {
                        jQuery("#ssing-typing-text").removeClass("swiftsign-typing-text-error");
                        var sign_text = jQuery("#ssing-typing-text").val();
                        var selectedFont = jQuery(".swiftsign-typing-preview").find(".swiftsign-font-selected").attr("data-font-style");
                        var fontSize="";

                        if (selectedFont && jQuery.trim(sign_text) !== "") {
                            if(jQuery("#ssing-counter").val()==0){
                                   jQuery("#ssing-counter").val(1);
                                   setTypeTextCookie(sign_text,"sign");
                            }

                            jQuery(".m-signature-pad--body").each(function() {
                                var Fwrapper = document.getElementById("signature-pad-' . $rand_id . '");
                                var Fcanvas = Fwrapper.querySelector("canvas");

                                var ctx = Fcanvas.getContext("2d");
                                ctx.clearRect(0, 0, Fcanvas.width, Fcanvas.height);
                                if(jQuery("#signature-pad-' . $rand_id . '").hasClass("ss-size-large")){
                                    ctx.font = "110px " + selectedFont;
                                    ctx.fillText(sign_text, 10, 165);
                                }else if(jQuery("#signature-pad-' . $rand_id . '").hasClass("ss-size-medium")){
                                    ctx.font = "70px " + selectedFont;
                                    ctx.fillText(sign_text, 10, 95);
                                }else{
                                    ctx.font = "40px " + selectedFont;
                                    ctx.fillText(sign_text, 10, 60);
                                }
                                ctx = "";
                                signaturePad_' . $rand_id . '.fillFontSign();
                                signaturePad_' . $rand_id . '.off();
                                jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                            });
                            jQuery("#swiftsign-typing-modal").modal("hide");
                            var fontModal = jQuery("#swiftsign-typing-modal");
                            fontModal.css("display", "none");
                        } else {
                            jQuery("#swiftsign-typing-modal .modal-footer").prepend("<span class=type-modal-error>Add sign text and select font.</span>");
                            jQuery("#ssing-typing-text").addClass("swiftsign-typing-text-error");
                        }
                    });

                    /* auto sign canvas if user type on swift name input */
                    if(jQuery(".ssing_auto_generate_sign_flag").val()==1){
                        jQuery(document).on("keyup, blur",".ss-swiftname", function() {
                            var sign_text = jQuery.trim(jQuery(".ss-swiftname").val());
                            var selectedFont = "\'Nothing You Could Do\', cursive";
                            var fontSize = "";

                            if (selectedFont && sign_text.length > 3) {
                                if(jQuery("#ssing-counter").val()==0){
                                       jQuery("#ssing-counter").val(1);
                                       setTypeTextCookie(sign_text,"sign");
                                }

                                jQuery(".m-signature-pad--body").each(function() {
                                    var Fwrapper = document.getElementById("signature-pad-' . $rand_id . '");
                                    var Fcanvas = Fwrapper.querySelector("canvas");

                                    var ctx = Fcanvas.getContext("2d");
                                    ctx.clearRect(0, 0, Fcanvas.width, Fcanvas.height);
                                    if(jQuery("#signature-pad-' . $rand_id . '").hasClass("ss-size-large")){
                                        ctx.font = "110px " + selectedFont;
                                        ctx.fillText(sign_text, 10, 165);
                                    }else if(jQuery("#signature-pad-' . $rand_id . '").hasClass("ss-size-medium")){
                                        ctx.font = "70px " + selectedFont;
                                        ctx.fillText(sign_text, 10, 95);
                                    }else{
                                        ctx.font = "40px " + selectedFont;
                                        ctx.fillText(sign_text, 10, 60);
                                    }
                                    ctx = "";

                                    signaturePad_' . $rand_id . '.fillFontSign();
                                    signaturePad_' . $rand_id . '.off();
                                    jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                                });
                            }
                        });
                    }
                }, false);
            </script>';
    return $output;
}

/*
 *  shortcode : [swift_initials]
 *  - Display initials box with clear button
 *  - No attributes
 */
add_shortcode('swift_initials', 'swift_initials_shortcode');

function swift_initials_shortcode($atts) {
    wp_enqueue_style('ss-admin-style', plugins_url('/css/signature-pad.css', dirname(__FILE__)), '', '', '');
    wp_enqueue_script('ss-signature-pad', plugins_url('/js/signature_pad.js', dirname(__FILE__)), '', '', true);

    $output = "";
    $rand_id = rand(1, 999999);
    $ssId = "initials-pad-" . $rand_id;
    $ssSignDataURL = "ss_signDataURL" . $rand_id;
    $ssSignClearId = "ss_signClear" . $rand_id;
    $ssSignTypingId = "ss_signType" . $rand_id;
    $ssing_auto_generate_sign_flag = get_option("ssing_auto_generate_sign");

    $output .= '<div id="signature-box' . $rand_id . '" class="swift-initial-doc"><div id="' . $ssId . '" class="m-initials-pad">
                    <div class="m-initials-pad--body">
                        <canvas height="100" width="180"></canvas>
                    </div>
                    <div class="m-initials-pad--footer">
                        <button type="button" class="button clear" title="Clear" name="' . $ssSignClearId . '" id="' . $ssSignClearId . '" data-action="clear" value="Clear"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="button sign-typing" data-boxtype="initials" title="Type sign" name="' . $ssSignClearId . '" id="' . $ssSignTypingId . '" value="Type"><i class="fa fa-keyboard-o"></i></button>
                        <input type="hidden" name="' . $ssSignDataURL . '" id="' . $ssSignDataURL . '" class="swift-sign-pad ss-initials-dataurl"/>
                        <input type="hidden" name="ssing_auto_generate_sign_flag" class="ssing_auto_generate_sign_flag" value="' . $ssing_auto_generate_sign_flag . '" />
                    </div>
                </div></div>';

    $output .= '
            <script type="text/javascript">
                window.addEventListener("load", function() {
                    var wrapper_' . $rand_id . ' = document.getElementById("' . $ssId . '");
                    if (typeof wrapper_' . $rand_id . ' !== "undefined" && wrapper_' . $rand_id . ' !== null) {
                        var clearButton = wrapper_' . $rand_id . '.querySelector("[data-action=clear]"),
                            saveButton  = wrapper_' . $rand_id . '.querySelector("[data-action=save]"),
                            canvas_' . $rand_id . ' = wrapper_' . $rand_id . '.querySelector("canvas"),
                            signaturePad_' . $rand_id . ';

                        signaturePad_' . $rand_id . ' = new SignaturePad(canvas_' . $rand_id . ',{
                          backgroundColor: "#fff",
                          penColor:"#053485",
                          minWidth:2.0,
                          onEnd:function(){
                            jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                          }
                        });

                        jQuery("#' . $ssSignClearId . '").click(function() {
                            signaturePad_' . $rand_id . '.clear();
                            jQuery("#' . $ssSignDataURL . '").val("");
                            signaturePad_' . $rand_id . '.on();
                        });
                    }

                    //typing box submit
                    jQuery(document).on("click","#initials-font-submit", function() {
                        jQuery("#ssing-typing-text").removeClass("swiftsign-typing-text-error");
                        var sign_text = jQuery("#ssing-typing-text").val();
                        var selectedFont = jQuery(".swiftsign-typing-preview").find(".swiftsign-font-selected").attr("data-font-style");

                        if (selectedFont && jQuery.trim(sign_text) !== "") {

                            if(jQuery("#ssing-counter").val()==0){
                                jQuery("#ssing-counter").val(1);
                                setTypeTextCookie(sign_text,"initials");
                            }
                            jQuery(".m-initials-pad--body").each(function() {
                                var Fwrapper = document.getElementById("initials-pad-' . $rand_id . '");
                                var Fcanvas = Fwrapper.querySelector("canvas");

                                var ctx = Fcanvas.getContext("2d");
                                ctx.clearRect(0, 0, Fcanvas.width, Fcanvas.height);
                                ctx.font = "40px " + selectedFont;
                                ctx.fillText(sign_text, 10, 60);
                                ctx = "";

                                signaturePad_' . $rand_id . '.fillFontSign();
                                signaturePad_' . $rand_id . '.off();
                                jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                            });
                            jQuery("#swiftsign-typing-modal").modal("hide");
                            var fontModal = jQuery("#swiftsign-typing-modal");
                            fontModal.css("display", "none");
                        } else {
                            jQuery("#swiftsign-typing-modal .modal-footer").prepend("<span class=type-modal-error>Add sign text and select font.</span>");
                            jQuery("#ssing-typing-text").addClass("swiftsign-typing-text-error");
                        }
                    });


                    /* auto sign initial canvas if user type on swift name input */
                    if(jQuery(".ssing_auto_generate_sign_flag").val()==1){
                        jQuery(document).on("keyup, blur",".ss-swiftname", function() {
                            var sign_text = jQuery.trim(jQuery(this).val());
                            var selectedFont = "\'Nothing You Could Do\', cursive";

                            if (selectedFont && sign_text.length > 3) {
                                var result = sign_text.split(" ").reduce(function(previous, current){
                                    return {v : previous.v + current[0]};
                                },{v:""});
                                sign_text = result.v;
                                sign_text = sign_text.toUpperCase();

                                if(jQuery("#ssing-counter").val()==0){
                                    jQuery("#ssing-counter").val(1);
                                    setTypeTextCookie(sign_text,"initials");
                                }
                                jQuery(".m-initials-pad--body").each(function() {
                                    var Fwrapper = document.getElementById("initials-pad-' . $rand_id . '");
                                    var Fcanvas = Fwrapper.querySelector("canvas");

                                    var ctx = Fcanvas.getContext("2d");
                                    ctx.clearRect(0, 0, Fcanvas.width, Fcanvas.height);
                                    ctx.font = "40px " + selectedFont;
                                    ctx.fillText(sign_text, 10, 60);
                                    ctx = "";

                                    signaturePad_' . $rand_id . '.fillFontSign();
                                    signaturePad_' . $rand_id . '.off();
                                    jQuery("#' . $ssSignDataURL . '").val(signaturePad_' . $rand_id . '.toDataURL());
                                });
                            }
                        });
                    }
                }, false);
            </script>';
    return $output;
}

/**
 *  shortcode : [swift_textarea class="class name" name="textarea's name" value="textarea's value" rows="" placeholder="placeholder value" required]
 *  Generate a textarea.
 *      class : add class to textarea for styling.
 *      name  : textarea name.
 *      value : textarea prefill value. default is blank.
 *      placeholder : add placeholder in textarea.
 *      rows : rows of textarea. default 5 rows.
 *      required: textarea is required.
 *      size: medium,long , full line; size of field.
 */
add_shortcode('swift_textarea', 'swift_textarea_shortcode');

function swift_textarea_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => '',
        'rows' => '',
        'size' => '',
        'readonly' => '',
        'required' => '',
            ), $atts);
    extract($a);

    if (isset($atts) && !empty($atts) && in_array('required', $atts)) {
        $required = 'ss-required ';
    }

    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    $txareaName = !empty($name) ? sanitize_title("extra_" . trim($name)) : "";
    $txareaClass = (!empty($class)) ? sanitize_title($class) : "";
//    $txareaValue = (isset($_GET[$txareaName]) && !empty($_GET[$txareaName])) ? $_GET[$txareaName] : ((!empty($value)) ? $value : "");
    $txareaValue = (isset($_GET[$txareaName]) && !empty($_GET[$txareaName])) ? $_GET[$txareaName] : ((isset($_COOKIE[$txareaName]) && !empty($_COOKIE[$txareaName])) ? $_COOKIE[$txareaName] : (!empty($value) ? $value : ""));

    $txareaPlaceholder = (!empty($placeholder)) ? $placeholder : $name;
    $txareaRow = (!empty($rows)) ? ' rows="' . $rows . '"' : ' rows="5"';
    $txareaId = sanitize_title($txareaName);
    $txareaSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txareaName]) && !empty($_GET[$txareaName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txareaName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txareaName . '" id="' . $txareaId . '" class="ss-readonly" value="' . $txareaValue . '" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txareaValue . '</span>';
    } else {
        $output = '<textarea name="' . $txareaName . '" id="' . $txareaId . '" class="' . $required . $txareaClass . $txareaSize . '" placeholder="' . $txareaPlaceholder . '"' . $txareaRow . $readonly . ' >' . $txareaValue . '</textarea>';
    }
    return $output;
}

/**
 *      shortcode : [swift_date_time_now]
 *      Display current system time HH:MM 24-hours formate
 */
add_shortcode('swift_date_time_now', 'swift_date_time_now_shortcode');

function swift_date_time_now_shortcode($atts) {
    $output = "";

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET['swift_date_time_now']) && !empty($_GET['swift_date_time_now'])) {
        $output .= '<span class="sc_print-field">' . $_GET['swift_date_time_now'] . '</span>';
    } else {
        $output .= '<input type="text" name="extra_swift_date_time_now" class="swift_date_time_now" id="extra_swift_date_time_now" readonly />';
    }
    $output .= '<script type="text/javascript">
                    jQuery(document).ready(function() {
                       var dt = new Date();
                       var hours = dt.getHours().toString();
                           if (hours.length < 2){hours = \'0\' + hours;}
                       var minutes = dt.getMinutes().toString();
                           if (minutes.length < 2){minutes = \'0\' + minutes;}
                       jQuery("#swift_date_time_now").val(hours+ ":" + minutes);
                    });
               </script>';
    return $output;
}

/*
 *  shortcode : [swift_date_long]
 *  Display current date in day, Month date(nd), Year format.
 *  ex: Friday, December 2nd, 2017
 */

add_shortcode('swift_date_long', 'swift_date_long_shortcode');

function swift_date_long_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'readonly' => '',
            ), $atts);
    extract($a);

    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    $date = date('l, F jS, Y');
    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET['swift_date_long']) && !empty($_GET['swift_date_long'])) {
        $output .= '<span class="sc_print-field">' . $_GET['swift_date_long'] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="extra_swift_date_long" id="extra_swift_date_long" value="' . $date . '" class="ss-readonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $date . '</span>';
    } else {
        $output .= '<input type="text" value="' . $date . '" name="extra_swift_date_long" class="swift_date_long" id="extra_swift_date_long" readonly />';
    }
    return $output;
}

/*
 *  shortcode : [swift_name class="class name" name="name" value="textbox's value" placeholder="placeholder value" required]
 *  Generate a textbox. This shortcode is specific for "name" field of SwiftForm.
 *      class : add class to textbox for styling.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: textbox is required.
 *      size: medium,long , full line; size of field.
 */
add_shortcode('swift_name', 'swift_name_shortcode');

function swift_name_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => '',
        'placeholder' => '',
        'size' => '',
        'readonly' => '',
            ), $atts);
    extract($a);

    if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $readonly = 'readonly="readonly" ';
    }

    $required = 'ss-required ';
    $txtBoxName = !empty($name) ? sanitize_title($name) : "name";
    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    if ($txtBoxName != "name") {
        $txtBoxClass .= " ss-swiftname-extra ";
    } else {
        $txtBoxClass .= " ss-swiftname ";
    }
//    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : (!empty($value) ? $value : "");
    $txtBoxValue = (isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) ? $_GET[$txtBoxName] : ((isset($_COOKIE[$txtBoxName]) && !empty($_COOKIE[$txtBoxName])) ? $_COOKIE[$txtBoxName] : (!empty($value) ? $value : ""));

    $txtBoxPlaceholder = (!empty($placeholder)) ? $placeholder : "Name";
    $txtBoxId = sanitize_title($txtBoxName);
    $txtBoxId = !empty($txtBoxId) ? $txtBoxId : "name";
    $txtBoxSize = !empty($size) ? " ss-size-" . sanitize_text_field($size) : ' ss-size-medium';

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else if (isset($atts) && !empty($atts) && in_array('readonly', $atts)) {
        $output = '<input type="hidden" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="ss-readonly" ' . $readonly . ' />';
        $output .= '<span class="ss-readonly">' . $txtBoxValue . '</span>';
    } else {
        $output = '<input type="text" name="' . $txtBoxName . '" id="' . $txtBoxId . '" value="' . $txtBoxValue . '" class="' . $required . $txtBoxClass . $txtBoxSize . '" placeholder="' . $txtBoxPlaceholder . '" ' . $readonly . ' />';
    }
    return $output;
}

/**
 *      shortcode: swift_date_dropdown
 *      - Date dropdown
 *      name : field's name.
 *      class : add class to styling field.
 *      required: this field is required.
 */
add_shortcode('swift_date_dropdown', 'ssing_swift_date_dropdown_shortcode');

function ssing_swift_date_dropdown_shortcode($attsDate) {
    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => '',
        'placeholder' => '',
        'required' => '',
            ), $attsDate);
    extract($a);

    if (!empty($attsDate)) {
        if (in_array('required', $attsDate)) {
            $required = 'ss-required ';
        }
    }

    $dateName = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";
    $dateClass = (!empty($class)) ? sanitize_title($class) : "";
    $dateId = sanitize_title($dateName);

//day
    $day_dd_name = (!empty($dateName)) ? $dateName . '[]' : '';
    $day_dd_id = (!empty($dateId)) ? $dateId . '_day' : '';

    $output .= '<select name="' . $day_dd_name . '" id="' . $day_dd_id . '" class="swift_date_dropdown ' . $required . $dateClass . '">';
    $output .= '<option value="">Select Day</option>';
    for ($day = 1; $day <= 31; $day++) {
        $output .= '<option value="' . $day . '">' . str_pad($day, 2, '0', STR_PAD_LEFT) . '</option>';
    }
    $output .= '</select>';

//month
    $month_dd_name = (!empty($dateName)) ? $dateName . '[]' : '';
    $month_dd_id = (!empty($dateId)) ? $dateId . '_month' : '';

    $output .= '<select name="' . $month_dd_name . '" id="' . $month_dd_id . '" class="swift_date_dropdown ' . $required . $dateClass . '">';
    $output .= '<option value="">Select Month</option>';
    for ($m = 1; $m <= 12; ++$m) {
        $month = date('M', mktime(0, 0, 0, $m, 1));
        $output .= '<option value="' . $month . '">' . str_pad($m, 2, '0', STR_PAD_LEFT) . " " . $month . '</option>';
    }
    $output .= '</select>';

//year
    $year_input_name = (!empty($dateName)) ? $dateName . '[]' : '';
    $year_input_id = (!empty($dateId)) ? $dateId . '_year' : '';
    $output .= '<select name="' . $year_input_name . '" id="' . $year_input_id . '" class="swift_date_dropdown ' . $required . $dateClass . '">';
    $output .= '<option value="">Select Year</option>';
    for ($y = 1900; $y <= (date('Y') + 10); ++$y) {
        $output .= '<option value="' . $y . '">' . $y . '</option>';
    }
    $output .= '</select>';
    return $output;
}

add_action('wp_footer', 'ssing_sing_typing_modal', 20);

function ssing_sing_typing_modal() {
    ?>
    <div class="swiftsign-modal sc_typing-popup" data-backdrop="static" id="swiftsign-typing-modal" tabindex="-1" role="dialog">
        <div class="swiftsign-modal-overlay"></div>
        <div class="swiftsign-modal-content">
            <div class="swiftsign-modal-close"><img data-dismiss="modal" src="<?php echo plugins_url('../images/close.png', __FILE__) ?>"/></div>
            <input type="text" class="ssing-typing-text" id="ssing-typing-text" value="Your name here" placeholder="Type here"/>

            <input type="hidden" id="ssing-val" value="<?php echo (isset($_COOKIE['ssing_username']) && !empty($_COOKIE['ssing_username'])) ? $_COOKIE['ssing_username'] : "Your name here"; ?>" />
            <input type="hidden" id="ssing-initials-val" value="<?php echo (isset($_COOKIE['ssing_initial_username']) && !empty($_COOKIE['ssing_initial_username'])) ? $_COOKIE['ssing_initial_username'] : "Your name here"; ?>" />
            <input type="hidden" id="ssing-counter" value="0" />
            <div class="swiftsign-typing-preview">
                <div class="swiftsign-font-type" data-font-style="Calligraffitti" style="font-family: 'Calligraffitti', cursive;">Your name here</div>
                <div class="swiftsign-font-type" data-font-style="Reenie Beanie" style="font-family: 'Reenie Beanie', cursive;">Your name here</div>
                <div class="swiftsign-font-type swiftsign-font-selected" data-font-style="Nothing You Could Do" style="font-family: 'Nothing You Could Do', cursive;">Your name here</div>
                <div class="swiftsign-font-type" data-font-style="Bilbo Swash Caps" style="font-family: 'Bilbo Swash Caps', cursive;">Your name here</div>

                <div class="swiftsign-font-type" data-font-style="Italianno" style="font-family: 'Italianno', cursive;">Your name here</div>
                <div class="swiftsign-font-type" data-font-style="Loved by the King" style="font-family: 'Loved by the King', cursive;">Your name here</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="swiftsign-font-submit" id="swiftsign-font-submit"><i class="fa fa-pencil"></i> Use selected</button>
            </div>
        </div>
    </div>
    <?php
}

/**
 *      shortcode: swiftsign_showhide
 *      - Show/Hide field based on selected answer
 *      default: default to show/hide
 *      trigger: parent element id
 *      value: value on which it should show/hide element
 */
add_shortcode('swift_showhide', 'ssing_swift_showhide_shortcode');

function ssing_swift_showhide_shortcode($atts, $content = null) {
    $output = "";
    $a = shortcode_atts(
            array(
        'default' => '',
        'trigger' => '',
        'value' => '',
            ), $atts
    );
    extract($a);

    if (isset($trigger) && !empty($trigger)) {
        $trigger = sanitize_title($trigger);
        $stripped_content = strip_tags($content);
        $shownFlag = (isset($default) && !empty($default) && ($default == "show" || $default == "hide")) ? (($default == "show") ? "style='display:block;'" : "style='display:none;'") : "style='display:none;'";
        $output = '<div class="swift_showhide_container_' . $trigger . '" ' . $shownFlag . '>';
        $output .= do_shortcode($stripped_content);
        $output .= '</div>';
        $output .= '<script type="text/javascript">';
        $output .= 'jQuery(document).ready(function(){';
        $output .= '    jQuery("#extra_' . $trigger . '").on("change", function(e) {';
        $output .= '        if(this.value == "' . $value . '"){';
        $output .= '            jQuery(".swift_showhide_container_' . $trigger . '").show()';
        $output .= '        }else{ ';
        $output .= '            jQuery(".swift_showhide_container_' . $trigger . '").hide()';
        $output .= '        }';
        $output .= '    });';
        $output .= '    jQuery("input[name=extra_' . $trigger . ']:radio").on("change", function(e) {';
        $output .= '        if(this.value == "' . $value . '"){';
        $output .= '            jQuery(".swift_showhide_container_' . $trigger . '").show()';
        $output .= '        }else{ ';
        $output .= '            jQuery(".swift_showhide_container_' . $trigger . '").hide()';
        $output .= '        }';
        $output .= '    });';
        $output .= '});';
        $output .= '</script>';
    }
    return $output;
}

/*
 *  shortcode : [swift_agree class="class name" checked="option_name"]
 *  Generate a checkbox.
 *      class : add class to styling checkbox.
 *      checked : pass option name which you want to pre-selected.
 *      required: checkbox is required.
 */

add_shortcode('swift_agree', 'swift_input_checkbox_agree_shortcode');

function swift_input_checkbox_agree_shortcode($attsChbx) {

    $output = $required = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'checked' => '',
            ), $attsChbx);
    extract($a);

    $chkbox_id = 1;
    if (isset($_SESSION['checkbox_agree_id']) && !empty($_SESSION['checkbox_agree_id'])) {
        $chkbox_id = $_SESSION['checkbox_agree_id'] + 1;
        $_SESSION['checkbox_agree_id'] = $chkbox_id;
    } else {
        $_SESSION['checkbox_agree_id'] = 1;
    }

    $required = 'ss-checkbox-required ';
    $chkBoxName = sanitize_title("extra_check_to_agree_" . $chkbox_id);
    $chkBoxClass = (!empty($class)) ? $class : "";
    $chkOptions = array("agreed");
    $checkedOptions = !empty($checked) ? @explode(",", $checked) : array();

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$chkBoxName]) && !empty($_GET[$chkBoxName])) {
        $output .= '<span class="sc_print-field">' . $_GET[$chkBoxName] . '</span>';
    } else {
        $output .= '<span class="checkbox-wrap ' . $required . '" style="display: inline;">';
        foreach ($chkOptions as $opt) {
            $chkChecked = "";
            $opt = trim($opt);
            if (isset($_GET[$chkBoxName]) && !empty($_GET[$chkBoxName])) {
                if ($opt == $_GET[$chkBoxName]) {
                    $chkChecked = "checked='checked'";
                }
            } else if (in_array($opt, $checkedOptions)) {
                $chkChecked = "checked='checked'";
            }
            $opt_id = $chkBoxName . "_" . sanitize_title($opt);
            $output .= '<span class="pure-checkbox" style="display: inline;"><input type="checkbox" id="' . $opt_id . '" name="' . $chkBoxName . '" value="' . $opt . '" class="swift_check ' . $chkBoxClass . '" ' . $chkChecked . ' /><label class="ss-checkboxset" for="' . $opt_id . '" style="display: inline; padding-left: 1em;">&nbsp;</label></span>';
        }
        $output .= '</span>';
    }
    return $output;
}

function reset_checkbox_agree_id() {
    $_SESSION['checkbox_agree_id'] = 0;
}

add_action('init', 'reset_checkbox_agree_id');


/*
 *  shortcode : [swift_file_upload name="input file name" class="class name" required]
 *  Generate a input file upload.
 *      name : name of input file upload.
 *      class : add class to input file.
 *      required: Input file upload is required.
 */

add_shortcode('swift_file_upload', 'swift_input_file_upload_shortcode');

function swift_input_file_upload_shortcode($attr) {
    wp_enqueue_script('ss-signature-upload', plugins_url('/js/ajaxupload.js', dirname(__FILE__)), '', '', true);

    $max_upload_limit = ini_get("upload_max_filesize");
    $output = $required = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'required' => ''
            ), $attr);
    extract($a);

    $txtBoxClass = (!empty($class)) ? sanitize_title($class) : "";
    $txtBoxName = $txtBoxId = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "";

    if (isset($attr) && !empty($attr) && in_array('required', $attr)) {
        $required = 'ss-file-required';
    }

    if (isset($_GET['mode']) && !empty($_GET['mode']) && ($_GET['mode'] == 'print') && isset($_GET[$txtBoxName]) && !empty($_GET[$txtBoxName])) {
        $output = '<span class="sc_print-field">' . $_GET[$txtBoxName] . '</span>';
    } else {
        $output = '<div class="swiftsign-uploadContainer ' . $required . '"><div class="swiftsign-upload-btn" data-attr="' . $txtBoxId . '"><p><i class="fa fa-cloud-upload"></i></p></div><input type="file" name="' . $txtBoxId . '" id="' . $txtBoxId . '" multiple class="swiftsign-file-upload" /><input type="hidden" name="' . $txtBoxName . '_hidden" id="' . $txtBoxId . '_hidden" /></div>';
        $output .= '';
    }
    return $output;
}

/*
 *  shortcode : [swift_webcam name="webcam field name" required]
 *        Generate a webcam capture field.
 *        name : name of input field.
 *        size: size of webcam
 *        required: Webcam field is required.
 */

add_shortcode('swift_webcam', 'swift_webcam_shortcode');

function swift_webcam_shortcode($attr) {
    wp_enqueue_script('swiftsign-webcam', plugins_url('/js/webcam.js', dirname(__FILE__)), '', '', true);

    $output = $required = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'size' => '',
        'required' => ''
            ), $attr);
    extract($a);

    $txtBoxName = $txtBoxId = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "extra_ss_webcam_" . time();

    $ss_width = 320;
    $ss_height = 240;
    $ss_webcam_cls = "";
    $ss_webcam_col_cls = "swiftsign-webcam-cols";

    if (!empty($size)) {
        switch ($size) {
            case 'medium': {
                    $ss_width = 420;
                    $ss_height = 320;
                    $ss_webcam_cls = 'swiftsign-webcam-row';
                    break;
                }
            case 'large': {
                    $ss_width = 500;
                    $ss_height = 380;
                    $ss_webcam_cls = 'swiftsign-webcam-row';
                    break;
                }
        }
    }


    if (isset($attr) && !empty($attr) && in_array('required', $attr)) {
        $required = 'swiftsign-webcam-required';
    }
    $output = '<div class="swiftsign-webcam-container ' . $ss_webcam_cls . '">
                    <div class="swiftsign-webcam ' . $ss_webcam_col_cls . '">
                         <div id="' . $txtBoxId . '" class=""></div><button type="button" class="swiftsign-webcam-btn" onClick="take_snapshot()"><i class="fa fa-camera"></i></button>
                    </div>
                    <div class="swiftsign-webcam-preview ' . $ss_webcam_col_cls . '">
                         <input type="hidden" name="' . $txtBoxName . '_hidden" id="' . $txtBoxId . '_hidden" /><div id="results"></div>
                    </div>
               </div>';

    $output .= '   <script language="JavaScript">
                         window.addEventListener("load", function() {
                              Webcam.set({
                                   width:  ' . $ss_width . ',
                                   height:  ' . $ss_height . ',
                                   image_format: "jpeg",
                                   jpeg_quality: 90
                              });
                              Webcam.attach("#' . $txtBoxId . '");
                         });
                         function take_snapshot() {
                              // take snapshot and get image data
                              Webcam.snap(function (data_uri) {
                                   document.getElementById("results").innerHTML = "<img src=\'" + data_uri + "\'/>";
                                   document.getElementById("' . $txtBoxId . '_hidden").value = data_uri;
                              });
                         }

                    </script>';
    return $output;
}

/*
 *  shortcode : [swift_ID required]
 *        Generate a ID custom field.
 *        required: ID is required.
 */

add_shortcode('swift_ID', 'swift_ID_shortcode');

function swift_ID_shortcode($attr) {
    wp_enqueue_script('swiftsign-webcam', plugins_url('/js/webcam.js', dirname(__FILE__)), '', '', true);
    wp_enqueue_script('ss-signature-upload', plugins_url('/js/ajaxupload.js', dirname(__FILE__)), '', '', true);

    $output = $required = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'size' => '',
        'required' => ''
            ), $attr);
    extract($a);

    $txtBoxName = $txtBoxId = (!empty($name)) ? sanitize_title("extra_" . trim($name)) : "extra_ss_id_" . time();

    if (isset($attr) && !empty($attr) && in_array('required', $attr)) {
        $required = 'swiftsign-webcam-required';
    }

    $ss_webcam = '
                    <div class="swiftsign-webcam-container">
                        <div class="swiftsign-webcam swiftsign-webcam-cols">
                             <div id="' . $txtBoxId . '_webcam" class=""></div><button type="button" class="swiftsign-webcam-btn" onClick="take_snapshot()"><i class="fa fa-camera"></i></button>
                        </div>
                    </div>
                    <script language="JavaScript">
                         window.addEventListener("load", function() {
                              Webcam.set({
                                   width: 320,
                                   height: 240,
                                   image_format: "jpeg",
                                   jpeg_quality: 90
                              });
                              Webcam.attach("#' . $txtBoxId . '_webcam");
                         });
                         function take_snapshot() {
                              // take snapshot and get image data
                              Webcam.snap(function (data_uri) {
                                   document.getElementById("ss-id-webcam-results").innerHTML = "<img src=\'" + data_uri + "\'/>";
                                   document.getElementById("' . $txtBoxId . '_hidden").value = data_uri;
                              });
                         }
                    </script>';

    $ss_file_upload = '<div class="swiftsign-uploadContainer ' . $required . '"><div class="swiftsign-upload-btn" data-attr="' . $txtBoxId . '" style="width: 100%;"><p><i class="fa fa-cloud-upload"></i></p></div><input type="file" name="' . $txtBoxId . '" id="' . $txtBoxId . '" class="swiftsign-file-upload" /></div>';

    $output = '
                    <div class="ss-swift-id-field-containter">
                        <div class="ss-swift-id-table-row">
                            <div class="ss-swift-id-table-col">
                                ' . $ss_webcam . '
                            </div>
                            <div class="ss-swift-id-table-col">
                                ' . $ss_file_upload . '
                            </div>
                            <div class="ss-swift-id-table-col">
                                <div id="ss-id-webcam-results"></div>
                                <input type="hidden" name="' . $txtBoxName . '_hidden" id="' . $txtBoxId . '_hidden" />
                            </div>
                        </div>
                    </div>
                ';
    return $output;
}

/*
 *  shortcode : [swiftsign_affiliate_name required]
 *        Generate hidden field for Affiliate / Source Name.
 *        This will only work with Swift BloodHound plugin
 */

add_shortcode('swiftsign_affiliate_name', 'swiftsign_affiliate_name_shortcode');

function swiftsign_affiliate_name_shortcode() {
    if (isset($_COOKIE['agent_id'])) {
        if ($agent_meta = get_user_by('id', $_COOKIE['agent_id'])) {
            return '<input type="hidden" name="extra_affiliate_name" id="extra_affiliate_name" value="' . $agent_meta->display_name . '" />';
        }
    }
}

/*
 *  shortcode : [swift_thanksurl url='']
 *  Generate hidden field for vThanksURL.
 */

add_shortcode('swift_thanksurl', 'swift_thanksurl_shortcode');

function swift_thanksurl_shortcode($attr) {
    $output = $url = "";
    $a = shortcode_atts(
            array(
        'url' => '',
            ), $attr);
    extract($a);

    if (isset($url) && !empty($url)) {
        $output = '
                    <script type="text/javascript">
                         window.addEventListener("load", function() {
                             jQuery("#ssign-hidden-fields").append("<input type=\"hidden\" name=\"vThanksRedirect\" value=\"' . $url . '\" />");
                         });
                    </script>';
    }
    return $output;
}
?>
