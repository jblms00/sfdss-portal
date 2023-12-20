<?php
session_start();
include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);
$registrar_id = $user_data['user_id'];

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = $_POST['student_number'];
    $request_id = $_POST['request_id'];
    $selected_value = $_POST['selected_value'];
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);

    $check_request_query = "SELECT * FROM student_requested_credentials WHERE request_id = '$request_id' AND student_number = '$student_number'";
    $check_request_result = mysqli_query($con, $check_request_query);

    if ($check_request_result && mysqli_num_rows($check_request_result) > 0) {

        if ($selected_value !== 'Select status') {
            $update_query = "UPDATE student_requested_credentials SET request_status = '$selected_value' WHERE request_id = '$request_id' AND student_number = '$student_number'";
            $update_result = mysqli_query($con, $update_query);

            if ($update_result) {
                if ($selected_value === 'Done') {
                    $notification_id = rand(10000000, 99999999);
                    $send_notif_query = "INSERT INTO user_notifications (notification_id, user_id, activity_type, activity_id, student_id, registrar_remarks, sent_at, is_read) VALUES ('$notification_id', '$student_number', 'approved_request', '$request_id', '$registrar_id', '$remarks', NOW(), 'false')";
                    $send_notif_result = mysqli_query($con, $send_notif_query);
                }
                $data['status'] = 'success';
                $data['message'] = 'Successfully updated!';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Error updating credential status';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Please select status';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No credentials request found';
    }

} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>