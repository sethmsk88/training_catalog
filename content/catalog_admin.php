<?php
	// Connect to database
	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// Select all courses
	$sel_all_courses = "
		SELECT *
		FROM hrodt.training_course
		ORDER BY CourseName
	";

	// Select all courses with categories
	$sel_all_courses_categories = "
		SELECT a.*, c.ID Category_ID, c.CategoryName
		FROM hrodt.training_course AS a
		LEFT JOIN hrodt.training_course_has_category AS b
			ON a.ID = b.Course_ID
		JOIN hrodt.training_category AS c
			ON b.Category_ID = c.ID
		ORDER BY a.CourseName
	";

	// Select all categories
	$sel_all_categories = "
		SELECT *
		FROM hrodt.training_category
		ORDER BY CategoryName
	";

	// Prepare and run queries
	$stmt = $conn->prepare($sel_all_courses);
	$stmt->execute();
	$courses_result = $stmt->get_result();

	$stmt = $conn->prepare($sel_all_categories);
	$stmt->execute();
	$categories_result = $stmt->get_result();

	$stmt = $conn->prepare($sel_all_courses_categories);
	$stmt->execute();
	$courses_categories_result = $stmt->get_result();
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
					<select
						name="course_1"
						id="course_1"
						class="form-control">

						<option value="none">Select a course</option>
						<?php
						while ($row = $courses_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['CourseName'] . '</option>';
						}
						?>
					</select>
				</div>

				<div class="col-lg-5 form-group">
					<select
						name="category"
						id="category"
						class="form-control">

						<option value="none">Select a category</option>
						<?php
						while ($row = $categories_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['CategoryName'] . '</option>';
						}
						?>
					</select>
				</div>

				<div class="col-lg-2 form-group">
					<input
						type="submit"
						id="categoryCourse-submit-btn"
						class="btn btn-primary btn-fill"
						value="Submit">
				</div>
			</div>
		</form>

		<!-- To be filled with response from form submission -->
		<div class="row">
			<div class="col-lg-8">
				<div id="assignCategoryToCourse-response"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!-- Display all Category and Course associations -->
				<table class="table table-striped table-bordered">
					<tr>
						<th>Course Name</th>
						<th>Category</th>
					</tr>
				<?php
				while ($row = $courses_categories_result->fetch_assoc()) {
				?>
					<tr>
						<td><?= $row['CourseName'] ?></td>
						<td><?= $row['CategoryName'] ?></td>
					</tr>
				<?php
				}
				?>
				</table>
			</div>
		</div>
	</div>

	


	<!-- Create form for giving groups classes -->

</div>
