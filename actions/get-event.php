<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];
    $get_event_query = "SELECT * FROM academic_calendar WHERE event_id = '$event_id'";
    $get_event_result = mysqli_query($con, $get_event_query);

    if ($get_event_result) {
        $data['event_info'] = [];
        while ($fetch_information = mysqli_fetch_assoc($get_event_result)) {
            $data['event_info'][] = $fetch_information;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No event found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
?>