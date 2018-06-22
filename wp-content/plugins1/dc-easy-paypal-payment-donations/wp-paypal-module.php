<?php
/*
Plugin Name: DC - Easy Wordpress Paypal Payment / Donation Plugin
Plugin URI:
Description: WP - Paypal Module
Version: 1.0
Author: DART Creations
Author URI: http://www.dart-creations.com
*/
if(!defined('WP_PAYPAL_MODULE_URL'))
	define('WP_PAYPAL_MODULE_URL',WP_PLUGIN_URL.'/wp-paypal-module');

/* Begin MCE Button */
add_action('admin_enqueue_scripts', 'wp_paypal_module_admin_enqueue_scripts');
function wp_paypal_module_admin_enqueue_scripts() {
	wp_enqueue_style('wp_paypal_module', WP_PAYPAL_MODULE_URL.'/css/style.css');
}

add_action('admin_head', 'wp_paypal_module_admin_head');
function wp_paypal_module_admin_head() {
	if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	if('true' == get_user_option('rich_editing')) {
		add_filter('mce_external_plugins', 'wp_paypal_module_mce_external_plugins');
		add_filter('mce_buttons', 'wp_paypal_module_mce_buttons');
	}
}

function wp_paypal_module_mce_external_plugins($plugin_array) {
	$plugin_array['wp_paypal_module'] = WP_PAYPAL_MODULE_URL.'/js/mce.js';
	return $plugin_array;	 
}

function wp_paypal_module_mce_buttons($buttons) {
	array_push($buttons, 'wp_paypal_module');
	return $buttons;
}
/* End MCE Button */
/* Begin Shortcode */
add_action('init', 'paypal_module_init');
function paypal_module_init() {
	if(isset($_POST['paypal_module_paypalemail'])) {
		$duration = isset($_POST['paypal_module_duration'])?(int)$_POST['paypal_module_duration']:'';
		$amount = isset($_POST['paypal_module_paypalamount'])?trim($_POST['paypal_module_paypalamount']):'';
		$amount = str_replace(',', '.', $amount);
		if(($_POST['paypal_module_type'] == '4') && (1 <= $duration && $duration <= 3)) {
			$amount = (int)round($amount, 0);
		}
		if(isset($_POST['paypal_module_smallestpaypalamount']) && ($_POST['paypal_module_smallestpaypalamount'] != '') && ($amount < (int)$_POST['paypal_module_smallestpaypalamount'])) {
			$amount = (int)$_POST['paypal_module_smallestpaypalamount'];
		}
		$currency_code = isset($_POST['paypal_module_currency_code'])?trim($_POST['paypal_module_currency_code']):0;

		if ($duration >= 1 && $duration <= 4) {
			if ($_POST['paypal_module_type'] == 'donate') {
				$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&amount='.$amount.'&no_shipping=0&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dDonationsBF&charset=UTF%2d8&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
			} else if ($_POST['paypal_module_type'] == 'buynow') {
				$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&amount='.$amount.'&no_shipping=0&no_note=1&tax=0&amp;currency_code='.$currency_code.'&bn=PP%2dBuyNowBF&charset=UTF%2d8&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
			} else if ($_POST['paypal_module_type'] == 'cart') {
				$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_cart&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&amount='.$amount.'&add=1&no_shipping=1&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dShopCartBF&charset=UTF%2d8&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
			} else if ($_POST['paypal_module_type'] == 'subscribe') {
				if ($duration == 1) {
					$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&no_shipping=1&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dSubscriptionsBF&charset=UTF%2d8&a3='.$amount.'%2e00&p3=1&t3=D&src=1&sra=1&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
				} else if ($duration == 2) {
					$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&no_shipping=1&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dSubscriptionsBF&charset=UTF%2d8&a3='.$amount.'%2e00&p3=1&t3=W&src=1&sra=1&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
				} else if ($duration == 3) {
					$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&no_shipping=1&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dSubscriptionsBF&charset=UTF%2d8&a3='.$amount.'%2e00&p3=1&t3=M&src=1&sra=1&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
				} else if ($duration == 4) {
					$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business='.urlencode($_POST['paypal_module_paypalemail']).'&item_name='.$_POST['paypal_module_paypalorg'].'&no_shipping=1&no_note=1&amp;currency_code='.$currency_code.'&bn=PP%2dSubscriptionsBF&charset=UTF%2d8&a3='.$amount.'%2e00&p3=1&t3=Y&src=1&sra=1&return='.$_POST['paypal_module_return'].'&cancel='.$_POST['paypal_module_cancel'];
				}
			}
			if ($_POST['paypal_module_locale'] != '') {
				$url .= '&lc='.$_POST['paypal_module_locale'];
			}
			wp_redirect($url);
			die();
		}
	}
}

