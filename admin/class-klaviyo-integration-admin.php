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
class Klaviyo_Integration_Admin
{

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

    public $api_key;

    public $post_id;

    // private $fields_name;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // include 'partials/api_call.php';
    }

    public function setApikey($apiKey) { 
        $this->api_key = $apiKey; 
    }

    public function setPostId($postId) { 
        $this->post_id = $postId; 
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/klaviyo-integration-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '337', plugin_dir_url(__FILE__) . 'css/bootstrap_3_3_7.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/klaviyo-integration-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '337', plugin_dir_url(__FILE__) . 'js/bootstrap_min_3_3_7.js', array('jquery'), $this->version, false);
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

    public function settings_menu()
    {

        // add_options_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' ) 
        add_options_page('CF7 Klaviyo Integration', 'CF7 Klaviyo Integration', 'manage_options', 'cf7-integration-setting-url', array($this, 'settings_menu_dashboard'));
        // custom_page_html_form is the function in which I have written the HTML for my cf7 integration form.
    }
    public function settings_menu_dashboard()
    {
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

    public function add_cf7_panel($panels)
    {
        $panels['custom-fields'] = array(
            'title' => 'CF7 Klaviyo Integration',
            // 'callback' => 'wpcf7_custom_fields',
            'callback' => array($this, 'wpcf7_custom_fields')
        );

        return $panels;
    }

    function fetch_lists_fields_from_klaviyo(){
        $dummy_user_id = get_option('akicf7_' . $this->post_id . '_dummy_user_id'); 

        if(!$dummy_user_id){
            $json_data_obj = "create_dummy_user";
            $dummy_user_id = $this->create_profile($this->api_key, $json_data_obj);

           add_option('akicf7_' . $this->post_id . '_dummy_user_id', $dummy_user_id);
        }  
        
        require_once(plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php');
        $client = new \GuzzleHttp\Client();

        $klv_response = $client->request('GET', 'https://a.klaviyo.com/api/profiles/'.$dummy_user_id.'/', [   
        //$klv_response = $client->request('GET', 'https://a.klaviyo.com/api/profiles/01HAP7ZK9DXYX9FVNV1RGTFM09/', [   // pk_3979bc797b39b9c4b7641ec070c9c5018a
            'headers' => [
              'Authorization' => 'Klaviyo-API-Key ' . $this->api_key,
              'accept' => 'application/json',
              'revision' => '2023-09-15',
            ],
          ]);
          $klv_res = json_decode($klv_response->getBody());
          $klaviyo_fields = (array)$klv_res->data;
          $klaviyo_fields = array_keys((array)$klaviyo_fields['attributes']);
          $klaviyo_fields = array_combine($klaviyo_fields,$klaviyo_fields);

        return $klaviyo_fields;
    }
    
    /*
    * Sets up the fields inside our new custom panel
    * @param WPCF7_ContactForm $post - modified post type object from Contact Form 7 containing information about the current contact form
    */
    function wpcf7_custom_fields($post)
    {
        $post_id = $post->ID();
        // $checked = get_option('akicf7_'.$post_id.'_enable_checkbox');

        $apiKey = get_option('akicf7_' . $post_id . '_apikey');
        $mapped_fields = get_option('akicf7_' . $post_id . '_mapped_fields');
        $mapped_fields = unserialize($mapped_fields);

                // echo "<pre>";
                // print_r($mapped_fields);
                // exit;

        require_once(plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php');
        $client = new \GuzzleHttp\Client();

        if ($mapped_fields != "" && $apiKey != "") { 

            // this is for fetching data from database 
            require_once 'partials/mapped_present.php';

        } else { ?>

            <div id="akicf7">
                <h2 class="_h2"><?php echo esc_html(__('Integration Status:', 'contact-form-7')); ?><span>Disabled</span></h2>
                <fieldset>
                    <label for="akicf7_label">Enable Klaviyo Integration: </label>
                    <!-- <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" <?php // echo $checked == 'checked'?'checked':'';  ?> value=""/> -->
                    <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" <?php echo $apiKey ? 'checked' : ''; ?> value="" />
                    <div class="akicf7_api_input inital <?php echo $apiKey  ? 'enable' : 'disable'; ?> ">
                        <div class="akicf7_api_box">
                            <label>Enter Your Api Key:</label>
                            <div>
                                <input type="text" id="akicf7_apikey" name="akicf7_apikey" value="<?php echo $apiKey ? $apiKey : ''; ?>">
                                <button class="akicf7_fetch_all_lists">Fetch Klaviyo Lists</button>
                            </div>
                        </div>
                    </div>
                    <input id="post_id" type="hidden" value="<?php echo $post_id ?>" name="post_id">
                    <input type="hidden" name="akicf7_apikey" value="<?php echo $apiKey ? $apiKey : ''; ?>">
                </fieldset>
                <div class="aki7_loader"></div>
            </div>

        <?php } ?>
        <?php
    }
       /*
        * Hooks into the save_post method and adds our new post meta to the contact form if the POST request contains the custom field we set up earlier
        * @param $post_id - post ID of the current post being saved
        */
 
    function save_to_akicf7_fields_to_database($post_id, $post, $update) // save_awesome_cf7_klaviyo_custom_fields
    {
        //     echo "<pre>";
        //    //print_r($_POST['akicf7']);
        //     print_r($_POST);
        //     echo "</pre>";
        //     //echo serialize($_POST['akicf7']);
        //     exit;

        if ($update) {
           // update_option('akicf7_' . $post_id . '_enable_checkbox', $_POST['akicf7_checkbox']);
            update_option('akicf7_' . $post_id . '_apikey', $_POST['akicf7_apikey']);

            update_option('akicf7_' . $post_id . '_mapped_fields', serialize($_POST['akicf7']));
        } else {
           // add_option('akicf7_' . $post_id . '_enable_checkbox', $_POST['akicf7_checkbox']);
            add_option('akicf7_' . $post_id . '_apikey', $_POST['akicf7_apikey']);

            add_option('akicf7_' . $post_id . '_mapped_fields', serialize($_POST['akicf7']));
        }
    }



    public function my_ajax_handler()  {
        $data = $_POST;
        $apiKey = $data["api"];
        $postId = $data["post_id"];
        $this->setApikey($apiKey);
        $this->setPostId($postId);
       
        require_once(plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php');
        $client = new \GuzzleHttp\Client();

        try {
            if (array_key_exists("listId", $data)) {
                $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/' . $data["listId"], [
                    'headers' => [
                        'Authorization' => 'Klaviyo-API-Key ' . $apiKey,
                        'accept' => 'application/json',
                        'revision' => '2023-09-15',
                    ],
                ]);

                $res = json_decode($response->getBody());
                wp_send_json_success($res);
            } else {
                $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/', [
                    'headers' => [
                        'Authorization' => 'Klaviyo-API-Key ' . $apiKey,
                        'accept' => 'application/json',
                        'revision' => '2023-09-15',
                    ],
                ]);
                $res = json_decode($response->getBody());
                $newArray = (array)$res->data;


                // klaviyo all lists start ****
                $klaviyo_fields = $this->fetch_lists_fields_from_klaviyo();

                // $personid = "01HAV3SW2RDTJ0T9ZE0V298ZQH";
                // $profile_response = $client->request('GET', 'https://a.klaviyo.com/api/v1/person/'.$personid.'?api_key='.$data["api"], [
                //     'headers' => [
                //       'accept' => 'application/json',
                //     ],
                //   ]);

                // remove this  $klaviyo_fields
                //$klaviyo_fields = ['Select'=>'Select','Name'=>'Name', 'Email'=>'Email', 'Phone'=>'Phone', 'Message'=>'Message'];  // remove this array

                $lists = "";
                foreach ($newArray as $list) {
                    $lists .= "<option value=" . $list->id . ">" . $list->attributes->name . "</option>";
                }
                $checked_unchecked = ($apiKey ? "checked" : "");
                $enable_disable = ($apiKey ? "enable" : "disable");
                $key = ($apiKey ? $apiKey : "");

                // contact-form-7 start ****
                $ContactForm = WPCF7_ContactForm::get_instance($postId);
                $form_fields = $ContactForm->scan_form_tags();
                $cf7_fields = "<option value='Select'>Select</option>";

                $cf7_fields_name = [];

                foreach ($klaviyo_fields as $key => $field) {
                    $cf7_fields .= "<option value='" . $field . "'>" .  ucwords(str_replace("_"," ",$field )) . "</option>";
                }
                // foreach($form_fields as $field){      
                //      $trimmed = ucwords(trim($field->raw_name, "your-")); 
                //      if($trimmed != ""){
                //         array_push($cf7_fields_name, $trimmed);
                //         $cf7_fields .= "<option value=". $field->basetype .">". $trimmed  ."</option>";  
                //      }                                                    
                // }    

                $blocks = "";
                foreach ($form_fields as $field) {

                    // $trimmed = ucwords(trim($field->raw_name, "your-"));
                    $trimmed = trim($field->raw_name, "your-");
                    $trimmed = str_replace("-","_",$trimmed);

                    if ($trimmed != "") {
                        array_push($cf7_fields_name, $trimmed);
                    }
                    $check_asterik = $field->type;
                    if (strpos($check_asterik, "*")) {
                        $astrik = "*";
                        $remove_btn = '';
                    } else {
                        $astrik = "";
                        $remove_btn = '<div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/awesome-cf7/admin/images/delete.svg"/>Remove</a></div>';
                    }
                    if ($trimmed != "") {
                        $blocks .= '                          
                                            <div class="form-group akicf7_block">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="col-md-4">
                                                        <label>' . ucwords(str_replace("_"," ",$trimmed)) . '<span> ' . $astrik . '</span></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control" required="" name="akicf7['. $trimmed .']">
                                                            ' . $cf7_fields . '
                                                        </select>
                                                    </div>
                                                </div>
                                                ' . $remove_btn . '
                                            </div>
                                        </div>                                   
                                ';
                               // <select class="form-control" required="" name="akicf7[option_' . $trimmed . ']">
                    }
                }
                //  array_pop($cf7_fields_name);
                //  --------------------------

                $cf7_extra_fields = array("Phone", "City", "zip", "Go Pro ..");
                $merged_cf7_fields = array_merge($cf7_fields_name, $cf7_extra_fields);

                $html = array(
                    'html' => '
                                    <div id="akicf7_app">
                                        <h2 class="akicf7_enabled">Integration Status:<span>Enabled</span></h2>
                                        <fieldset>
                                                <label for="akicf7_label">Enable Klaviyo Integration: </label>
                                                <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" ' . $checked_unchecked . ' value=""/>
                                                    <div class="akicf7_api_input ' . $enable_disable . ' ">
                                                        <div class="akicf7_api_box">
                                                           <div>
                                                                    <label>Enter Your Api Key:</label>
                                                                    <input type="text" id="akicf7_apikey" value="' . $key . '" disabled="akicf7_apikey">
                                                                    <input type="hidden" id="akicf7_apikey_" name="akicf7_apikey" value="' . $key . '" >
                                                           </div> 
                                                            <div class="akicf7_select_list">
                                                                <label>Select Klaviyo List</label>
                                                                <select class="form-control_ akicf7_lists" required="">
                                                                ' . $lists . '
                                                                </select>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                <input id="post_id" type="hidden" value="'.$post_id.'" name="post_id">
                                        </fieldset>         
                                        
                                        <div id="akicf7_has_lists">
                                                <fieldset class="map-fields">
                                        
                                                <div class="row reverse">
                                                    <div class="col-md-9"> 
                                                    <h2>Map Fields:</h2>

                                                    ' . $blocks . '

                                                    <div id="add_on_fields">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="col-md-3 pull-right akicf7_add_block">
                                                            <a  onclick="custom_adding_field_block();" class=" btn_ btn-primary_ btn-full" ><img src="/wp-content/plugins/awesome-cf7/admin/images/add.svg"/>Add Field</a>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    
                                                    </div>
                                        
                                                    <div class="col-md-3"> 
                                                    <button id="cak">Change Api Key</button>
                                                </div>
                                                </div>
                                                </fieldset>   
                                    </div>
                                 <div class="aki7_loader"></div>
                            ',
                    'cf7_select_fields' => $merged_cf7_fields,
                    'klaviyo_select_fields' => $klaviyo_fields,
                );
                // echo "<pre>";
                // print_r($html);exit;
                wp_send_json_success(json_encode($html));
            }
        } catch (Exception $e) {
            $errr = [];
            $errr['error'] = true;
            array_push($errr, $e->getMessage());
            wp_send_json_error($errr);
        }
    }



    // function wpcf7_save_contact_form( $args = '', $context = 'save' ) { }
    function form_submit_from_frontend(){
                              
        try{

            $val = [];
            $keyy = [];
            $posted_inputs = $_POST;
            $post_id = array_key_exists("_wpcf7",$posted_inputs);
            $post_id && $post_id = $posted_inputs['_wpcf7'];

            foreach ($posted_inputs as $key => $input) {
                $trimmed = trim($key, "your-");
                $trimmed = str_replace("-","_",$trimmed);
                if (!strpos($key, "wpcf")) {
                    array_push($keyy, $trimmed);
                    array_push($val, $input);
                }         
            }
            $input_fields = array_combine($keyy,$val);
    
            $apiKey = get_option('akicf7_' . $post_id . '_apikey');
            $mapped_fields = get_option('akicf7_' . $post_id . '_mapped_fields');
            $mapped_fields = unserialize($mapped_fields);
    
            $common_array_keys = array_intersect_key($input_fields, $mapped_fields);
            $json_data_obj = json_encode($common_array_keys);

            echo "<pre>";
            print_r($input_fields);
            print_r($mapped_fields);
            print_r($json_data_obj);
            //exit;

            $post_response = $this->create_profile($apiKey, $json_data_obj);

            echo "<pre>";
            print_r($post_response);
            exit;

        }catch (Exception $e) {
            echo $e;
        }
    }

    function create_profile($apiKey , $json_data_obj){

        if($json_data_obj == "create_dummy_user") {
            $json_data_obj = '{"first_name":"dummy","last_name":"dummy","email":"dummy4@dummy.com"}';
        }
      
        require_once(plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php');
        $client = new \GuzzleHttp\Client();
        $post_response = $client->request('POST', 'https://a.klaviyo.com/api/profiles/', [
            'body' => '
               {"data":
                   {
                        "type":"profile",
                        "attributes": '. $json_data_obj .'
                    }
                }
            ',
            'headers' => [
                'Authorization' => 'Klaviyo-API-Key '. $apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'revision' => '2023-09-15',
            ],
        ]);

        $post_response = json_decode($post_response->getBody());
        $post_response = (array)$post_response->data;
        
        return($post_response['id']);
    }
}
