<?php
function generateCourseList($courses_result) {

	$coursesList = "";

	// Display all courses
	while ($row = $courses_result->fetch_assoc()) {
		if ($row['Online'] == 1)
			$courseType = '<small class="course-online text-success">Online</small>';
		else
			$courseType = '<small class="course-offline text-danger">Offline</small>';

		$coursesList .= "<div class=\"row\">" .
			"<div class=\"col-lg-12\">" .
				"<div class=\"course-container\">" .
					"<h4>" . $row['CourseName'] . $courseType . "</h4>" .
					$row['CourseDescr'] .
				"</div>" .
			"</div>" .
		"</div>";
	}

	return $coursesList;
}
?>
