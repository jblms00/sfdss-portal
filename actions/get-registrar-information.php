<?php
session_start();

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $registrar_id = $_POST['registrar_id'];

    $get_registrar_query = "SELECT * FROM users_accounts WHERE user_id = '$registrar_id' AND user_type = 'registrar'";
    $get_registrar_result = mysqli_query($con, $get_registrar_query);

    if ($get_registrar_result && mysqli_num_rows($get_registrar_result) > 0) {
        $data['registrar_info'] = [];
        while ($fetch_information = mysqli_fetch_assoc($get_registrar_result)) {
            $data['registrar_info'][] = $fetch_information;
        }
        $data['status'] = 'success';
    } else {
        $data['status'] = "error";
        $data['message'] = "No registrar found";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);