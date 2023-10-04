<?php

// function aki_cf7_db() {
    global $wpdb;
    // echo "<pre>";
    // print_r($wpdb);
    // echo "</pre>";
    // exit;

    $charset_collate = $wpdb->get_charset_collate();
	
    $table_name = $wpdb->prefix . 'aki_cf7';

    $sql = "CREATE TABLE " . $table_name . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	site_name VARCHAR(100) NOT NULL,
	api_key VARCHAR(100) NOT NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";
 
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
// }

// register_activation_hook(__FILE__, 'aki_cf7_db');

// $sql = "CREATE TABLE " . $table_name . " (
// 	id int(11) NOT NULL AUTO_INCREMENT,
// 	name tinytext NOT NULL,
// 	email VARCHAR(100) NOT NULL,
// 	ip_address varchar(15),
// 	PRIMARY KEY  (id),
// 	KEY ip_address (ip_address)
//     ) $charset_collate;";