<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $year_level = $_POST['year_level'] ?? NULL;
    $student_year = "Grade " . $year_level;
    $get_section_query = "SELECT user_section FROM users_accounts WHERE user_year_level = '$student_year' AND user_type = 'student' GROUP BY user_section ASC";
    $get_section_result = mysqli_query($con, $get_section_query);

    if ($get_section_result) {
        $data['section_info'] = [];
        while ($fetch_information = mysqli_fetch_assoc($get_section_result)) {
            $data['section_info'][] = $fetch_information;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "section not found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);