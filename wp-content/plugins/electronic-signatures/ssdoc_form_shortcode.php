<?php

/*
 *  Shortcode :  [swift_form method="GET/POST" action="form action"].....[/swift_form]
 *  Generates a form.
 *      method : form method GET or POST. Default is POST
 *      action : gives action to form for submit. Default is blank.
 *      swift_form_id : form id of swift form. for ex: 266,261 etc..
 */

function swift_form_shortcode($atts, $content = null) {
    wp_enqueue_style('swift-signature-front-style', plugins_url('css/ss_front.css', __FILE__), '', '', '');
    wp_enqueue_style('ssdoc-checkbox-radio-style', plugins_url('css/kalypto.css', __FILE__), '', '', '');
    wp_enqueue_script('ssdoc-checkbox-radio', plugins_url('js/kalypto.js', __FILE__), array('jquery'), '', true);
    wp_enqueue_script('ssdoc-comman', plugins_url('js/ssdoc_form.js', __FILE__), array('jquery'), '', true);

    $output = "";
    $a = shortcode_atts(
            array(
        'method' => '',
        'action' => '',
        'swift_form_id' => ''
            ), $atts);
    extract($a);

    $formContent = $content;
    $frmMethod = !empty($method) ? $method : 'POST';
    $frmAction = !empty($action) ? $action : "";
    if (!empty($swift_form_id)) {
        $output.= '<script src="http://swiftcloud.me/js/jstz.min.js" type="text/javascript"></script>';
        $output.= '<form name="Frmswift" id="Frmswift" action="' . $frmAction . '" method="' . $frmMethod . '">' . do_shortcode($formContent);
        $output.='<input id="SC_fh_ip_address" type="hidden" style="" name="ip_address" value="' . $_SERVER['REMOTE_ADDR'] . '">
                      <input id="SC_fh_timezone" type="hidden" style="" name="timezone" value="">
                      <input id="SC_fh_language" type="hidden" style="" name="language" value="">
                      <input id="SC_fh_capturepage" type="hidden" style="" name="capturepage" value="">
                      <input type="hidden" name="formid" id="formid" value="' . $swift_form_id . '">
                      <input style="" name="signaturestatus" value="signed_singleparty" type="hidden">
                      <input id="sc_lead_referer" type="hidden" value="" name="sc_lead_referer"/>
                      <input type="hidden" value="817" name="iSubscriber">
                      <input id="sc_referer_qstring" type="hidden" value="" name="sc_referer_qstring"/>';
        $output.="</form>";
        $output.="<script type='text/javascript'>
                    jQuery(document).ready(function() {
                        if (jQuery('#SC_fh_timezone').size() > 0) {
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
    } else {
        $output.="<p style='color:red;font-size:18px;'>Heads up! Your form will not display until you add a form ID number in the control panel.</p>";
    }
    return $output;
}

add_shortcode('swift_form', 'swift_form_shortcode');

/*
 *  shortcode : [swift_textbox class="class name" name="textbox's name" value="textbox's value" placeholder="placeholder value" required]
 *  Genrates a textbox.
 *      class : add class to textbox for styling.
 *      name  : textbox name.
 *      value : textbox prefill value. default is blank.
 *      placeholder : add placeholder in textbox.
 *      required: textbox is required.
 */

function swift_input_text_shortcode($atts) {
    $output = "";
    $a = shortcode_atts(
            array(
        'class' => '',
        'name' => '',
        'value' => '',
        'placeholder' => ''
            ), $atts);
    extract($a);

    if (in_array('required', $atts)) {
        $required = 'ss-required';
    }

    $txtBoxClass = !empty($class) ? $class : "";
    $txtBoxName = !empty($name) ? $name : "";
    $txtBoxValue = !empty($value) ? $value : "";
    $txtBoxPlaceholder = !empty($placeholder) ? $placeholder : "";

    $output = '<input type="text" class="' . $required . ' ' . $txtBoxClass . '" id="' . $txtBoxName . '" name="' . $txtBoxName . '" value="' . $txtBoxValue . '" placeholder="' . $txtBoxPlaceholder . '" />';
    return $output;
}

add_shortcode('swift_textbox', 'swift_input_text_shortcode');

/*
 *  shortcode : [swift_checkbox name="checkbox's name" class="class name"  value="checkbox's value" required]
 *  Genrates a checkbox.
 *      name  : checkbox's name.
 *      class : add class to styling checkbox.
 *      value : checkbox value. default is blank.
 *      required: checkbox is required.
 */

function swift_input_checkbox_shortcode($attsChbx) {

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => '',
            ), $atts);
    extract($a);

    if (in_array('required', $attsChbx)) {
        //$required = 'ss-required';
    }

    $chkBoxName = !empty($name) ? $name : "";
    $chkBoxClass = !empty($class) ? $class : "";
    $chkBoxValue = !empty($value) ? $value : "";

    $output = '<input type="checkbox" name="' . $chkBoxName . '" value="' . $chkBoxValue . '" class="swift_check ' . $required . ' ' . $chkBoxClass . '" id="' . $chkBoxName . '"/>';
    return $output;
}

add_shortcode('swift_checkbox', 'swift_input_checkbox_shortcode');


/*
 *  shortcode : [swift_radio name="radio button's name" class="class name"  value="radio button's value" required]
 *  Genrates a radio button button.
 *      name  : radio button's name.
 *      class : add class to styling radio button.
 *      value : radio button value. default is blank.
 *      required: radio button is required.
 */

function swift_input_radio_shortcode($attsRdbtn) {

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => ''
            ), $attsRdbtn);
    extract($a);

    if (in_array('required', $attsRdbtn)) {
        //$required = 'ss-required';
    }

    $radioBtnName = !empty($name) ? $name : "";
    $radioBtnClass = !empty($class) ? $class : "";
    $radioBtnValue = !empty($value) ? $value : "";

    $output .= '<input type="radio" name="' . $radioBtnName . '" value="' . $radioBtnValue . '" class="swift_radio ' . $radioBtnClass . ' ' . $required . '" id="' . $radioBtnName . '" />';
    return $output;
}

