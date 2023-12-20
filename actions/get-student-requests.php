<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $get_request_query = "SELECT * FROM student_requested_credentials ORDER BY requested_at ASC";
    $get_request_result = mysqli_query($con, $get_request_query);

    if ($get_request_result) {
        $data['student_requests'] = [];
        while ($fetch_request = mysqli_fetch_assoc($get_request_result)) {
            $data['student_requests'][] = $fetch_request;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No request/s found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);