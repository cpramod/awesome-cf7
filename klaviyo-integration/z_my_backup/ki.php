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


    /**
	 * Add menus to the WordPress Sidebar Setting.
	 */
	// function cf7_integration_register_settings() { 
	// 	register_setting('cf7_integration_options_group', 'first_field_name');		 
	// 	register_setting('cf7_integration_options_group', 'second_field_name');	 
	// 	register_setting('cf7_integration_options_group', 'third_field_name');	 
	// 	}
	// add_action('admin_init', 'cf7_integration_register_settings');

	function cf7_integration_setting_page() {
 
		// add_options_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' ) 

		add_options_page('CF7 Klaviyo Integration', 'CF7 Klaviyo Integration', 'manage_options', 'cf7-integration-setting-url', 'cf7_integration_html_form'); 

		// custom_page_html_form is the function in which I have written the HTML for my cf7 integration form.
		}
	add_action('admin_menu', 'cf7_integration_setting_page');

	function cf7_integration_html_form(){
		require_once 'public/partials/cf7-klaviyo-integration-public-display.php';
	}


	// -----------------------------------------------

	/*
	* Adds an additional panel to the Contact Form 7 contact form edit screen with an input that will save to the post meta of the contact form.
	*
	*/

	/*
	* Adds our new CF7 Klaviyo Integration panel to the Contact Form 7 edit screen
	*
	* @param array $panels - an array of all the panels currently displayed on the Contact Form 7 edit screen
	*/

	function add_cf7_panel ($panels) {
		$panels['custom-fields'] = array(
			'title' => 'CF7 Klaviyo Integration',
			'callback' => 'wpcf7_custom_fields',
		);

		return $panels;
	}

	add_filter('wpcf7_editor_panels', 'add_cf7_panel');

	/*
	* Sets up the fields inside our new custom panel
	* @param WPCF7_ContactForm $post - modified post type object from Contact Form 7 containing information about the current contact form
	*/
	function wpcf7_custom_fields ($post) {
		?>
		<h2><?php echo esc_html( __( 'Settings', 'contact-form-7' ) ); ?></h2>
		<fieldset>
			<!-- <legend></legend> -->
			<input type="checkbox" id="a-cf7-custom-field" name="a-cf7-custom-field" value="<?php
			//$post here is not a traditional WP Post object, but a WPCF7_ContactForm object, $post->id is private, so we need to use the id() function to get the post ID

			echo get_post_meta($post->id(), 'custom_field', true) ?>"
			/>
			<label for="a-cf7-custom-field">Enable Integration</label>
		</fieldset>
		<?php
	}


	/*
	* Hooks into the save_post method and adds our new post meta to the contact form if the POST request contains the custom field we set up earlier
	* @param $post_id - post ID of the current post being saved
	*/

	function save_a_cf7_custom_fields($post_id) {
		if (array_key_exists('a-cf7-custom-field', $_POST)) {
			update_post_meta(
				$post_id,
				'custom_field',
				$_POST['a-cf7-custom-field']
			);
		}
	}

	add_action('save_post', 'save_a_cf7_custom_fields');