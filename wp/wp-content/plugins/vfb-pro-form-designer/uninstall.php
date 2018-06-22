<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit();

	global $wpdb;

	$design_table = $wpdb->prefix . 'vfb_pro_form_design';

	$wpdb->query( "DROP TABLE IF EXISTS $design_table" );

	delete_option( 'vfb_form_design_db_version' );