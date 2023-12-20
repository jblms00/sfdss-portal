<?php
session_start();
include("database-connection.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $get_user_query = "SELECT * FROM users_accounts WHERE user_id = '$user_id'";
    $get_user_result = mysqli_query($con, $get_user_query);
    $fetch_user = mysqli_fetch_assoc($get_user_result);

    if ($fetch_user['user_type'] === 'student') {
        $update_status_query = "UPDATE users_accounts SET user_status = 'Offline' WHERE user_id = '$user_id'";
        $update_status_result = mysqli_query($con, $update_status_query);

        if ($update_status_result) {
            session_destroy();
            header("Location: /sfdss-portal/index.php");
            exit;
        }
    } else if ($fetch_user['user_type'] === 'registrar') {
        $update_admin_status_query = "UPDATE users_accounts SET user_status = 'Offline' WHERE user_id = '$user_id'";
        $update_admin_status_result = mysqli_query($con, $update_admin_status_query);

        if ($update_admin_status_result) {
            session_destroy();
            header("Location: /sfdss-portal/index.php");
            exit;
        }
    } else if ($fetch_user['user_type'] === 'admin') {
        $update_admin_status_query = "UPDATE users_accounts SET user_status = 'Offline' WHERE user_id = '$user_id'";
        $update_admin_status_result = mysqli_query($con, $update_admin_status_query);

        if ($update_admin_status_result) {
            session_destroy();
            header("Location: /sfdss-portal/index.php");
            exit;
        }
    }
}
?>