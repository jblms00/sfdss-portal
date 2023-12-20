<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $get_post_query = "SELECT * FROM admin_posted_feed WHERE post_id = '$post_id'";
    $get_post_result = mysqli_query($con, $get_post_query);

    if ($get_post_result) {
        $data['event_info'] = [];
        while ($fetch_post = mysqli_fetch_assoc($get_post_result)) {
            $data['post'][] = $fetch_post;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No post found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
?>