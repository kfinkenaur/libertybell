<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit();

	global $wpdb;

	$payments_table = $wpdb->prefix . 'vfb_pro_payments';

	$wpdb->query( "DROP TABLE IF EXISTS $payments_table" );

	delete_option( 'vfb_payments_db_version' );