add_shortcode('paypalbutton', 'paypal_module_shortcode');
function paypal_module_shortcode($atts) {
	$atts = shortcode_atts(
		array(
			'type' => 'buynow',
			'logoortextchoice' => '',
			'logoortext' => 'buynow',
			'paypalemail' => '',
			'paypalorg' => 'false',
			'editablecurrency' => 'false',
			'editableamount' => 'false',
			'defaultcurrency' => 'USD',
			'buttontext' => 'false',
			'enteramount' => 'Enter Amount',
			'paypalamount' => '',
			'smallestpaypalamount' => '',	
			'return' => '',
			'cancel' => '',
			'locale' => 'US'
		),
		$atts
	);
	$currencies = array(
		'CAD' => '$',
		'USD' => '$',
		'GBP' => '£',
		'AUD' => '$',
		'JPY' => '&yen;',
		'EUR' => '&euro;',
		'CHF' => 'CHF',
		'CZK' => 'CZK',
		'DKK' => 'DKK',
		'HKD' => '$',
		'HUF' => 'HUF',
		'NOK' => 'NOK',
		'NZD' => '$',
		'PLN' => 'PLN',
		'SEK' => 'SEK',
		'SGD' => '$'
	);
	$output = '<div id="paypal_logo">';
	if($atts['logoortextchoice'] == 'logo') {
		$output .= '<img src="'.$atts['logoortext'].'" alt="PayPal" />';
	} elseif($atts['logoortextchoice'] == 'text') {
		$output .= $atts['logoortext'];
	}
	$output .= '</div>';

	$output .= '<form method="post">';
		if($atts['editableamount'] == 'true' || $atts['editablecurrency'] == 'true' || $atts['type'] == 'subscribe') {
			$output .= '<p>';
		}
		if($atts['editableamount'] == 'true') {
			$output .= '<script type="text/javascript">';
			$output .= 'function paypal_module_donate_change_currency() {';
				$output .= 'var selectionObj = document.getElementById("paypal_module_currency_code");';
				$output .= 'var selection = selectionObj.value;';
				$output .= 'var currencyObj = document.getElementById("paypal_module_symbol_currency");';
				$output .= 'if(currencyObj) {';
					$output .= 'var currencySymbols = { "CAD": "$", "USD": "$", "GBP": "&pound;", "AUD": "$", "JPY": "&yen;", "EUR": "&euro;", "CHF": "CHF", "CZK" : "CZK", "DKK" : "DKK", "HKD" : "$", "HUF" : "HUF", "NOK" : "NOK", "NZD" : "$", "PLN" : "PLN", "SEK" : "SEK", "SGD" : "$" };';
					$output .= 'var currencySymbol = currencySymbols[selection];';
					$output .= 'currencyObj.innerHTML = currencySymbol;';
				$output .= '}';
			$output .= '}';
			$output .= '</script>';
			$output .= $atts['enteramount'].'<br />';
			$output .= '<span id="paypal_module_symbol_currency">'.$currencies[$atts['defaultcurrency']].'</span> <input type="number" '.(($atts['smallestpaypalamount'] != '')?'min="'.$atts['smallestpaypalamount'].'"':'').' required name="paypal_module_paypalamount" size="5" class="inputbox" value="'.$atts['paypalamount'].'" /> ';
		} elseif($atts['editableamount'] == 'false') {
			$output .= '<input type="hidden" value="'.$atts['paypalamount'].'" name="paypal_module_paypalamount">';
		}
		if($atts['editablecurrency'] == 'true') {
			$output .= '<select name="paypal_module_currency_code" id="paypal_module_currency_code" class="inputbox" onchange="paypal_module_donate_change_currency();">';
			foreach($currencies as $currency => $dummy) {
				$output .= '<option value="'.$currency.'" '.(($currency == $atts['defaultcurrency'])?' selected="selected"':'').'>'.$currency.'</option>';
			}
			$output .= '</select> ';
		} elseif($atts['editablecurrency'] == 'false') {
			$output .= '<input type="hidden" name="paypal_module_currency_code" value="'.$atts['defaultcurrency'].'">';
		}
		if($atts['type'] == 'subscribe') {
			$output .= '<select name="paypal_module_duration" class="inputbox">';
				$output .= '<option value="1">Daily</option>';
				$output .= '<option value="2">Weekly</option>';
				$output .= '<option value="3">Monthly</option>';
				$output .= '<option value="4">Annual</option>';
			$output .= '</select>';
		} else {
			$output .= '<input type="hidden" name="paypal_module_duration" value="1" />';
		}
		if($atts['editableamount'] == 'true' || $atts['editablecurrency'] == 'true' || $atts['type'] == 'subscribe') {
			$output .= '</p>';
		}
		$output .= '<p>';
			$output .= '<input type="hidden" name="paypal_module_type" value="'.$atts['type'].'" />';
			$output .= '<input type="hidden" name="paypal_module_paypalemail" value="'.$atts['paypalemail'].'" />';
			$output .= '<input type="hidden" name="paypal_module_paypalorg" value="'.$atts['paypalorg'].'" />';
			$output .= '<input type="hidden" name="paypal_module_smallestpaypalamount" value="'.$atts['smallestpaypalamount'].'" />';
			$output .= '<input type="hidden" name="paypal_module_return" value="'.$atts['return'].'" />';
			$output .= '<input type="hidden" name="paypal_module_cancel" value="'.$atts['cancel'].'" />';
			$output .= '<input type="hidden" name="paypal_module_locale" value="'.$atts['locale'].'" />';
			$output .= '<input type="submit" class="button" name="paypalsubmit" alt="Make payments with PayPal - its fast, free and secure!" value="'.$atts['buttontext'].'" />';
		$output .= '</p>';
	$output .= '</form>';
	return $output;			
}
/* End Shortcode */
?>