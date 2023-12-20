<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $selected_month = $_POST['selected_month'];
    $star_date = $_POST['star_date'];
    $end_date = $_POST['end_date'];

    if (empty($event_name)) {
        $data['status'] = 'error';
        $data['message'] = 'Please enter the event name';
    } else if (empty($selected_month)) {
        $data['status'] = 'error';
        $data['message'] = 'Please select the event month';
    } else if (empty($star_date)) {
        $data['status'] = 'error';
        $data['message'] = 'Please specify the start date';
    } else {
        $insert_query = "UPDATE academic_calendar SET event_name ='$event_name', event_month ='$selected_month', event_start_date ='$star_date', event_end_date ='$end_date' WHERE event_id = '$event_id'";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $data['status'] = 'success';
            $data['message'] = 'Event updated successfully';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Unable to updated the event';
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>