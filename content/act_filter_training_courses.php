<?php
/***  CHECK IF PAGE WAS POSTED TO  ***/
if (!isset($_SERVER["REQUEST_METHOD"]) ||
	$_SERVER["REQUEST_METHOD"] != "POST") {
	exit;
}

// Connect to database
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

require_once "../includes/functions.php";

if (isset($_POST['categoryIDs'], $_POST['groupIDs'], $_POST['groupIDs'])) {

	$where = ""; // where clause for sel_courses query

	// If category IDs are present, build Category_ID part of where clause
	if (strlen($_POST['categoryIDs']) > 0) {
		$where .= "(";

		// Add category IDs to where clause
		foreach (explode(",", $_POST['categoryIDs']) as $i => $catID) {
			// If not first ID in array, append OR
			if ($i > 0)
				$where .= " OR ";

			$where .= "c.Category_ID = " . $catID;
		}
		$where .= ") ";
	}

	// If group IDs are present, build Group_ID part of where clause
	if (strlen($_POST['groupIDs']) > 0) {

		// If where clause has clauses preceding this one, append AND
		if (strlen($where) > 0)
			$where .= "AND ";

		$where .= "(";

		// Add category IDs to where clause
		foreach (explode(",", $_POST['groupIDs']) as $i => $groupID) {
			// If not first ID in array, append OR
			if ($i > 0)
				$where .= " OR ";

			$where .= "g.Group_ID = " . $groupID;
		}
		$where .= ") ";
	}

	// If course types are present, build Online part of where clause
	if (strlen($_POST['courseTypes']) > 0) {

		// If where clause has clauses preceding this one, append AND
		if (strlen($where) > 0)
			$where .= "AND ";

		$where .= "(";

		// Add Online to where clause
		foreach (explode(",", $_POST['courseTypes']) as $i => $courseType) {
			// If not first courseType in array, append OR
			if ($i > 0)
				$where .= " OR ";

			$where .= "t.Online = " . $courseType;
		}
		$where .= ")";
	}

	// If there were no where clauses, append always condition
	if (strlen($where) == 0)
		$where .= "1=1";

	// run query
	$sel_courses = "
		SELECT t.CourseCode, t.CourseName, t.CourseDescr, t.Online,
			c.Course_ID, c.Category_ID, g.Group_ID
		FROM hrodt.training_course AS t
		JOIN hrodt.training_course_has_category AS c
			ON t.ID = c.Course_ID
		JOIN hrodt.training_group_has_training_course AS g
			ON t.ID = g.Course_ID
		WHERE " . $where . "
		GROUP BY c.Course_ID
		ORDER BY t.CourseName
	";

	// Prepare and run query
	$stmt = $conn->prepare($sel_courses);
	$stmt->execute();
	$courses_result = $stmt->get_result();

	echo json_encode(array("courseList" => generateCourseList($courses_result),
		"numCourses" => $courses_result->num_rows));
}
?>
