<?php
session_start();

include("database-connection.php");
include("check-login.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_number = $_POST['user_number'];
    $user_password = $_POST['user_password'];

    $get_users_query = "SELECT * FROM users_accounts WHERE user_id = '$user_number'";
    $get_users_result = mysqli_query($con, $get_users_query);
    $fetch_users = mysqli_fetch_assoc($get_users_result);

    if ($get_users_result && mysqli_num_rows($get_users_result) <= 0) {
        $data['status'] = "error";
        $data['message'] = "No user found";
    } else if (empty($user_number) && empty($user_password)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your student number and password";
    } else if (empty($user_password)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your password";
    } else if ($user_number != $fetch_users['user_id']) {
        $data['status'] = "error";
        $data['message'] = "Incorrect student number";
    } else if (base64_encode($user_password) != $fetch_users['user_password']) {
        $data['status'] = "error";
        $data['message'] = "Incorrect password";
    } else {
        $_SESSION['user_id'] = $user_number;
        $data['user_type'] = $fetch_users['user_type'];
        $data['status'] = "success";

        $update_status_query = "UPDATE users_accounts SET user_status = 'Online' WHERE user_id = '{$fetch_users['user_id']}'";
        mysqli_query($con, $update_status_query);
    }
}

echo json_encode($data);