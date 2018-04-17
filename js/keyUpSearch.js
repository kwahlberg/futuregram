
$(function() {
	$("#myTextField").on('keyup', function() { // everytime keyup event
		var input = $(this).val(); // We take the input value
		if ( input.length >= 2 ) { // Minimum characters = 2 (you can change)
			$('#match').html('<img src="design/loader-small.gif" />'); // Loader icon apprears in the <div id="match"></div>
			var dataFields = {'input': input}; // We pass input argument in Ajax
			$.ajax({
				type: "POST",
				url: "ajax/tuto-autocomplete.php", // call the php file ajax/tuto-autocomplete.php
				data: dataFields, // Send dataFields var
				timeout: 3000,
				success: function(dataBack){ // If success
					$('#match').html(dataBack); // Return data (UL list) and insert it in the <div id="match"></div>
					$('#matchList li').on('click', function() { // When click on an element in the list
						$('#myTextField').val($(this).text()); // Update the field with the new element
						$('#match').text(''); // Clear the <div id="match"></div>
					});
				},
				error: function() { // if error
					$('#match').text('Problem!');
				}
			});
		} else {
			$('#match').text(''); // If less than 2 characters, clear the <div id="match"></div>
		}
	});
});
</script>
 
