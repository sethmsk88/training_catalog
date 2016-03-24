<?php
	// Connect to database
	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// Select all courses
	$sel_all_courses = "
		SELECT *
		FROM hrodt.training_course
		ORDER BY CourseName
	";

	// Select all categories
	$sel_all_categories = "
		SELECT *
		FROM hrodt.training_category
		ORDER BY CategoryName
	";

	// Insert course category
	/*$ins_course_category = "
		INSERT INTO training_course_has_category (Course_ID, Category_ID)
		VALUES (?,?)
	";*/

	// Prepare and run queries
	$stmt = $conn->prepare($sel_all_courses);
	$stmt->execute();
	$courses_result = $stmt->get_result();

	$stmt = $conn->prepare($sel_all_categories);
	$stmt->execute();
	$categories_result = $stmt->get_result();
?>

<!-- Include js file for this page -->
<script src="./js/catalog_admin.js"></script>

<div class="container">
	<div class="form-container">

		<div class="row">
			<div class="col-lg-12">
				<h4>Assign Category to Course</h4>
			</div>
		</div>

		<!-- Create form for giving courses categories -->
		<form
			name="assignCategoryToCourse-form"
			id="assignCategoryToCourse-form"
			role="form"
			method="post"
			action="">

			<div class="row">
				<div class="col-lg-5 form-group">
					<select id="course_1" class="form-control">
						<option value="none">Select a course</option>
						<?php
						while ($row = $courses_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['CourseName'] . '</option>';
						}
						?>
					</select>
				</div>

				<div class="col-lg-5 form-group">
					<select id="category" class="form-control">
						<option value="none">Select a category</option>
						<?php
						while ($row = $categories_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['CategoryName'] . '</option>';
						}
						?>
					</select>
				</div>

				<div class="col-lg-2 form-group">
					<button
						id="categoryCourse-submit-btn"
						type="button"
						class="btn btn-primary btn-fill">
						Submit
					</button>
				</div>
			</div>
		</form>
	</div>


	<!-- Create form for giving groups classes -->

</div>
