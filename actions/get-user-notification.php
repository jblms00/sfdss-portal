<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_POST['user_id'];

    $get_notification_query = "SELECT * FROM `user_notifications` WHERE user_id = '$user_id'";
    $get_notification_result = mysqli_query($con, $get_notification_query);
    $notifications = [];

    if ($get_notification_result && mysqli_num_rows($get_notification_result) > 0) {
        while ($notification_row = mysqli_fetch_assoc($get_notification_result)) {
            $notification = [
                'notification_id' => $notification_row['notification_id'],
                'activity_type' => $notification_row['activity_type'],
                'activity_id' => $notification_row['activity_id'],
                'remarks' => $notification_row['registrar_remarks'],
                'student_number' => $notification_row['student_id'],
                'sent_at' => getTimeAgo($notification_row['sent_at']),
                'is_read' => $notification_row['is_read'],
            ];

            $student_number = $notification_row['student_id'];
            $get_user = "SELECT * FROM users_accounts WHERE user_id = '$student_number'";
            $get_user_result = mysqli_query($con, $get_user);
            $users_information = [];

            if ($get_user_result && mysqli_num_rows($get_user_result) > 0) {
                while ($fetch_user = mysqli_fetch_assoc($get_user_result)) {
                    $user_information = [
                        'student_name' => $fetch_user['user_name'],
                        'user_photo' => $fetch_user['user_photo'],
                    ];
                    array_push($users_information, $user_information);
                }
            }

            if (!empty($users_information)) {
                $notification['user_information'] = $users_information[0];
            } else {
                $notification['user_information'] = null; // Set to null or handle empty case as needed
            }

            array_push($notifications, $notification);
        }

        $data['status'] = "success";
        $data['notifications'] = $notifications;
    } else {
        $data['status'] = "error";
        $data['message'] = "Currently, there are no notifications.";
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