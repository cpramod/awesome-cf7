<?php


        // echo strstr($key, "-"); 
        //<label><?php  if(strpos($key, "-")) { echo substr($key, strpos($key, '-') + 1); } else{ echo $key; } ?><span><?php echo in_array($key, $astrik_array) ? " *" : "" ; ?> </span></label>




        // public function KLCF_admin_after_additional_settings() {

        //     $post_id = sanitize_text_field($_GET['post']);
        //     $enable =   get_post_meta($post_id, "_KLCF_enable", true); 
        //     $f_data = get_post_meta($post_id, "_KLCF_data", true); 
        //     $enable_tag = get_post_meta($post_id, "_KLCF_enable_tag", true); 
        //     $custom_tag = get_post_meta($post_id, "_KLCF_custom_tag", true);

        //     $manager = WPCF7_FormTagsManager::get_instance();
    
        //     $form_tags = $manager->get_scanned_tags();
    
        //     $form_scan_tags = $this->tags_formate_array($form_tags);
        //     $auto_field_selected = $this->KLCF_searchField('email',$form_tags);
    
        //     $map_fields = array(
    
        //             [
        //                 'name' => 'email',
        //                 'key' => '$email',
        //                 'required' => true
        //             ]
        //         );

        //         var_dump($map_fields);
        //         exit;
    
        //     if(empty($f_data)){
            
        //         $map_fields[] =     
        //             [
        //                 'name' => 'first name',
        //                 'key'  => '$first_name',
        //                 'required' => false
        //             ];
        //         $map_fields[] =
        //             [
        //                 'name' => 'last name',
        //                 'key'  => '$last_name',
        //                 'required' => false
        //             ];          
        //     }else{
    
        //         $map_field[] =      
        //             [
        //                 'name' => 'first name',
        //                 'key'  => '$first_name',
        //                 'required' => false
        //             ];
        //         $map_field[] =
        //             [
        //                 'name' => 'last name',
        //                 'key'  => '$last_name',
        //                 'required' => false
        //             ];
    
        //         $keys = array_keys($f_data);                    
        //         foreach($map_field as $row){
        //             if(in_array($row['key'],$keys)){
        //                 $map_fields[] = $row;
        //             }
        //         }
        //     }
    
        //     // if()
    
        //     $map_extra_fields = array(
        //         [
        //             'name' => 'First Name',
        //             'key'  => '$first_name',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'Last Name',
        //             'key'  => '$last_name',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'Phone',
        //             'key'  => '$phone_number',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'City',
        //             'key'  => '$city',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'Region',
        //             'key'  => '$region',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'Country',
        //             'key'  => '$country',
        //             'required' => false
        //         ],
        //         [
        //             'name' => 'Zip',
        //             'key'  => '$zip',
        //             'required' => false
        //         ],
    
        //     );
    
        //     // include('templates/intregation-form.php');
        //     return 0;
        // }
        // $this->KLCF_admin_after_additional_settings();
    

















// -------------------------------------------------------------

        // public function pass_var_to_js() {
        //     $data = $_POST;
        //     try {
        //         if(array_key_exists("pass_var_to_js",$data)){
        //             $php_var = array(
        //                 'name' => 'John',
        //                 'age' => 30,
        //                 'city' => 'New York'
        //               );
                    
        //           wp_send_json_success(jjson_encode($php_var));
        //         }
        //     }catch(Exception $e) {
        //         $errr = [];
        //         $errr['error'] = true;     
        //         wp_send_json_error($errr);               
        //     }

        // }
        

// $blocks = "";
// foreach($form_fields as $field){      
//     $trimmed = ucwords(trim($field->raw_name, "your-"));      
//     $blocks .= '                          
//                <div class="form-group akicf7_block">
//                <div class="row">
//                    <div class="col-md-9">
//                        <div class="col-md-4">
//                            <label>'.$trimmed.'<span> *</span></label>
//                        </div>
//                        <div class="col-md-8">
//                            <select class="form-control" required="" name="">
//                                '.$fields.'
//                            </select>
//                         </div>
//                     </div>
//                     <div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/klaviyo-integration/admin/images/delete.svg"/>Remove</a></div>
//                 </div>
//              </div>                         
//     ';
// }    



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