add_shortcode('swift_radio', 'swift_input_radio_shortcode');

/*
 *  shortcode : [swift_dropdown name="dropdown's name" class="class name" option_values="value1,value2,....,valueN" selected_option="value" required]
 *  Genrates a dropdown.
 *      name  : dropdown 's name.
 *      class : add class to styling dropdown.
 *      option_values : value to select; enter comma seprated values.
 *      selected_option : pass value which you pre selected.
 *      required: this field is required.
 */

function swift_dropdown_shortcode($attsDropDown) {
    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'option_values' => '',
        'selected_option' => ''
            ), $attsDropDown);
    extract($a);

    if (in_array('required', $attsDropDown)) {
        $required = 'ss-required';
    }

    $dropdownName = !empty($name) ? $name : "";
    $dropdownClass = !empty($class) ? $class : "";
    $dropdownValue = !empty($option_values) ? $option_values : "";
    $optionVal = explode(",", $dropdownValue);

    $output .= '<select name="' . $dropdownName . '" id="' . $dropdownName . '" class="' . $required . ' ' . $dropdownClass . '" >';
    if (!empty($dropdownValue)) {
        $output.= '<option value="">Select</option>';
        foreach ($optionVal as $val) {
            $selected = $selected_option == $val ? "selected" : "";
            $output.= '<option value="' . $val . '" ' . $selected . ' >' . $val . '</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

add_shortcode('swift_dropdown', 'swift_dropdown_shortcode');

/*
 *  shortcode : [swift_button name="button name" value="button value" class="button class"]
 *  Generates  a button.
 *      name : button's name.
 *      value : button's value.
 *      class : add class to styling button.
 */

function swift_button_shortcode($attsBtn) {
    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => ''
            ), $attsBtn);
    extract($a);
    $buttonName = !empty($name) ? $name : "";
    $buttonClass = !empty($class) ? $class : "";
    $buttonValue = !empty($value) ? $value : "";

    $output .= '<input type="submit" value="' . $buttonValue . '" name="' . $buttonName . '" id="' . $buttonName . '" class="checkValidation ' . $buttonClass . '"></button>';
    return $output;
}

