<?php

include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_users']) && !empty($_POST['selected_users'])) {
        $selected_users = $_POST['selected_users'];
        $year_level = $_POST['year_level'];
        $student_year_level = "Grade " . $year_level;
        $selected_users_id = implode(',', array_map('intval', $selected_users));

        $delete_user_query = "DELETE FROM users_accounts WHERE user_id IN ($selected_users_id) AND user_year_level = '$student_year_level' AND user_type = 'student'";
        $delete_user_result = mysqli_query($con, $delete_user_query);

        if ($delete_user_result) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to remove selected students.';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No selected students to remove.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>