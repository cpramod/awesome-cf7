<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Klaviyo_Integration
 * @subpackage Klaviyo_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Klaviyo_Integration
 * @subpackage Klaviyo_Integration/admin
 * @author     Your Name <email@example.com>
 */
class Klaviyo_Integration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// add_action('admin_menu', array($this, 'addAdminMenuItems'), 9);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/klaviyo-integration-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	   // wp_enqueue_script( "jquery", plugin_dir_url( __FILE__ ) . 'js/jquery_3.6.4_.js', array( '_jquery' ), $this->version, false );
		wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/klaviyo-integration-admin.js', array( 'jquery' ), $this->version, false );

	}

	// public function addAdminMenuItems() {
	// 	//add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
	// 	add_menu_page(
	// 	  $this->plugin_name,
	// 	  'CF7 Klaviyo Integration',
	// 	  'administrator',
	// 	  $this->plugin_name,
	// 	  array(
	// 		$this,
	// 		'displayAdminDashboard',
	// 	  ),
	// 	  'dashicons-email',
	// 	  26
	// 	);
	// 	//add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )
	// 	add_submenu_page(
	// 		$this->plugin_name,
	// 		'CF7 Klaviyo Integration Settings',
	// 		'Settings',
	// 		'administrator',
	// 		$this->plugin_name.'-settings',
	// 		array(
	// 		$this,
	// 		'displayAdminSettings',
	// 		)
	// 	);
		
	//   }

	//   public function displayAdminDashboard() {
	// 	require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	//   }

	//   public function displayAdminSettings() {
	// 	require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	//    }

	public function settings_menu() {
 
		// add_options_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' ) 
		add_options_page('CF7 Klaviyo Integration', 'CF7 Klaviyo Integration', 'manage_options', 'cf7-integration-setting-url', array($this,'settings_menu_dashboard'));	
		// custom_page_html_form is the function in which I have written the HTML for my cf7 integration form.
	}
	public function settings_menu_dashboard(){
		 //require_once 'admin/partials/klaviyo-integration-admin-display.php';
		require_once 'partials/klaviyo-integration-admin-dashboard.php';

	}


	/*
	* Adds an additional panel to the Contact Form 7 contact form edit screen with an input that will save to the post meta of the contact form.
	*
	*/

	/*
	* Adds our new CF7 Klaviyo Integration panel to the Contact Form 7 edit screen
	*
	* @param array $panels - an array of all the panels currently displayed on the Contact Form 7 edit screen
	*/

	public function add_cf7_panel ($panels) {
		$panels['custom-fields'] = array(
			'title' => 'CF7 Klaviyo Integration',
			// 'callback' => 'wpcf7_custom_fields',
			'callback' => array($this,'wpcf7_custom_fields')
		);

		return $panels;
	}

	/*
	* Sets up the fields inside our new custom panel
	* @param WPCF7_ContactForm $post - modified post type object from Contact Form 7 containing information about the current contact form
	*/
	function wpcf7_custom_fields ($post) {
		?>
		<div class="a_cf7_ki">
			<h2 class="_h2"><?php echo esc_html( __( 'Integration Status:', 'contact-form-7' ) ); ?><span>Disabled</span></h2>
			<fieldset>
				<!-- <legend></legend> -->
				<label for="a-cf7-custom-field">Enable Klaviyo Integration: </label>
				<input type="checkbox" id="a-cf7-custom-field" name="a-cf7-custom-field" value=""/>
			</fieldset>
		</div>
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
			// var_dump($post_id);
			// exit;
		}

	
}
