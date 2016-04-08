<?php
function generateCourseList($courses_result) {

	$coursesList = "";

	// Display all courses
	while ($row = $courses_result->fetch_assoc()) {
		$coursesList .= "<div class=\"row\">";
		$coursesList .= "<div class=\"col-lg-12\">";
		$coursesList .= "<div class=\"course-container\">";
		$coursesList .= "<h4>" . $row['CourseName'] . "</h4>";
		$coursesList .= $row['CourseDescr'];
		$coursesList .= "</div>";
		$coursesList .= "</div>";
		$coursesList .= "</div>";
	}

	return $coursesList;
}
?>
