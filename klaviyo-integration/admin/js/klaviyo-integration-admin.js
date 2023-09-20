(function ($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  var all_klaviyo_list = [];
  var apiKey ;
  let local_storage = localStorage.getItem("ak7_apiKey");
  var selected_klaviyo_list = "RBEBce";
  //   var apiKey="pk_2e7ce7bd3820c5309c254207cc681e3016";
  //   var selected_klaviyo_list = "SyNiES" //test
  //   var apiKey="pk_5b2f7c44386b67d73ed184f059ac862eb0"; // test

    //if(!local_storage == ""){
	// $(".a_cf7_ki fieldset").append(append_data);
	// $(".a_cf7_ki ._h2 span").css("color", "#1ed41e").text("Enabled");
	// $("#apiKey").val(local_storage);
	// append_ui()
    // }

  $(document).on("click", "#a-cf7-custom-field", function () {
    enter_your_api_key_block();
  });
  $(document).on("click", ".api_input_box ._button", function (e) {
    apiKey = $("#apiKey").val();
    if(local_storage == null){
		localStorage.setItem("ak7_apiKey", apiKey);
	}
    // var test_call = 'https://a.klaviyo.com/api/v2/lists?api_key='+apiKey
    // console.log("api call", test_call);
	if(apiKey == ""){
		e.preventDefault();
		alert("Please Enter Your Valid Api Key");
		return 0;
	 }else{
		get_all_forms_list_from_klaviyo(e);
	 }
  });

  $(document).on("change", ".select_lists .f_list option", function () {
	console.log("$(this)",$(this));
    selected_klaviyo_list = $(this).val();
	//console.log("selected_klaviyo_list",selected_klaviyo_list);
	get_list_fields()
  });
function enter_your_api_key_block(){
	var input_value = $("#a-cf7-custom-field").val();
    // if (input_value == "") {
    //   input_value = $("#a-cf7-custom-field").val("checked");
    // } else {
    //   input_value = $("#a-cf7-custom-field").val();
    // }
	if (input_value == "") {
		input_value = $("#a-cf7-custom-field").val("checked");
	}

    if (input_value[0].defaultValue == "checked" || input_value == "checked") {
      var append_data = `
			                   <div class="api_input_box">
							          <div class="api_box">
										<label>Enter Your Api Key:</label>
										<div>
											<input type="text" id="apiKey" name="apiKey"> 
											<button class="_button">Fetch Klaviyo Lists</button>
										</div>
									  </div>
							   </div>
			`;
      var found = $(".a_cf7_ki").find(".api_input_box");
      if (found.length == 0) {
        $(".a_cf7_ki fieldset").append(append_data);
        // $(".a_cf7_ki ._h2 span").css("color", "#1ed41e").text("Enabled");
		if(!local_storage == ""){
			$("#apiKey").val(local_storage);
			apiKey = local_storage;
			if(all_klaviyo_list.length > 0){
				append_ui(); 
			}else{
				get_all_forms_list_from_klaviyo();
			}			
		 }	
      } else {
        input_value = $("#a-cf7-custom-field").val();
        $(".a_cf7_ki .api_input_box, #has_lists ").remove();
        // $(".a_cf7_ki ._h2 span").css("color", "#d10707").text("Disabled");
      }
    } else {
      $(".a_cf7_ki .api_input_box, #has_lists").remove();
    }
}
  function get_all_forms_list_from_klaviyo(e) {
	if(!e == ""){
		e.preventDefault();
	}
	loader();
    const options = { method: "GET", headers: { accept: "application/json", Authorization: apiKey } };
    fetch("https://a.klaviyo.com/api/v2/lists?api_key=" + apiKey, options)
      .then((response) => response.json())
      .then((response) => {
        all_klaviyo_list = response;
		//console.log("all_klaviyo_list", all_klaviyo_list);
		if (all_klaviyo_list.length > 0) {
		  	append_ui();
			loader();
		}
      })
      .catch((err) => console.error(err));
  }

  function get_list_fields(){
	  const options = {
		 method: "GET", 
		 headers: { 
			accept: "application/json", 
			"revision": "2023-05-11",
			"content-type": "application/json",
			Authorization: "Klaviyo-API-Key"+apiKey } };

	  console.log("options::",options)
	  fetch('https://a.klaviyo.com/api/lists/'+selected_klaviyo_list, options)
		.then(response => response.json())
		.then(response => console.log("response for get_list_fields",response))
		.catch(err => console.error(err));
  }

  function append_ui(){
		// $(".api_input_box ._button").remove();
		$(".api_input_box ._button").hide();
		$(".api_input_box").append(`
									<div class="select_lists">
									     <label>Select Klaviyo List</label>
										 <select class="form-control_ f_list" required=""></select>
									</div>
		`);

		$(".a_cf7_ki").append(`
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
			`);

		$.each(all_klaviyo_list, function(key,list) {              
			$('.select_lists .f_list').append('<option value="'+list.list_id+'">'+list.list_name+'</option>');
		});     
		$('#apiKey').attr('disabled','disabled');
		$(".a_cf7_ki ._h2 span").css("color", "#1ed41e").text("Enabled");
  }

  function loader(){
    if(all_klaviyo_list.length > 0){
		$('.a_cf7_ki').removeClass("loader_active");
		$('.aki7_loader').hide();
	}else{
		$('.a_cf7_ki').addClass("loader_active");
		$('.aki7_loader').show();
	}
  }
  $(document).on("click", ".add", function () {
	custom_adding_field_block()
  });
  $(document).on("click", ".delete", function () {
	$(this).closest(".add_block").remove();
  });
  $(document).on("click", "#cak", function (e) {
	e.preventDefault();
	localStorage.removeItem("ak7_apiKey");
	$("#apiKey").val("").removeAttr('disabled');
	$(".api_input_box ._button").show();
	$('#has_lists,.select_lists').remove();
	$(".a_cf7_ki ._h2 span").css("color", "#d10707").text("Disabled");
  });
  function custom_adding_field_block(){
    $("#add_on_fields").append(`
				<div class="form-group add_block">
				<div class="row">
				<div class="col-md-9">
					<div class="col-md-4">
					<select class="form-control" required="" name="">
					   <option value="0">Select</option>
				    </select>
					</div>
					<div class="col-md-8">
						<select class="form-control" required="" name="">
							<option value="0">Select</option>
						</select>
					</div>
				</div>
				<div class="col-md-3 delete"> <a class="btn_ btn-danger_"><img src="/wp-content/plugins/klaviyo-integration/admin/images/delete.svg"/>Remove</a>
				</div>
				</div>
			</div>
	`)
  }


})(jQuery);
