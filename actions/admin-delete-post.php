<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];

    $delete_query = "DELETE FROM admin_posted_feed WHERE post_id = '$post_id'";
    if (mysqli_query($con, $delete_query)) {
        $data['status'] = 'success';
        $data['message'] = 'Post deleted successfully!';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to delete the post';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>