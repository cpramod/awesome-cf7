<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Klaviyo_Integration
 * @subpackage Klaviyo_Integration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Klaviyo_Integration
 * @subpackage Klaviyo_Integration/public
 * @author     Your Name <email@example.com>
 */
class Klaviyo_Integration_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	// private $plugin_name =  "cf7-klaviyo-integration";

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

				
	    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/klaviyo-integration-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/klaviyo-integration-public.js', array( 'jquery' ), $this->version, false );

	}

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


}
