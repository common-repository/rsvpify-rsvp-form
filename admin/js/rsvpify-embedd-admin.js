var $ = jQuery.noConflict();

jQuery(document).ready(function($) 
{
	var $element;
	'use strict';

	$(document).on('click', '.glyphicon-remove', function () 
	{
		$('#cancelModal').modal();
		$element = $(this);
	});

    $("[name='toggle-https']").bootstrapSwitch({onColor: 'brand'});

	$("#delete_event_button").click(function()
	{
		$.ajax({
			type: "POST",
			url: myAjax.ajaxurl,
			data: 
			{
				id : $element.attr('id'),
				action : "removeEntry"
			}, 

			success:function(data)
			{
				$('#cancelModal').modal('hide');
				$element.closest("tr").remove();
			}
		}); 
	}); 

	$('#myModal').on('hidden.bs.modal', function (e) {
		$('#')
	});

	$("#submit_button").click(function()
	{
		$('#myModal').modal()
	}); 

	$("#add_event_button").click(function()
	{
		//validate input
		var event_id = $("#event_id").val();
		var toggle_https = $("#toggle-https").is(":checked") ? 1 : 0;
		console.log(toggle_https);
		if($.isNumeric(event_id))
		{
			$.ajax({
				type : 'POST',
				url : 'https://rsvpify.com/wp_plugin_api/api.php',      
				data: 
				{
					event_id,
				},
				success: function (data) 
				{
					if(data === 'null')
					{
						$("#event_group").addClass("has-error has-feedback");
						$("#event_error_label").text('There isn\'t an event with that ID.');
						$("#event_error_label").show();
					}
					else
					{
						var obj = jQuery.parseJSON(data);

						$.ajax({
							type: "POST",
							url: myAjax.ajaxurl,
							data: {
								obj,
								toggle_https,
								action : "processAjax"
							}, 
							success:function(data)
							{
								if(data === "duplicate")
								{
									$("#event_group").addClass("has-error has-feedback");
									$("#event_error_label").text('That event is already associated with a shortcode.');
									$("#event_error_label").show();									
								}
								else
								{

									$('#myModal').modal('hide');
									var ob2 = jQuery.parseJSON(data);
									var str = "<a href='#'><span class='glyphicon glyphicon-remove'" + "id=" + ob2[1] + '></span>';
                                    ob2[0] = ob2[0].replace(/\\/g, '');
									$('#myTable').append('<tr><td>'+ ob2[0]+'</td><td>'+ ob2[1]+'</td><td>'+ '['+ ob2[1]+']'+ '</td>'+ '<td>'+ unescape(str) +'</td>'+'</tr>');
								}
							}
						});
					}
				},
				error: function (data)
				{
					alert(errorThrown);
				},       
			}); 
}

else
{
	$("#event_group").addClass("has-error has-feedback");
	$("#event_error_label").text('Please enter a valid numerical value.');
	$("#event_error_label").show();
} 
});

});

(function( $ ) 
{
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

	})( jQuery );
