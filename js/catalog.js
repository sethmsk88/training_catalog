$(document).ready(function() {

	// When a filter checkbox changes state
	$('table.filters input[type="checkbox"]').change(function() {
		
		var categoryIDs = "";
		var groupIDs = "";
		var courseTypes = "";

		// Get category IDs from checked checkboxes
		$('#filterCategory-form input[type="checkbox"]').each(function() {
			
			// If checkbox is checked, add its ID to the list
			if ($(this).prop('checked')) {
				if (categoryIDs.length > 0)
					categoryIDs += ",";
				
				categoryIDs += $(this).attr('id').split('-')[1];
			}
		});

		// Get group IDs from checked checkboxes
		$('#filterGroup-form input[type="checkbox"]').each(function() {
			
			// If checkbox is checked, add its ID to the list
			if ($(this).prop('checked')) {
				if (groupIDs.length > 0)
					groupIDs += ",";
				
				groupIDs += $(this).attr('id').split('-')[1];
			}
		});

		// Get course types from checked boxes
		$('#filterCourseType-form input[type="checkbox"]').each(function() {

			// If checkbox is checked, add its ID to the list
			if ($(this).prop('checked')) {
				if (courseTypes.length > 0)
					courseTypes += ",";

				// Convert course types to int Online values for database
				if ($(this).attr('id') == "online")
					courseTypes += "1";
				else if ($(this).attr('id') == "offline")
					courseTypes += "0";
			}
		});

		
		$.ajax({
			type: 'post',
			url: './content/act_filter_training_courses.php',
			dataType: 'json',
			cache: false,
			data: {
				'categoryIDs': categoryIDs,
				'groupIDs': groupIDs,
				'courseTypes': courseTypes
			},
			success: function(response) {
				$('#numCourses').text(response.numCourses);
				$('#training_courses_ajax').html(response.courseList);

			}
		});
	});

});
