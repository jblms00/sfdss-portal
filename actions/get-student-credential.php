<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $student_number = $_POST['student_number'];
    $request_id = $_POST['request_id'];

    $get_student_query = "SELECT * FROM student_requested_credentials WHERE student_number = '$student_number' AND request_id = '$request_id'";
    $get_student_result = mysqli_query($con, $get_student_query);

    if ($get_student_query && mysqli_num_rows($get_student_result) > 0) {
        $data['student_info'] = [];
        while ($fetch_information = mysqli_fetch_assoc($get_student_result)) {
            $data['student_info'][] = $fetch_information;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "Student not found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);