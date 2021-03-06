<?php
	// TEST LOGGED IN
	if (!isset($loggedIn) || !$loggedIn) {
		include './includes/inc_not_authorized.php';
		exit;
	}

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

	// Select all courses with categories
	$sel_all_courses_categories = "
		SELECT a.*, c.ID Category_ID, c.CategoryName
		FROM hrodt.training_course AS a
		JOIN hrodt.training_course_has_category AS b
			ON a.ID = b.Course_ID
		JOIN hrodt.training_category AS c
			ON b.Category_ID = c.ID
		ORDER BY a.CourseName
	";

	// Select all groups
	$sel_all_groups = "
		SELECT *
		FROM hrodt.training_group
		ORDER BY GroupName
	";

	// Select all groups with courses
	$sel_all_groups_courses = "
		SELECT a.*, c.ID Course_ID, c.CourseName
		FROM hrodt.training_group AS a
		JOIN hrodt.training_group_has_training_course AS b
			ON a.ID = b.Group_ID
		JOIN hrodt.training_course AS c
			ON b.Course_ID = c.ID
		ORDER BY a.GroupName
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

	$stmt = $conn->prepare($sel_all_groups);
	$stmt->execute();
	$groups_result = $stmt->get_result();

	$stmt = $conn->prepare($sel_all_groups_courses);
	$stmt->execute();
	$groups_courses_result = $stmt->get_result();
?>

<!-- Include js file for this page -->
<script src="./js/catalog_admin.js"></script>

<br />

<div class="container" style="padding-bottom:10em;">
	
	<div class="form-container">
		<div class="row">
			<div class="col-lg-12">
				<h4>Add Course</h4>
			</div>
		</div>

		<!-- Add Course Form -->
		<form
			name="addCourse-form"
			id="addCourse-form"
			role="form"
			method="post"
			action="">

			<!-- Course Code Input -->
			<div class="row">
				<div class="col-lg-4 form-group">
					<input
						name="courseCode"
						type="text"
						class="form-control"
						placeholder="Course Code">
				</div>
			</div>

			<!-- Course Name Input -->
			<div class="row">
				<div class="col-lg-12 form-group">
					<input
						name="courseName"
						type="text"
						class="form-control"
						placeholder="Course Name">
				</div>
			</div>

			<!-- Course Description Input -->
			<div class="row">
				<div class="col-lg-12 form-group">
					<textarea
						name="courseDescr"
						class="form-control"
						rows="8"
						placeholder="Course Description"></textarea>
				</div>
			</div>

			<!-- Online Select Box -->
			<div class="row">
				<div class="col-lg-4 form-group">
					<select name="online" class="form-control">
						<option value="">Course Type</option>
						<option value="0">Offline Course</option>
						<option value="1">Online Course</option>
					</select>
				</div>
			</div>

			<!-- Add Course Submit Button -->
			<div class="row">
				<div class="col-lg-2 form-group">
					<input
						type="submit"
						id="addCourse-submit-btn"
						class="btn btn-primary btn-fill"
						value="Submit">
				</div>
			</div>
		</form>

		<!-- To be filled with response from form submission -->
		<div class="row">
			<div class="col-lg-12">
				<div id="addCourse-response"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!-- Display all Courses -->
				<table class="table table-striped table-bordered data-table">
					<thead>
						<tr>
							<th>Course Code</th>
							<th>Course Name</th>
							<th>Course Type</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while ($row = $courses_result->fetch_assoc()) {
				?>
						<tr>
							<td><?= $row['CourseCode'] ?></td>
							<td><?= $row['CourseName'] ?></td>
							<td>
								<?php
									if ($row['Online'] == 1)
										echo '<span class="text-success">Online</span>';
									else
										echo '<span class="text-danger">Offline</span>';
								?>
							</td>
						</tr>
				<?php
				}
				$courses_result->data_seek(0); // Rewind result set pointer
				?>
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<br>
	<br>

	<div class="form-container">
		
		<!-- Assign Category to Course Form -->
		<div class="row">
			<div class="col-lg-12">
				<h4>Assign Category to Course</h4>
			</div>
		</div>

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
						$courses_result->data_seek(0); // Rewind result set pointer
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
				<table class="table table-striped table-bordered data-table">
					<thead>
						<tr>
							<th>Course</th>
							<th>Category</th>
						</tr>
					</thead>
					<tbody>
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
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<br>
	<br>

	<!-- Assign Course to Group Form -->
	<div class="form-container">

		<div class="row">
			<div class="col-lg-12">
				<h4>Assign Course to Group</h4>
			</div>
		</div>

		<!-- Create form for giving groups courses -->
		<form
			name="assignCourseToGroup-form"
			id="assignCourseToGroup-form"
			role="form"
			method="post"
			action="">

			<div class="row">
				<div class="col-lg-5 form-group">
					<select
						name="group"
						id="group"
						class="form-control">

						<option value="none">Select a group</option>
						<?php
						while ($row = $groups_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['GroupName'] . '</option>';
						}
						?>
					</select>
				</div>

				<div class="col-lg-5 form-group">
					<select
						name="course_2"
						id="course_2"
						class="form-control">

						<option value="none">Select a course</option>
						<?php
						while ($row = $courses_result->fetch_assoc()) {
							echo '<option value="' . $row['ID'] . '">' . $row['CourseName'] . '</option>';
						}
						$courses_result->data_seek(0); // Rewind result set pointer
						?>
					</select>
				</div>

				<div class="col-lg-2 form-group">
					<input
						type="submit"
						id="groupCourse-submit-btn"
						class="btn btn-primary btn-fill"
						value="Submit">
				</div>
			</div>
		</form>

		<!-- To be filled with response from form submission -->
		<div class="row">
			<div class="col-lg-8">
				<div id="assignCourseToGroup-response"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!-- Display all Category and Course associations -->
				<table class="table table-striped table-bordered data-table">
					<thead>
						<tr>
							<th>Group</th>
							<th>Course</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while ($row = $groups_courses_result->fetch_assoc()) {
				?>
					<tr>
						<td><?= $row['GroupName'] ?></td>
						<td><?= $row['CourseName'] ?></td>
					</tr>
				<?php
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
