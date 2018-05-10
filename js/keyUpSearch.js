

$(function() {
	$("#reg_email").on('keyup', function() { 
		var input = $(this).val(); 
		if ( input.length >= 4 ) { 
			$("#loaderIcon").show();
			var dataFields = {'input': input}; 
			$.ajax({
				type: "POST",
				url: "check_availability.php", 
				data: dataFields, 
				timeout: 3000,
				success: function(data){ 
					$("#loaderIcon").hide();
					$('#match').html(data); 
					});
				},
				error: function() { 
					$('#match').text('Problem!');
				}
			});
		} else {
			$('#match').text(''); 
		}
	});
});

 
