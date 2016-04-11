$(document).ready(function() {

	$('#addCourse-form').submit(function(e) {
		e.preventDefault();
		$form = $(this);

		$.ajax({
			type: 'post',
			url: './content/act_catalog_admin.php',
			data: $form.serialize(),
			success: function(response) {
				$('#addCourse-response').html(response);
			}
		});
	});

	$('#assignCategoryToCourse-form').submit(function(e) {
		e.preventDefault();
		$form = $(this);

		$.ajax({
			type: 'post',
			url: './content/act_catalog_admin.php',
			data: $form.serialize(),
			success: function(response) {
				$('#assignCategoryToCourse-response').html(response);
			}
		});
	});

	$('#assignCourseToGroup-form').submit(function(e) {
		e.preventDefault();
		$form = $(this);

		$.ajax({
			type: 'post',
			url: './content/act_catalog_admin.php',
			data: $form.serialize(),
			success: function(response) {
				$('#assignCourseToGroup-response').html(response);
			}
		});
	});

	$('table.data-table').DataTable();
});
