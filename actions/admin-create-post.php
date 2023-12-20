<?php
session_start();

include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);
$admin_id = $user_data['user_id'];

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_description = mysqli_real_escape_string($con, $_POST['post_description']);

    if (!empty($post_description)) {
        $post_id = rand(10000000, 99999999);
        $user_posted_date = date('Y-m-d H:i:s');

        $insert_query = "INSERT INTO admin_posted_feed (post_id, admin_id, post_description, user_posted_date) VALUES ('$post_id','$admin_id','$post_description','$user_posted_date')";

        if (mysqli_query($con, $insert_query)) {
            $data["post_description"] = $post_description;
            $data["post_id"] = $post_id;
            $data["user_posted_date"] = getTimeAgo($user_posted_date);

            $data['status'] = 'success';
            $data['message'] = 'Post created successfully!';
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

function getTimeAgo($timestamp)
{
    $timeAgo = strtotime($timestamp);
    $currentTime = time();
    $timeDifference = $currentTime - $timeAgo;

    $seconds = $timeDifference;
    $minutes = round($timeDifference / 60);
    $hours = round($timeDifference / 3600);
    $days = round($timeDifference / 86400);
    $weeks = round($timeDifference / 604800);
    $months = round($timeDifference / 2419200);
    $years = round($timeDifference / 29030400);

    if ($seconds <= 60) {
        return "Just now";
    } elseif ($minutes <= 60) {
        return $minutes . " minutes ago";
    } elseif ($hours <= 24) {
        return $hours . " hours ago";
    } elseif ($days <= 7) {
        return $days . " days ago";
    } elseif ($weeks <= 4) {
        return $weeks . " weeks ago";
    } elseif ($months <= 12) {
        return $months . " months ago";
    } else {
        return $years . " years ago";
    }
}