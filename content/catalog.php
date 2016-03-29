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

?>

<div class="container">
	<div class="row">
		<div class="col-lg-2">
			<h3>Category</h3>
			<ul class="list-unstyled">
				<?php
					// Create list items for each category
					while ($row = $categories_result->fetch_assoc()) {
				?>
					<li><?= $row['CategoryName'] ?></li>
				<?php
					}
				?>
			</ul>

			<h3>Group</h3>
			<ul class="list-unstyled">
				<?php
					// Create list items for each gruop
					while ($row = $groups_result->fetch_assoc()) {
				?>
					<li><?= $row['GroupName'] ?></li>
				<?php
					}
				?>
			</ul>
		</div>
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-12">
					<h3>Training Courses</h3>
				</div>
			</div>
			<?php
				// Display all courses
			?>
			<div class="row">
				<div class="col-lg-12">
					<h4>Course 1</h4>
					Course description......
				</div>
			</div>
		</div>
	</div>
</div>
