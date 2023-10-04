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
 * Plugin Name:  CF7 Klaviyo Integration
 * Plugin URI:   https://www.pcsoftnepal.com
 * Description:  CF7 Klaviyo Integration Plugin.
 * Version:      1.0
 * Author:       pcSoft
 * Author URI:   https://www.pcsoftnepal.com
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  klaviyo-integration
 * Domain Path:  /cf7-integration
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



