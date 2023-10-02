<?php

try {
    // klaviyo all lists start ****
     $this->setApikey($apiKey);
     $klaviyo_fields = $this->fetch_lists_fields_from_klaviyo();

        // $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/' . $data["listId"], [
        //     'headers' => [
        //         'Authorization' => 'Klaviyo-API-Key ' . $apiKey ,
        //         'accept' => 'application/json',
        //         'revision' => '2023-09-15',
        //     ],
        // ]);
        // $res = json_decode($response->getBody());

    // remove this  $klaviyo_fields
    //$klaviyo_fields = ['Select'=>'Select','Name'=>'Name', 'Email'=>'Email', 'Phone'=>'Phone', 'Message'=>'Message'];  // remove this array
     
    $response = $client->request('GET', 'https://a.klaviyo.com/api/lists/', [
        'headers' => [
            'Authorization' => 'Klaviyo-API-Key ' . $apiKey,
            'accept' => 'application/json',
            'revision' => '2023-09-15',
        ],
    ]);
    $res = json_decode($response->getBody());
    $newArray = (array)$res->data;

    // contact-form-7 start ****
    $ContactForm = WPCF7_ContactForm::get_instance($post_id);
    $form_fields = $ContactForm->scan_form_tags();
    
    $cf7_fields_name = [];
    $blocks = "";
    $astrik_array = [];
    foreach ($form_fields as $field) {
        $trimmed = ucwords(trim($field->raw_name, "your-"));
        if ($trimmed != "") {
            array_push($cf7_fields_name, $trimmed);
        }
        $check_asterik = $field->type;
        if (strpos($check_asterik, "*") !== false) {
            array_push($astrik_array, $trimmed);
        }         
    }

    $cf7_extra_fields = array("Phone", "City", "zip", "Go Pro ..");
    $merged_cf7_fields = array_merge($cf7_fields_name, $cf7_extra_fields);
} catch (Exception $e) {
    echo $e;
}
?>
   <div id="akicf7"  class="_map_key_"> 
    <h2 class="_h2"><?php echo esc_html(__('Integration Status:', 'contact-form-7')); ?><span>Enabled</span></h2>
    <fieldset>
        <label for="akicf7_label">Enable Klaviyo Integration: </label>
        <input type="checkbox" id="akicf7_checkbox" name="akicf7_checkbox" <?php echo $apiKey ? 'checked' : ''; ?> value="" />
        <div class="akicf7_api_input app <?php echo $apiKey  ? 'enable' : 'disable'; ?> ">
            <div class="akicf7_api_box">
                <div>
                    <label>Enter Your Api Key:</label>
                    <input type="text" id="akicf7_apikey"  value="<?php echo $apiKey ? $apiKey : ''; ?>" disabled>
                    <input type="hidden" id="akicf7_apikey_" name="akicf7_apikey" value="<?php echo $apiKey ? $apiKey : ''; ?>">
                </div>
                <div class="akicf7_select_list">
                    <label>Select Klaviyo List</label>
                    <select class="form-control_ akicf7_lists" required="">
                        <?php
                        foreach ($newArray as $list) {
                            echo "<option value=" . $list->id . ">" . $list->attributes->name . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <input id="post_id" type="hidden" value="<?php echo $post_id ?>" name="post_id">
    </fieldset>

    <div id="akicf7_has_lists">
        <fieldset class="map-fields">

            <div class="row reverse">
                <div class="col-md-9">
                    <h2>Map Fields:</h2>


                    <?php foreach ($mapped_fields  as $key => $value) { 
                        // var_dump($key);
                        // var_dump($value);
                        ?>
                        <div class="form-group akicf7_block">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="col-md-4">
                                        <label><?php  if(strpos($key, "-")) { echo substr($key, strpos($key, '-') + 1); } else{ echo $key; } ?><span><?php echo in_array($key, $astrik_array) ? " *" : "" ; ?> </span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" required="" name="akicf7[<?php echo $key ?>]">
                                            <?php foreach ($klaviyo_fields as $key1 => $value1) {
                                                // var_dump($value1);
                                                // var_dump($key1);
                                                // var_dump($value);
                                                if($value1 == $value ){
                                                    echo "<option selected value=" . $value . ">". $value ."</option>";
                                                }else{
                                                    echo "<option value=" . $value1 . ">". $value1 ."</option>";
                                                }                                              
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php echo in_array($key, $astrik_array) ? "" : "<div class='col-md-3 delete'> <a class='btn_ btn-danger_'><img src='/wp-content/plugins/klaviyo-integration/admin/images/delete.svg'/>Remove</a></div>";  ?>
                            </div>
                        </div>
                    <?php } ?>



                    <div id="add_on_fields">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3 pull-right m_akicf7_add_block">
                                <!-- <a onclick="custom_adding_field_block();" class=" btn_ btn-primary_ btn-full"><img src="/wp-content/plugins/klaviyo-integration/admin/images/add.svg" />Add Field</a> -->
                                <a class=" btn_ btn-primary_ btn-full"><img src="/wp-content/plugins/klaviyo-integration/admin/images/add.svg" />Add Field</a>
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
    
    <script type="text/javascript">
        (function($) {
        "use strict";
                var klaviyo_fields =   JSON.parse('<?php echo json_encode(array_filter($klaviyo_fields)); ?>');
                var php_cf7_fields =   JSON.parse('<?php echo json_encode(array_filter($merged_cf7_fields)); ?>');

                // custom -- add button
                $(document).on("click", ".m_akicf7_add_block", function() {
                    custom_adding_field_block()
                });

                var count = 0 ;
                function custom_adding_field_block() {       
                    $("#add_on_fields").append(`
                            <div class="form-group akicf7_block c${count}">
                            <div class="row">
                            <div class="col-md-9">
                                <div class="col-md-4">
                                <select class="form-control php_cf7_fields p${count}" required="" name="${count}">
                                <option value="Select">Select</option>
                                </select>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control klaviyo_cf7_fields k${count}" required="" name="${count}">
                                        <option value="Select">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/klaviyo-integration/admin/images/delete.svg"/>Remove</a>
                            </div>
                            </div>
                        </div>
                    `)
                        $.each(php_cf7_fields, function(key, value) {
                            // $('.php_cf7_fields'+count ).append('<option value="' + value +'">' + value + '</option>');
                            $('.php_cf7_fields').append('<option value="' + value +'">' + value + '</option>');
                        });
                        $.each(klaviyo_fields, function(key, value) {
                            // $('.klaviyo_cf7_fields'+count).append('<option value="' + value +'">' + value + '</option>');
                            $('.klaviyo_cf7_fields').append('<option value="' + value +'">' + value + '</option>');
                        });
                        count++;
                }
        })(jQuery);
    </script>