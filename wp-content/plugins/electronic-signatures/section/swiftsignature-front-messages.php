<?php
if (!function_exists('swiftsign_front_messages')) {

    function swiftsign_front_messages() {
        return array(
            'btn_sign_send_one' => __('Sign  &  Send', 'swiftsign'),
            'msg_by_clicking_sing' => __('By clicking Sign & Send below you agree to the terms contained herein, and that terms are binding in your jurisdiction as defined in our %s %s', 'swiftsign'),
        );
    }

}
?>