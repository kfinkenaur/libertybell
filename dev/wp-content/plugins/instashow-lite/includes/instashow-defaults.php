<?php

if (!defined('ABSPATH')) exit;


$instashow_lite_defaults = array(
	'client_id' => null,
	'access_token' => null, 

	// Source
	'source' => '',
	'cache_media_time' => 0,

	// Sizes
	'columns' => 4,

	// UI
	'arrows_control' => true,
	'drag_control' => true,
	'effect' => 'slide',
	'speed' => 600,
	'easing' => 'ease',
	'auto' => 0,
	'auto_hover_pause' => true,
	'popup_speed' => 400,
	'popup_easing' => 'ease'
);

?>