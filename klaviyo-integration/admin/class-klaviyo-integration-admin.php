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

use GuzzleHttp\Psr7\Response;

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
       // include 'partials/api_call.php';
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
        wp_enqueue_style( $this->plugin_name.'337', plugin_dir_url( __FILE__ ) . 'css/bootstrap_3_3_7.css', array(), $this->version, 'all' );

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
        

       // wp_enqueue_script( "jquery", plugin_dir_url( __FILE__ ) . 'js/jquery_3_6_4.js', array( '_jquery' ), $this->version, false );
        wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/klaviyo-integration-admin.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script($this->plugin_name.'337', plugin_dir_url( __FILE__ ) . 'js/bootstrap_min_3_3_7.js', array( 'jquery' ), $this->version, false );

    }


    // function c_aki_cf7() {
    //     do_action( 'wp_aki_cf7_db' );
    // }

    // public function aki_cf7_db(){
    //     require_once 'partials/aki_cf7_database.php';
    // }


    

    // public function addAdminMenuItems() {
    //  //add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
    //  add_menu_page(
    //    $this->plugin_name,
    //    'CF7 Klaviyo Integration',
    //    'administrator',
    //    $this->plugin_name,
    //    array(
    //      $this,
    //      'displayAdminDashboard',
    //    ),
    //    'dashicons-email',
    //    26
    //  );
    //  //add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )
    //  add_submenu_page(
    //      $this->plugin_name,
    //      'CF7 Klaviyo Integration Settings',
    //      'Settings',
    //      'administrator',
    //      $this->plugin_name.'-settings',
    //      array(
    //      $this,
    //      'displayAdminSettings',
    //      )
    //  );
        
    //   }

    //   public function displayAdminDashboard() {
    //  require_once 'partials/' . $this->plugin_name . '-admin-display.php';
    //   }

    //   public function displayAdminSettings() {
    //  require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
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
        $post_id = $post->ID();
        // $checked = get_option('akicf7_'.$post_id.'_enable_checkbox');

        $apiKey = get_option('akicf7_'.$post_id.'_apikey');
        ?>
        <div id="akicf7">
            <h2 class="_h2"><?php echo esc_html( __( 'Integration Status:', 'contact-form-7' ) ); ?><span>Disabled</span></h2>
            <fieldset>
                    <label for="akicf7_label">Enable Klaviyo Integration: </label>
                    <!-- <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" <?php // echo $checked == 'checked'?'checked':''; ?> value=""/> -->
                    <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" <?php echo $apiKey ?'checked':''; ?> value=""/>
                        <div class="akicf7_api_input inital <?php echo $apiKey  ? 'enable' : 'disable'; ?> ">
                            <div class="akicf7_api_box">
                                <label>Enter Your Api Key:</label>
                                <div>
                                    <input type="text" id="akicf7_apikey" name="akicf7_apikey" value="<?php echo $apiKey ? $apiKey : '' ;?>"> 
                                    <button class="akicf7_fetch_all_lists">Fetch Klaviyo Lists</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="test" name="form_name_action">
            </fieldset>
            <div class="aki7_loader"></div>
        </div>
        <?php
    }
        /*
        * Hooks into the save_post method and adds our new post meta to the contact form if the POST request contains the custom field we set up earlier
        * @param $post_id - post ID of the current post being saved
        */

        function save_awesome_cf7_klaviyo_custom_fields($post_id, $post, $update) {

            if($update){
                update_option('akicf7_'.$post_id.'_enable_checkbox', $_POST['akicf7_checkbox']);
                update_option('akicf7_'.$post_id.'_apikey', $_POST['akicf7_apikey']);
            }else{
                add_option('akicf7_'.$post_id.'_enable_checkbox', $_POST['akicf7_checkbox']);
                add_option('akicf7_'.$post_id.'_apikey', $_POST['akicf7_apikey']);
            }
         
        }



        public function my_ajax_handler() {
            $data = $_POST;
            // print_r($data);

            require_once(plugin_dir_path( dirname( __FILE__ ) ) .'vendor/autoload.php');

            $client = new \GuzzleHttp\Client();

            try {
                if(array_key_exists("listId",$data)){
                    $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/'.$data["listId"], [
                        'headers' => [
                            'Authorization' => 'Klaviyo-API-Key '.$data["api"],
                            'accept' => 'application/json',
                            'revision' => '2023-09-15',
                        ],
                        ]);

                     $res = json_decode($response->getBody());
                     wp_send_json_success($res);

                }else{
                    $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/', [
                        'headers' => [
                            'Authorization' => 'Klaviyo-API-Key '.$data["api"],
                            'accept' => 'application/json',
                            'revision' => '2023-09-15',
                        ],
                        ]);
                        $res = json_decode($response->getBody());
                        $newArray = (array)$res->data;

                        $lists = "";
                        $apiKey= $data["api"];
                        foreach($newArray as $list){
                            $lists .= "<option value=". $list->id .">". $list->attributes->name ."</option>";              
                        }
                        $a = ($apiKey ? "checked" : "");
                        $b = ($apiKey ? "enable" : "disable");
                        $c = ($apiKey ? $apiKey :"");
                        
                        $html = array(
                            'html' => '
                                    <div id="akicf7_app">
                                        <h2 class="akicf7_enabled">Integration Status:<span>Enabled</span></h2>
                                        <fieldset>
                                                <label for="akicf7_label">Enable Klaviyo Integration: </label>
                                                <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" '. $a .' value=""/>
                                                    <div class="akicf7_api_input '.$b .' ">
                                                        <div class="akicf7_api_box">
                                                           <div>
                                                                    <label>Enter Your Api Key:</label>
                                                                    <input type="text" id="akicf7_apikey" name="akicf7_apikey" value="'. $c .'" disabled="akicf7_apikey">
                                                           </div> 
                                                            <div class="akicf7_select_list">
                                                                <label>Select Klaviyo List</label>
                                                                <select class="form-control_ akicf7_lists" required="">
                                                                '. $lists .'
                                                                </select>
                                                            </div>   
                                                        </div>
                                                    </div>
                                        </fieldset>         
                                        
                                        <div id="akicf7_has_lists">
                                                <fieldset class="map-fields">
                                        
                                                <div class="row reverse">
                                                    <div class="col-md-9"> 
                                                    <h2>Map Fields:</h2>
                                                    <div class="form-group akicf7_map_block">
                                                        <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="col-md-4">
                                                                <label>Email<span> *</span></label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" required="" name="">
                                                                    <option value="0">Select</option>
                                                                    <option value="your-name">Your Name</option>
                                                                    <option value="your-email">Your Email</option>
                                                                    <option value="your-subject">Your Subject</option>
                                                                    <option value="your-message">Your Message</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group akicf7_map_block">
                                                        <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="col-md-4">
                                                                <label>First Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" required="" name="">
                                                                    <option value="0">Select</option>
                                                                    <option value="your-name">Your Name</option>
                                                                    <option value="your-email">Your Email</option>
                                                                    <option value="your-subject">Your Subject</option>
                                                                    <option value="your-message">Your Message</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/klaviyo-integration/admin/images/delete.svg"/>Remove</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group akicf7_map_block">
                                                        <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="col-md-4">
                                                                <label>Last Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" required="" name="">
                                                                    <option value="0">Select</option>
                                                                    <option value="your-name">Your Name</option>
                                                                    <option value="your-email">Your Email</option>
                                                                    <option value="your-subject">Your Subject</option>
                                                                    <option value="your-message">Your Message</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/klaviyo-integration/admin/images/delete.svg"/>Remove</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div id="add_on_fields">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="col-md-3 pull-right akicf7_add_block">
                                                            <a class=" btn_ btn-primary_ btn-full" ><img src="/wp-content/plugins/klaviyo-integration/admin/images/add.svg"/>Add Field</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                        
                                                    <div class="col-md-3"> 
                                                    <button id="cak">Change Api Key</button>
                                                </div>
                                                </div>
                                                </fieldset> 
                                        
                                    <div class="aki7_loader"></div>
                                    </div>

                            ',
                        );
                        //  print_r($html); exit;

                      wp_send_json_success(json_encode($html));
                      

                }
              } catch(Exception $e) {
                $errr = [];
                $errr['error'] = true;     
                wp_send_json_error($errr);               
              }

                // $res = json_decode($response->getBody());
                // wp_send_json_success($res);
        }




        public function KLCF_admin_after_additional_settings() {

            $post_id = sanitize_text_field($_GET['post']);
            $enable =   get_post_meta($post_id, "_KLCF_enable", true); 
            $f_data = get_post_meta($post_id, "_KLCF_data", true); 
            $enable_tag = get_post_meta($post_id, "_KLCF_enable_tag", true); 
            $custom_tag = get_post_meta($post_id, "_KLCF_custom_tag", true);

            $manager = WPCF7_FormTagsManager::get_instance();
    
            $form_tags = $manager->get_scanned_tags();
    
            $form_scan_tags = $this->tags_formate_array($form_tags);
            $auto_field_selected = $this->KLCF_searchField('email',$form_tags);
    
            $map_fields = array(
    
                    [
                        'name' => 'email',
                        'key' => '$email',
                        'required' => true
                    ]
                );

                var_dump($map_fields);
                exit;
    
            if(empty($f_data)){
            
                $map_fields[] =     
                    [
                        'name' => 'first name',
                        'key'  => '$first_name',
                        'required' => false
                    ];
                $map_fields[] =
                    [
                        'name' => 'last name',
                        'key'  => '$last_name',
                        'required' => false
                    ];          
            }else{
    
                $map_field[] =      
                    [
                        'name' => 'first name',
                        'key'  => '$first_name',
                        'required' => false
                    ];
                $map_field[] =
                    [
                        'name' => 'last name',
                        'key'  => '$last_name',
                        'required' => false
                    ];
    
                $keys = array_keys($f_data);                    
                foreach($map_field as $row){
                    if(in_array($row['key'],$keys)){
                        $map_fields[] = $row;
                    }
                }
            }
    
            // if()
    
            $map_extra_fields = array(
                [
                    'name' => 'First Name',
                    'key'  => '$first_name',
                    'required' => false
                ],
                [
                    'name' => 'Last Name',
                    'key'  => '$last_name',
                    'required' => false
                ],
                [
                    'name' => 'Phone',
                    'key'  => '$phone_number',
                    'required' => false
                ],
                [
                    'name' => 'City',
                    'key'  => '$city',
                    'required' => false
                ],
                [
                    'name' => 'Region',
                    'key'  => '$region',
                    'required' => false
                ],
                [
                    'name' => 'Country',
                    'key'  => '$country',
                    'required' => false
                ],
                [
                    'name' => 'Zip',
                    'key'  => '$zip',
                    'required' => false
                ],
    
            );
    
            // include('templates/intregation-form.php');
            return 0;
        }
    



   
        // $this->KLCF_admin_after_additional_settings();
    
}

// $z = new Klaviyo_Integration_Admin;
// $z->KLCF_admin_after_additional_settings();



// foreach($form as $objForm){
//  $manager = WPCF7_FormTagsManager::get_instance();
//  $tags  = $manager->scan( $objForm->form );
//  $filter_result = $manager->filter( $tags, $cond );
//   foreach ($filter_result as $key => $value) {
//       echo $value->type;
//       echo $value->name;
//   }
//   }

