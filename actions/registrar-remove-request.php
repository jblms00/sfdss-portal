<?php
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_request'])) {
        $selected_request = $_POST['selected_request'];

        if (!empty($selected_request)) {
            if (is_array($selected_request)) {
                $selected_request_ids = implode(',', array_map('intval', $selected_request));
                $delete_request_query = "DELETE FROM student_requested_credentials WHERE request_id IN ($selected_request_ids)";
                $delete_notification_query = "DELETE FROM user_notifications WHERE activity_id IN ($selected_request_ids) AND activity_type = 'request_credentials'";
            } else {
                $single_request_id = intval($selected_request);
                $delete_request_query = "DELETE FROM student_requested_credentials WHERE request_id = $single_request_id";
                $delete_notification_query = "DELETE FROM user_notifications WHERE activity_id IN ($single_request_id) AND activity_type = 'request_credentials'";
            }

            $delete_request_result = mysqli_query($con, $delete_request_query);
            $delete_notification_result = mysqli_query($con, $delete_notification_query);

            if ($delete_request_result) {
                $data['status'] = 'success';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Failed to remove selected request(s).';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No selected request(s) to remove.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Invalid selected_request parameter.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>