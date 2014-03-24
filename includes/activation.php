<?php

function nf_activation() {
	global $wpdb;

	wp_schedule_event( time(), 'daily', 'ninja_forms_daily_action' );

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$sql = "CREATE TABLE IF NOT EXISTS " . NF_OBJECTS_TABLE_NAME . " (
	  `id` bigint(20) NOT NULL AUTO_INCREMENT,
	  `type` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;";	
	
	dbDelta($sql);
	
	$sql = "CREATE TABLE " . NF_META_TABLE_NAME . " (
	  `id` bigint(20) NOT NULL AUTO_INCREMENT,
	  `object_id` bigint(20) NOT NULL,
	  `meta_key` varchar(255) NOT NULL,
	  `meta_value` longtext NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;";

	dbDelta($sql);	

	$sql = "CREATE TABLE " . NF_RELATIONSHIPS_TABLE_NAME . " (
	  `id` bigint(20) NOT NULL AUTO_INCREMENT,
	  `child_id` bigint(20) NOT NULL,
	  `parent_id` bigint(20) NOT NULL,
	  `child_type` varchar(255) NOT NULL,
	  `parent_type` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;";

	dbDelta($sql);
}