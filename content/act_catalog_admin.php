<?php
/***  CHECK IF PAGE WAS POSTED TO  ***/
if (!isset($_SERVER["REQUEST_METHOD"]) ||
	$_SERVER["REQUEST_METHOD"] != "POST") {
	exit;
}

// Connect to database
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

// If Add Course form was posted
if (isset($_POST['courseCode'], $_POST['courseName'], $_POST['courseDescr'],
	$_POST['online'])) {
	$param_str_CourseCode = $_POST['courseCode'];
	$param_str_CourseName = $_POST['courseName'];
	$param_str_CourseDescr = $_POST['courseDescr'];
	$param_int_Online = $_POST['online'];

	// Insert course
	$ins_course = "
		INSERT INTO hrodt.training_course (CourseCode, CourseName, CourseDescr, Online)
		VALUES (?,?,?,?)
	";

	// Insert course into table
	if (!$stmt = $conn->prepare($ins_course)) {
		echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
	} else if (!$stmt->bind_param('sssi',
		$param_str_CourseCode, $param_str_CourseName, $param_str_CourseDescr,
		$param_int_Online)) {
		echo 'Binding params failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else if (!$stmt->execute()) {
		echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else {
		$stmt->store_result();

		if ($stmt->affected_rows == 1) {
			echo '<div class="text-success">Course Added: ' . $param_str_CourseName . '</div>';
		}
	}
}

// If Assign Category To Course form was posted
else if (isset($_POST['course_1'], $_POST['category'])) {

	$param_int_Course_ID = $_POST['course_1'];
	$param_int_Category_ID = $_POST['category'];

	// Insert course category
	$ins_course_category = "
		INSERT INTO hrodt.training_course_has_category (Course_ID, Category_ID)
		VALUES (?,?)
	";

	// Insert course category pair into table
	if (!$stmt = $conn->prepare($ins_course_category)) {
		echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
	} else if (!$stmt->bind_param('ii',
		$param_int_Course_ID,
		$param_int_Category_ID)) {
		echo 'Binding params failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else if (!$stmt->execute()) {
		echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else {
		$stmt->store_result();

		if ($stmt->affected_rows == 1) {
			echo '<div class="text-success">Category Assigned to Course</div>';
		}
	}
}

// If Assign Category To Course form was posted
else if (isset($_POST['group'], $_POST['course_2'])) {

	$param_int_Group_ID = $_POST['group'];
	$param_int_Course_ID = $_POST['course_2'];

	// Insert group course
	$ins_group_course = "
		INSERT INTO hrodt.training_group_has_training_course (Group_ID, Course_ID)
		VALUES (?,?)
	";

	// Insert group course pair into table
	if (!$stmt = $conn->prepare($ins_group_course)) {
		echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
	} else if (!$stmt->bind_param('ii',
		$param_int_Group_ID,
		$param_int_Course_ID)) {
		echo 'Binding params failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else if (!$stmt->execute()) {
		echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
	} else {
		$stmt->store_result();

		if ($stmt->affected_rows == 1) {
			echo '<div class="text-success">Course Assigned to Group</div>';
		}
	}
}

// Else, no form was posted, or the correct fields were not present
else {
	// Display error message
	echo '<div class="text-danger">There was an error during submission</div>';
}

?>
