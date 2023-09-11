<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Klaviyo_Integration
 *
 * @wordpress-plugin
 * Plugin Name:  Awesome CF7 Klaviyo Integration
 * Plugin URI:   https://www.pcsoftnepal.com
 * Description:  Awesome CF7 Klaviyo Integration Plugin.
 * Version:      1.0
 * Author:       pcsoft
 * Author URI:   https://www.pcsoftnepal.com
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  klaviyo-integration
 * Domain Path:  /awesome-cf7-plugin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-klaviyo-integration-activator.php
 */
function activate_klaviyo_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-klaviyo-integration-activator.php';
	Klaviyo_Integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-klaviyo-integration-deactivator.php
 */
function deactivate_klaviyo_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-klaviyo-integration-deactivator.php';
	Klaviyo_Integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_klaviyo_integration' );
register_deactivation_hook( __FILE__, 'deactivate_klaviyo_integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-klaviyo-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Klaviyo_Integration();
	$plugin->run();

}
run_plugin_name();

// ------------------------------
function wpb_follow_us($content) {
 
	// Only do this when a single post is displayed
	if ( is_single() ) { 
	 
	// Message you want to display after the post
	// Add URLs to your own Twitter and Facebook profiles
	 
	$content .= '<p style="color:purple; font-size:22px;">If you liked this article, then please follow us on <a href="www.pcsoftnepal.com" title="WPBeginner on pcsoft" target="_blank" rel="nofollow">Pcsoftnepal</a>.</p>';
	 
	}
	// Return the content
	return $content; 
	 
	}
	// Hook our function to WordPress the_content filter
	add_filter('the_content', 'wpb_follow_us'); 
	

	/**
	 * Add menus to the WordPress admin.
	 */

	function my_prefix_add_admin_menus() {
		// Register admin code here.
	}
	add_action( 'admin_menu', 'my_prefix_add_admin_menus' );