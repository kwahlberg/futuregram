
$("#myTextField").on('keyup', function() { // everytime keyup event
	$("#loaderIcon").show();
		jQuery.ajax({
		url: "check_availability.php",
		data:'username='+$("#username").val(),
		type: "POST",
			success:function(data){
			$("#user-availability-status").html(data);
			$("#loaderIcon").hide();
		},
		error:function (){}
		});
}

