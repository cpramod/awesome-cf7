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
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:  Awesome CF7 Klaviyo Integration Plugin
 * Plugin URI:   https://www.pcsoftnepal.com
 * Description:  Awesome CF7 Klaviyo Integration Plugin.
 * Version:      1.0
 * Author:       pcsoft
 * Author URI:   https://www.pcsoftnepal.com
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  klaviyo-integration
 * Domain Path:  /awesom-cf7-plugin
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
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

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

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();

// ------------------------------
function wpb_follow_us($content) {
 
// Only do this when a single post is displayed
if ( is_single() ) { 
 
// Message you want to display after the post
// Add URLs to your own Twitter and Facebook profiles
 
$content .= '<p style="color:purple; font-size:22px;">If you liked this article, then please follow us on <a href="www.pcsoftnepal.com" title="WPBeginner on Twitter" target="_blank" rel="nofollow">Pcsoftnepal</a></p>';
 
}
// Return the content
return $content; 
 
}
// Hook our function to WordPress the_content filter
add_filter('the_content', 'wpb_follow_us'); 