<link href="./css/catalog.css" rel="stylesheet">
<script src="./js/catalog.js"></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

// Get all categories
$sel_categories_sql = "
	SELECT *
	FROM hrodt.training_category
	ORDER BY CategoryName
";

// Get all groups
$sel_groups_sql = "
	SELECT *
	FROM hrodt.training_group
	ORDER BY GroupName
";

// Get all courses
$sel_courses_sql = "
	SELECT *
	FROM hrodt.training_course
	ORDER BY CourseName
";

// Prepare and execute select queries
$stmt = $conn->prepare($sel_categories_sql);
$stmt->execute();
$categories_result = $stmt->get_result();

$stmt = $conn->prepare($sel_groups_sql);
$stmt->execute();
$groups_result = $stmt->get_result();

$stmt = $conn->prepare($sel_courses_sql);
$stmt->execute();
$courses_result = $stmt->get_result();
$numCourses = $courses_result->num_rows;

?>

<div class="container">
	<div class="row">
		<div class="col-lg-2">
			<form
				name="filterCategory-form"
				id="filterCategory-form"
				role="form"
				method="post"
				action="">

				<h3>Category</h3>
				<table class="filters">
					<tbody>
					<?php
						// Create rows for each category
						while ($row = $categories_result->fetch_assoc()) {
					?>
						<tr>
							<td>
								<input
									id="category-<?= $row['ID'] ?>"
									type="checkbox">
							</td>
							<td>
								<label for="category-<?= $row['ID'] ?>"><?= $row['CategoryName'] ?></label>
							</td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</form>

			<div class="divider"></div>

			<form
				name="filterGroup-form"
				id="filterGroup-form"
				role="form"
				method="post"
				action="">

				<h3 style="margin-top:10px;">Group</h3>
				<table class="filters">
					<tbody>
					<?php
						// Create rows for each group
						while ($row = $groups_result->fetch_assoc()) {
					?>
						<tr>
							<td>
								<input
									id="group-<?= $row['ID'] ?>"
									type="checkbox">
							</td>
							<td>
								<label for="group-<?= $row['ID'] ?>"><?= $row['GroupName'] ?></label>
							</td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</form>
		</div>

		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-8">
					<h2>Training Courses</h2>
				</div>
				<div class="col-lg-4" style="text-align:right;">
					<h3><small><span id="numCourses"><?= $numCourses ?></span> results found</small></h3>
				</div>
			</div>
			<br />

			<div id="training_courses_ajax">
				<?php
					// Display all courses
					while ($row = $courses_result->fetch_assoc()) {
				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="course-container">
							<h4><?= $row['CourseName'] ?></h4>
							<?= $row['CourseDescr'] ?>
						</div>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
