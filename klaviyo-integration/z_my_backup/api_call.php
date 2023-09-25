<?php

// class Api_call {

//     public function  fetch_all_lists($post){
//         //print_r($_POST);exit;

//         require_once(plugin_dir_path( dirname( __FILE__ ) ) .'vendor/autoload.php');
//         $client = new \GuzzleHttp\Client();
//         $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/'.$data["listId"], [
//             'headers' => [
//                 'Authorization' => 'Klaviyo-API-Key '.$data["api"],
//                 'accept' => 'application/json',
//                 'revision' => '2023-09-15',
//             ],
//             ]);
           
//          // $res = json_decode($response->getBody());
//          // echo $response->getBody();exit;
//          return $res;
//         // wp_send_json_success($res);
//     }
  

//}

$html = array(
    'html' => '
            <div class="a_cf7_ki">
                <h2 class="_h2"><span>Disabled</span></h2>
                <fieldset>
                        <label for="akicf7_label">Enable Klaviyo Integration: </label>
                        <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" '. $a .' value=""/>
                            <div class="akicf7_api_input '.$b .' ">
                                <div class="akicf7_api_box">
                                    <label>Enter Your Api Key:</label>
                                    <div>
                                        <input type="text" id="akicf7_apikey" name="akicf7_apikey" value="'. $c .' "> 
                                        <button class="akicf7_fetch_all_lists">Fetch Klaviyo Lists</button>
                
                                            <div class="select_lists">
                                                <label>Select Klaviyo List</label>
                                                <select class="form-control_ f_list" required="">
                                                '. $lists .'
                                                </select>
                                            </div>                       
                                    </div>
                                </div>
                            </div>
                </fieldset>         
                
                <div id="has_lists">
                        <fieldset class="map-fields">
                
                        <div class="row">
                            <div class="col-md-9"> 
                            <h2 class="head_ing">Map Fields:</h2>
                            <div class="form-group add_block">
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
                            <div class="form-group add_block">
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
                            <div class="form-group add_block">
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
                                <div class="col-md-3 pull-right add">
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