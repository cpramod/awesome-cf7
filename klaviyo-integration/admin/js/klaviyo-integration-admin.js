(function($) {
    "use strict";

    var apiKey, selected_klaviyo_list, php_cf7_fields, klaviyo_fields, count;
    selected_klaviyo_list;
    php_cf7_fields = [];
    klaviyo_fields = [];

       // Enable Klaviyo Integration: checkbox   
       $(document).on("click", "#akicf7_checkbox", function() {
            $('.akicf7_api_input').toggle();
        });

        // choose a klaviyo-list from fetched lists
        $(document).on("click", ".akicf7_fetch_all_lists", function(e) {
            apiKey = $("#akicf7_apikey").val();
            if (apiKey == "") {
                e.preventDefault();
                alert("Please Enter Your Valid Api Key");
                return 0;
            } else {
                get_all_forms_list_from_klaviyo(e);
            }
        });

        function get_all_forms_list_from_klaviyo(e) {
            let post_id = $('#post_id').val();
            if (!e == "") {
                e.preventDefault();
            }
           loader(0);

            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
                data: {
                    action:'get_data', //this value is first parameter of add_action
                    api: apiKey,
                    post_id: post_id
                },
                success: function(response){                  
                    //console.log(JSON.parse(response.data).html);   
                    if(response.success == false){
                        localStorage.removeItem("aki");
                        alert("Error! please enter valid Api key.");
                        $('#apiKey').focus().val("");
                        loader(1);
                        return 0;
                    }
                    if (response.success == true) {  
                        console.log("response.data).html",JSON.parse(response.data).cf7_select_fields);
                        php_cf7_fields = JSON.parse(response.data).cf7_select_fields;
                        klaviyo_fields = JSON.parse(response.data).klaviyo_select_fields;

                        $('#akicf7').html(JSON.parse(response.data).html); 
                        $('.akicf7_fetch_all_lists').remove();
                        loader(1);
                    }
                }
            });
    
        }

        // choose a klaviyo-list from fetched lists
        $(document).on("change", ".akicf7_lists", function() {
            selected_klaviyo_list = $(this).val();
            get_list_fields()
        });
        function get_list_fields() {
            loader(0);
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
                data: {
                    action:'get_data', //this value is first parameter of add_action
                    api: apiKey,
                    listId: selected_klaviyo_list
                },
                success: function(response){
                   var single_list = response.data.data;
                   console.log("single_list", single_list);     
                   loader(1);  
                }
            });
        }

        function loader(length) {
            if (length > 0) {
                $('#akicf7').removeClass("loader_active");
                $('.aki7_loader').hide();
            } else {
                $('#akicf7').addClass("loader_active");
                $('.aki7_loader').show();
            }
        }

        // change api key button
        $(document).on("click", "#cak", function(e) {
            e.preventDefault();
            $("#akicf7_apikey").val("").removeAttr('disabled');
            $(".akicf7_api_box>div").append('<button class="akicf7_fetch_all_lists">Fetch Klaviyo Lists</button> <div class="aki7_loader"></div>');
            $(".akicf7_api_box>div label").css('display',"block");
            $('#akicf7_has_lists, .akicf7_select_list').remove();
            $(".akicf7_enabled span , ._map_key_ span").addClass('disabled').text("Disabled");
        });
        // custom -- delete button
        $(document).on("click", ".delete", function() {
            $(this).closest(".akicf7_block").remove();
        });
        // custom -- add button
        $(document).on("click", ".akicf7_add_block", function() {
            custom_adding_field_block()
        });

        count = 0 ;
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
            $('.php_cf7_fields'+count ).append('<option value="' + value +'">' + value + '</option>');
        });
        $.each(klaviyo_fields, function(key, value) {
            $('.klaviyo_cf7_fields'+count).append('<option value="' + value +'">' + value + '</option>');
        });
        count++;
        }

        // // assigning custom name to custom added fields
            // var counter= 1;
            // $(document).on('change','#add_on_fields select',function(){
            //     var val,attr;
            //     val =$(this).val();
            //     //attr = $(this).attr('name');
            //    if(this.className.includes("klaviyo")){
            //       // $(this).attr("name",'akicf7[custom_klaviyo_'+counter+"_"+attr+"_"+val+']');
            //       $(this).attr("name",'akicf7['+"custom_klaviyo-"+val+" "+counter+']');
            //         //  $(this).attr("name",'akicf7['+val+']');
            //          counter++;
            //    }else{
            //      //  $(this).attr("name",'akicf7[custom_cf7_'+counter+"_"+attr+"_"+val+']');
            //       $(this).attr("name",'akicf7['+"custom_cf7-"+val+" "+counter+']');
            //         //  $(this).attr("name",'akicf7['+val+']');
            //    }        
            // })
        var val; // takes value from another slect parallel to it , FOR MAPPING PURPOSE 
        $(document).on('change','#add_on_fields select',function(){
           if(this.className.includes("klaviyo")){
              $(this).attr("name",'akicf7['+val+']');
           }else{
              val =$(this).val();
              $(this).attr("name",val);
           }        
        })


})(jQuery);





