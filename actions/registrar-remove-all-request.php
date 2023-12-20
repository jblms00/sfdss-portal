<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_request_query = "DELETE FROM student_requested_credentials";
    $delete_request_result = mysqli_query($con, $delete_request_query);

    if ($delete_request_result) {
        $delete_notification_query = "DELETE FROM user_notifications WHERE activity_type = 'request_credentials'";
        $delete_notification_result = mysqli_query($con, $delete_notification_query);

        $data['status'] = 'success';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to remove requests.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>