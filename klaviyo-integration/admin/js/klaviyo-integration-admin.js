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
  $(document).on("click", "#a-cf7-custom-field", function () {
    var input_value = $("#a-cf7-custom-field").val();
    if (input_value == "") {
      input_value = $("#a-cf7-custom-field").val("checked");
    } else {
      input_value = $("#a-cf7-custom-field").val();
    }
    // console.log("input_value",input_value);
    if (input_value[0].defaultValue == "checked" || input_value == "checked") {
      var append_data = `
			                   <div class="api_input_box">
							          <label>Enter Your Api Key:</label>
									  <div><input type="text" id="apiKey" name="apiKey"> <button class="_button">Fetch Klaviyo Lists</button></div>
							   </div>
			`;
      var found = jQuery(".a_cf7_ki").find(".api_input_box");
      // console.log("found",found.length);
      if (found.length == 0) {
        $(".a_cf7_ki").append(append_data);
        $(".a_cf7_ki ._h2 span").css("color", "green").text("Enabled");
      } else {
        input_value = $("#a-cf7-custom-field").val();
        $(".a_cf7_ki .api_input_box").remove();
        $(".a_cf7_ki ._h2 span").css("color", "red").text("Disabled");
      }
    } else {
      $(".a_cf7_ki .api_input_box").remove();
    }
  });

  var all_klaviyo_list = [];
  var apiKey;
  $(document).on("click", ".api_input_box ._button", function (e) {
    apiKey = $("#apiKey").val();
    // var test_call = 'https://a.klaviyo.com/api/v2/lists?api_key='+apiKey
    // console.log("api call", test_call);
    get_list_from_klaviyo(e);
  });

  function get_list_from_klaviyo(e) {
    e.preventDefault();
    const options = { method: "GET", headers: { accept: "application/json" } };
    fetch("https://a.klaviyo.com/api/v2/lists?api_key=" + apiKey, options)
      .then((response) => response.json())
      .then((response) => {
        all_klaviyo_list = response;
        console.log("all_klaviyo_list",all_klaviyo_list);
		if (all_klaviyo_list.length > 0) {
		  	append_fetched_data();
		}
      })
      .catch((err) => console.error(err));
  }

  function append_fetched_data(){

		$(".api_input_box ._button").fadeOut();
		$(".a_cf7_ki").append(`
								 <div id="has_lists">
								 <select class="form-control f_list" required="">
								 </select>
									<fieldset class="map-fields">
										<h2 class="head_ing">Map Fields:</h2>
										<div class="form-group add_block">
											<div class="row">
											<div class="col-md-8">
												<div class="col-md-4">
													<label>Email<span> *</span></label>
												</div>
												<div class="col-md-8">
													<select class="form-control" required="" name="KLCF_data[$email]">
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
											<div class="col-md-8">
												<div class="col-md-4">
													<label>First Name</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" required="" name="KLCF_data[$first_name]">
														<option value="0">Select</option>
														<option value="your-name">Your Name</option>
														<option value="your-email">Your Email</option>
														<option value="your-subject">Your Subject</option>
														<option value="your-message">Your Message</option>
													</select>
												</div>
											</div>
											<div class="col-md-4"> <a class="btn btn-danger" onclick="KLCF_remove_custom_field(this);">Remove</a>
											</div>
											</div>
										</div>
										<div class="form-group add_block">
											<div class="row">
											<div class="col-md-8">
												<div class="col-md-4">
													<label>Last Name</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" required="" name="KLCF_data[$last_name]">
														<option value="0">Select</option>
														<option value="your-name">Your Name</option>
														<option value="your-email">Your Email</option>
														<option value="your-subject">Your Subject</option>
														<option value="your-message">Your Message</option>
													</select>
												</div>
											</div>
											<div class="col-md-4"> <a class="btn btn-danger" onclick="KLCF_remove_custom_field(this);">Remove</a>
											</div>
											</div>
										</div>
										<div id="add_on_fields">
										</div>
										<div class="row">
											<div class="col-md-12">
											<div class="col-md-4 pull-right">
												<a class="btn btn-primary btn-full" onclick="KLCF_add_custom_field();">Add Fields</a>
											</div>
											</div>
										</div>
										<br>
										<br>
										<div class="card p-2">
											<div class="form-group form-check" style="margin:15px;">
											<label class="form-check-label"><input type="checkbox" class="form-check-input add_tag" style="margin: 0px;" name="KLCF_enable_tag" value="1" onchange="KLCF_enable_tags(this);">
											&nbsp; Enable GDPR </label><!-- <small>(use this tag in form [klaviyo_gdpr])</small>     -->
											</div>
											<div class="form-group add_tag_input ">
											<div class="row">
												<div class="col-md-12">
													<div class="col-md-12">
														<textarea type="input" class="form-control" placeholder="Enter GDPR Terms" name="KLCF_custom_tag"></textarea>
													</div>
													<div class="col-md-12">
														<small>** [klaviyo_gdpr] will be added automatically above the submit button else you
														can add the tag manually in the form</small>
													</div>
												</div>
											</div>
											</div>
										</div>
										<div class="card p-2">
											<div class="form-group form-check" style="margin:15px;">
											<a href="" target="_blank">
											<img src="" style="width: 100%;">
											</a>
											</div>
										</div>
								</fieldset>
								 </div>
			`);

		$.each(all_klaviyo_list, function(key,val) {             
			console.log(val.list_name);         
			$('.f_list').append('<option value="0">'+val.list_name+'</option>');
			});     
  }

})(jQuery);
