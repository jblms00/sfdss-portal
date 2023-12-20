<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $get_posts_query = "SELECT * FROM admin_posted_feed ORDER BY user_posted_date DESC";
    $get_posts_result = mysqli_query($con, $get_posts_query);

    if ($get_posts_result) {
        $data['posts'] = [];
        while ($fetch_posts = mysqli_fetch_assoc($get_posts_result)) {
            $fetch_posts['user_posted_date'] = getTimeAgo($fetch_posts['user_posted_date']);
            $data['posts'][] = $fetch_posts;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No posts found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
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