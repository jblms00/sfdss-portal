<?php
session_start();

include("database-connection.php");
include("check-login.php");

$user_data = check_login($con);

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $student_number = $_POST['student_number'];
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_contact_number = $_POST['student_contact_number'];
    $student_year_graduated = $_POST['student_year_graduated'];
    $userAnswer = $_POST['userAnswer'];

    $checkedCredentials = [];
    if ($_POST['form137Checked'] === "true") {
        $checkedCredentials[] = "Form 137";
    }
    if ($_POST['goodMoralChecked'] === "true") {
        $checkedCredentials[] = "Good Moral";
    }
    if ($_POST['certificateEnrollmentChecked'] === "true") {
        $checkedCredentials[] = "Certificate of Enrollment";
    }
    if ($_POST['certificateGraduationChecked'] === "true") {
        $checkedCredentials[] = "Certificate of Graduation";
    }
    if ($_POST['secondDiplomaChecked'] === "true") {
        $checkedCredentials[] = "2nd Copy of Diploma";
    }

    $student_number_input = intval($student_number);
    $credentialsString = implode(', ', $checkedCredentials);

    if (empty($student_number) || empty($student_name) || empty($student_email) || empty($student_contact_number) || empty($userAnswer)) {
        $data['status'] = "error";
        $data['message'] = "Please fill in all required fields.";
    } else if (empty($checkedCredentials)) {
        $data['status'] = "error";
        $data['message'] = "Please select at least one credential.";
    } else if ($user_data['user_name'] !== $student_name) {
        $data['status'] = "error";
        $data['message'] = "Wrong student name";
    } else if ($user_data['user_id'] !== $student_number_input) {
        $data['status'] = "error";
        $data['message'] = "Wrong student number";
    } else if (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
        $data['status'] = "error";
        $data['message'] = "Invalid email format.";
    } else {
        $request_id = rand(10000000, 99999999);
        $insert_request_query = "INSERT INTO student_requested_credentials (request_id, student_number, student_name, student_email, student_contact_number, student_year_graduated, student_requested, student_purpose, request_status, requested_at) VALUES ('$request_id', '$student_number', '$student_name', '$student_email', '$student_contact_number', '$student_year_graduated', '$credentialsString', '$userAnswer', 'Pending', NOW())";
        $insert_request_result = mysqli_query($con, $insert_request_query);

        if ($insert_request_result) {
            $registrar_id_query = "SELECT user_id FROM users_accounts WHERE user_type = 'registrar'";
            $registrar_id_result = mysqli_query($con, $registrar_id_query);

            while ($registrar_row = mysqli_fetch_assoc($registrar_id_result)) {
                $registrar_id = $registrar_row['user_id'];

                $notification_id = rand(10000000, 99999999);
                $send_notif_query = "INSERT INTO user_notifications (notification_id, user_id, activity_type, activity_id, student_id, sent_at, is_read) VALUES ('$notification_id', '$registrar_id', 'request_credentials', '$request_id', '$student_number', NOW(), 'false')";
                $send_notif_result = mysqli_query($con, $send_notif_query);

                if (!$send_notif_result) {
                    $data['status'] = "error";
                    $data['message'] = "Failed to send notification";
                    break;
                }
            }

            $data['status'] = "success";
            $data['message'] = "Request submitted successfully!";
        } else {
            $data['status'] = "error";
            $data['message'] = "Failed to submit your request";
        }
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);
?>