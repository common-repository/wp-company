(function ( $ ) {
	"use strict";

	$(document).ready(function(){ 

		$('#wp-company-submit').click(function(e){	
			e.preventDefault();
			
			var _data = $('#wp-company-form').serialize();

			$.ajax({
				type: 		"POST",
				url: 		ajaxurl, 
				dataType: 	'json',
				data: 		_data,
				success: function(response){ 
					/*
					var _return = '';
					$.each( response, function( key, value ) {
						_return += key + ':' + value + ';';
					});
					*/
					alert("Options Updated");
					location.reload();
				},
				error: function(MLHttpRequest, textStatus, errorThrown){  
					alert("There was an error: " + errorThrown);  
				},
				timeout: 60000
			});  
		});
	});

}(jQuery));