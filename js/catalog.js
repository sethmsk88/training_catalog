$(document).ready(function() {

	// When a filter checkbox changes state
	$('table.filters input[type="checkbox"]').change(function() {
		
		var categoryIDs = "";
		var groupIDs = "";

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
		
		// var idParts = $(this).attr('id').split('-');
		// var filterType = idParts[0];
		// var filterID = idParts[1];

		// Each time a filter is changed, send states of all filters to action page so we can run a query

		$.ajax({
			type: 'post',
			url: './content/act_filter_training_courses.php',
			dataType: 'json',
			cache: false,
			data: {
				'categoryIDs': categoryIDs,
				'groupIDs': groupIDs
			},
			success: function(response) {
				//console.log(response.numCourses);
				$('#numCourses').text(response.numCourses);
				$('#training_courses_ajax').html(response.courseList);
			}
		});
	});

});
