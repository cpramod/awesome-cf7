(function($) {
    "use strict";

    var apiKey;
    var selected_klaviyo_list;
    let local_storage = localStorage.getItem("aki");

        if(local_storage != null ){    
            apiKey = localStorage.getItem("aki");
            get_all_forms_list_from_klaviyo(null);
        }else{
         setTimeout(()=>{
            apiKey =  $('#akicf7_apikey').val().trim();
            if(apiKey != "" ){
                // localStorage.setItem("aki", apiKey);
                get_all_forms_list_from_klaviyo(null);
            }
         },500);
        }

       // Enable Klaviyo Integration: checkbox   
       $(document).on("click", "#akicf7_checkbox", function() {
            $('.akicf7_api_input').toggle();
        });

        // choose a klaviyo-list from fetched lists
        $(document).on("click", ".akicf7_fetch_all_lists", function(e) {
            apiKey = $("#akicf7_apikey").val();
            if (local_storage == null) {
                // localStorage.setItem("aki", apiKey);
            }
            if (apiKey == "") {
                e.preventDefault();
                alert("Please Enter Your Valid Api Key");
                return 0;
            } else {
                get_all_forms_list_from_klaviyo(e);
            }
        });

        function get_all_forms_list_from_klaviyo(e) {
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
                    api: apiKey
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
            console.log("loader",length)
            if (length > 0) {
                $('#akicf7').removeClass("loader_active");
                $('.aki7_loader').hide();
            } else {
                $('#akicf7').addClass("loader_active");
                $('.aki7_loader').show();
            }
        }

})(jQuery);


