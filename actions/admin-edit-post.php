<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $post_description = mysqli_real_escape_string($con, $_POST['post_description']);

    if (!empty($post_description)) {
        $update_query = "UPDATE admin_posted_feed SET post_description = '$post_description' WHERE post_id = '$post_id'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            $data['status'] = 'success';
            $data['message'] = 'Post updated successfully!';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to update the post.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Please add description on your post';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>