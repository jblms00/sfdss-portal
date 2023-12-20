<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $get_events_query = "SELECT * FROM academic_calendar";
    $get_events_result = mysqli_query($con, $get_events_query);

    if ($get_events_result) {
        $data['events_info'] = [];
        while ($fetch_information = mysqli_fetch_assoc($get_events_result)) {
            $data['events_info'][] = $fetch_information;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No events found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
?>