add_shortcode('swift_button', 'swift_button_shortcode');

/*
 *  shortcode : [swift_date_today]
 *  Display current date in mm/dd/yyyy format.
 */

function swift_date_today_shortcode() {

    $output = "";
    $output .= '<input type="text" value="' . date('m/d/Y') . '" name="swift_date_today" id="swift_date_today" readonly />';
    return $output;
}

add_shortcode('swift_date_today', 'swift_date_today_shortcode');

/*
 *  shortcode : [swift_date name="field name" class="field class" required]
 *  Generates  a datepicker.
 *      name : field's name.
 *      class : add class to styling field.
 *      required: this field is required.
 */

function swift_date_shortcode($attsDate) {
    wp_enqueue_style('swift-jquery-ui-style', plugins_url('css/jquery-ui.css', __FILE__), '', '', '');
    wp_enqueue_script('jquery-ui-datepicker');

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
        'value' => ''
            ), $attsDate);
    extract($a);

    if (!empty($attsDate)) {
        if (in_array('required', $attsDate)) {
            $required = 'ss-required';
        }
    }

    $dateName = !empty($name) ? $name : "";
    $dateClass = !empty($class) ? $class : "";
    $dateValue = !empty($value) ? $value : "";

    $output.= '<input type="text" name="' . $dateName . '" id="' . $dateName . '" class="swift_datepicker ' . $required . ' ' . $dateClass . '" value="' . $dateValue . '">';
    $output.= '<script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery(".swift_datepicker").datepicker({
                            dateFormat: "mm-dd-yy"
                        });
                    });
               </script>';
    return $output;
}

add_shortcode('swift_date', 'swift_date_shortcode');

/*
 *  shortcode : [swift_circleword name="field's name" class="field's class" required]
 *  Generates  a circleword. Radio button with Yes or No
 *      name : field's name.
 *      class : add class to styling field.
 *      required: this field is required.
 */

function swift_circleword_shortcode($attscircles) {

    $output = "";
    $a = shortcode_atts(
            array(
        'name' => '',
        'class' => '',
            ), $attscircles);
    extract($a);

    if (in_array('required', $attscircles)) {
        $required = 'ss-required';
    }

    $cwName = !empty($name) ? $name : "";
    $cwClass = !empty($class) ? $class : "";
    $cwValue = !empty($value) ? $value : "";

    $output .= '<input type="radio" name="' . $cwName . '" value="Yes" class="swift_radio ' . $required . ' ' . $cwClass . '" id="' . $cwName . '" ' . $checked . ' />Yes';
    $output .= '&nbsp;&nbsp;<input type="radio" name="' . $cwName . '" value="No" class="swift_radio ' . $required . ' ' . $cwClass . '" id="' . $cwName . '" ' . $checked . ' />No';
    return $output;
}

add_shortcode('swift_circleword', 'swift_circleword_shortcode');

/*
 *      shortcode [swiftsign]
 */

function SwiftSignShortCode($atts, $content = null) {
    wp_enqueue_style('ss-admin-style', plugins_url('/css/signature-pad.css', __FILE__), '', '', '');

    wp_enqueue_script('ss-signature-pad', plugins_url('/js/signature_pad.js', __FILE__), '', '', true);
    wp_enqueue_script('ss-signature-pad-custom', plugins_url('/js/app.js', __FILE__), '', '', true);

    $output = "";
    $output = '<div id="signature-box"><div id="signature-pad" class="m-signature-pad">
                <div class="m-signature-pad--body">
                    <canvas height="150" width="250"></canvas>
                </div>
                <div class="m-signature-pad--footer">
                    <input type="button" class="button clear" name="ss_signClear" id="ss_signClear" data-action="clear" onclick="" value="Clear" />
                    <input type="hidden" name="ss_signDataURL" id="ss_signDataURL"/>
                </div>
            </div></div>';
    return $output;
}

add_shortcode('swiftsign', 'SwiftSignShortCode');