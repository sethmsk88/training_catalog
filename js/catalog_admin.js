$(document).ready(function() {

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
});
