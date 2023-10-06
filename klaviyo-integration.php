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
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if (!is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
    add_action( 'admin_notices', 'akicf7_please_activate_cf7' );
    return 0;
}


// // function get_plugins( $plugin_folder = '' ) {
//  $plugin_folder = '';
//     $cache_plugins = wp_cache_get( 'plugins', 'plugins' );
//     if ( ! $cache_plugins ) {
//         $cache_plugins = array();
//     }

//     if ( isset( $cache_plugins[ $plugin_folder ] ) ) {
//         return $cache_plugins[ $plugin_folder ];
//     }

//     $wp_plugins  = array();
//     $plugin_root = WP_PLUGIN_DIR;
//     if ( ! empty( $plugin_folder ) ) {
//         $plugin_root .= $plugin_folder;
//     }

//     // Files in wp-content/plugins directory.
//     $plugins_dir  = @opendir( $plugin_root );
//     $plugin_files = array();

//     if ( $plugins_dir ) {
//         while ( ( $file = readdir( $plugins_dir ) ) !== false ) {
//             if ( str_starts_with( $file, '.' ) ) {
//                 continue;
//             }

//             if ( is_dir( $plugin_root . '/' . $file ) ) {
//                 $plugins_subdir = @opendir( $plugin_root . '/' . $file );

//                 if ( $plugins_subdir ) {
//                     while ( ( $subfile = readdir( $plugins_subdir ) ) !== false ) {
//                         if ( str_starts_with( $subfile, '.' ) ) {
//                             continue;
//                         }

//                         if ( str_ends_with( $subfile, '.php' ) ) {
//                             $plugin_files[] = "$file/$subfile";
//                         }
//                     }

//                     closedir( $plugins_subdir );
//                 }
//             } else {
//                 if ( str_ends_with( $file, '.php' ) ) {
//                     $plugin_files[] = $file;
//                 }
//             }
//         }

//         closedir( $plugins_dir );
//     }

//     if ( empty( $plugin_files ) ) {
//         return $wp_plugins;
//     }

//     foreach ( $plugin_files as $plugin_file ) {
//         if ( ! is_readable( "$plugin_root/$plugin_file" ) ) {
//             continue;
//         }

//         // Do not apply markup/translate as it will be cached.
//         $plugin_data = get_plugin_data( "$plugin_root/$plugin_file", false, false );

//         if ( empty( $plugin_data['Name'] ) ) {
//             continue;
//         }

//         $wp_plugins[ plugin_basename( $plugin_file ) ] = $plugin_data;
//     }

//     uasort( $wp_plugins, '_sort_uname_callback' );

//     $cache_plugins[ $plugin_folder ] = $wp_plugins;
//     wp_cache_set( 'plugins', $cache_plugins, 'plugins' );

//  echo "<pre>";
//     print_r($wp_plugins); exit;

// //     return $wp_plugins;
// // }
function akicf7_please_activate_cf7(){
    global $pagenow;
    if ( $pagenow == 'plugins.php' || $pagenow == 'index.php'  ) {
         echo '<div class="notice notice-warning is-dismissible">
             <p>Please install <b><a href="https://contactform7.com/download/">Contact Form 7</a></b> before installing the <b><a href="https://pcsoftnepal.com/support/">CF7 Klaviyo Integration</a></b>.</p>
         </div>';
    }
    return 0;
}

if ( ! defined( 'ABSPATH' ) ) {   // WPCF7 ABSPATH WPINC
    die;
}
// $option = get_option( 'wpcf7' );
// echo "<pre>";
// print_r($option);exit;

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

