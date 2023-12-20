<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $selected_month = $_POST['selected_month'];
    $star_date = $_POST['star_date'];
    $end_date = $_POST['end_date'];

    if (empty($event_name)) {
        $data['status'] = 'error';
        $data['message'] = 'Please add the event name';
    } else if (empty($selected_month)) {
        $data['status'] = 'error';
        $data['message'] = 'Please select the event month';
    } else if (empty($star_date)) {
        $data['status'] = 'error';
        $data['message'] = 'Please specify the start date';
    } else {
        $event_id = rand(10000000, 99999999);
        $insert_query = "INSERT INTO academic_calendar (event_id, event_name, event_month, event_start_date, event_end_date) VALUES ('$event_id' ,'$event_name' ,'$selected_month' ,'$star_date' ,'$end_date' )";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $data['status'] = 'success';
            $data['message'] = 'Event added successfully';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Unable to add the event';
        }
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>