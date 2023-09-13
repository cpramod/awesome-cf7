(function( $ ) {
	'use strict';

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
	$(document).on('click','#a-cf7-custom-field',function(){
		var input_value = $('#a-cf7-custom-field').val();
		if(input_value == ""){
			input_value = $('#a-cf7-custom-field').val('checked')
		}else{
			input_value = $('#a-cf7-custom-field').val();
		}
		// console.log("input_value",input_value);
		if(input_value[0].defaultValue == "checked" || input_value == "checked"){
			var append_data = `
			                   <div class="api_input_box">
							          <label>Enter Your Api Key:</label>
									  <input type="text" id="apiKey" name="apiKey">
							   </div>
			`;
			var found = jQuery('#custom-fields').find(".api_input_box");
			// console.log("found",found.length);
			if(found.length == 0){
				$('#custom-fields').append(append_data);
			}else{
				input_value = $('#a-cf7-custom-field').val();
				$('#custom-fields .api_input_box').remove();
			}
		}else{
			$('#custom-fields .api_input_box').remove();
		}
	})

})( jQuery );

