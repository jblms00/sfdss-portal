<?php
session_start();

include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $user_data['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($old_password)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your current password";
    } else if (empty($new_password)) {
        $data['status'] = "error";
        $data['message'] = "Please enter your new password";
    } else if (empty($confirm_password)) {
        $data['status'] = "error";
        $data['message'] = "Please confirm your new password";
    } else if ($user_id !== $user_data['user_id']) {
        $data['status'] = "error";
        $data['message'] = "User authentication failed: User ID does not match the logged-in user.";
    } else if ($old_password === $new_password) {
        $data["status"] = "error";
        $data["message"] = "Password unchanged: Please use a different password than your current one.";
    } else if ($new_password !== $confirm_password) {
        $data["status"] = "error";
        $data["message"] = "New password and confirm password do not match. Please make sure the passwords match.";
    } else if ($old_password !== base64_decode($user_data["user_password"])) {
        $data["status"] = "error";
        $data["message"] = "Old password does not match your current password.";
    } else if (strlen($new_password) < 8) {
        $data['status'] = "error";
        $data['message'] = "New password must be at least 8 characters long.";
    } else {
        $new_encoded_password = base64_encode($new_password);
        $update_query = "UPDATE users_accounts SET user_password = '$new_encoded_password' WHERE user_id = '$user_id' AND user_type = 'student'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            $data["status"] = "success";
            $data["message"] = "Password successfully updated.";
        } else {
            $data["status"] = "error";
            $data["message"] = "Password is not successfully updated.";
        }
    }

} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
?>