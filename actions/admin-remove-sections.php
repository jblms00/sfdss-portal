<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_sections']) && !empty($_POST['selected_sections'])) {
        $selected_sections = $_POST['selected_sections'];
        $year_level = $_POST['year_level'];
        $student_year_level = "Grade " . $year_level;

        // Escape and quote the section names
        $escaped_sections = array_map(function ($section) use ($con) {
            return "'" . mysqli_real_escape_string($con, $section) . "'";
        }, $selected_sections);

        $selected_sections_list = implode(',', $escaped_sections);

        $data['selected_sections_list'] = $selected_sections_list;
        $data['selected_sections'] = $selected_sections;
        $data['student_year_level'] = $student_year_level;

        $delete_section_query = "DELETE FROM users_accounts WHERE user_section IN ($selected_sections_list) AND user_year_level = '$student_year_level' AND user_type = 'student'";
        $delete_section_result = mysqli_query($con, $delete_section_query);

        if ($delete_section_result) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to remove selected sections.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No selected sections to remove.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>