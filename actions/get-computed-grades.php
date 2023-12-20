<?php
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $student_number = $_POST['student_number'];
    $quarter = $_POST['quarter'];
    $subject_quarter = "_Q" . $quarter;

    $ww_query = "SELECT * FROM student_written_works_grade WHERE student_number = '$student_number' AND subject_quarter LIKE '%$subject_quarter'";
    $pt_query = "SELECT * FROM student_performance_tasks_grade WHERE student_number = '$student_number' AND subject_quarter LIKE '%$subject_quarter'";
    $ex_query = "SELECT * FROM student_exam_grade WHERE student_number = '$student_number' AND subject_quarter LIKE '%$subject_quarter'";

    $ww_result = mysqli_query($con, $ww_query);
    $pt_result = mysqli_query($con, $pt_query);
    $ex_result = mysqli_query($con, $ex_query);

    if ($ww_result && $pt_result && $ex_result) {
        $student_data = [];
        $ww_datas = [];
        $pt_datas = [];
        $ex_datas = [];

        // Fetch data from each table
        while ($fetch_ww_data = mysqli_fetch_assoc($ww_result)) {
            $ww_datas[] = $fetch_ww_data;
        }

        while ($fetch_pt_data = mysqli_fetch_assoc($pt_result)) {
            $pt_datas[] = $fetch_pt_data;
        }

        while ($fetch_ex_data = mysqli_fetch_assoc($ex_result)) {
            $ex_datas[] = $fetch_ex_data;
        }

        // Organize the data
        $student_data['student_written_works'] = $ww_datas;
        $student_data['student_performance_tasks'] = $pt_datas;
        $student_data['student_exam'] = $ex_datas;

        $data['status'] = "success";
        $data['student_data'] = $student_data;
        $data['subject_quarter'] = $subject_quarter;
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to fetch data from the database.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

if (empty($data['student_data'])) {
    $data['status'] = 'error';
    $data['message'] = "Currently no grades to display";
    $data['student_data'] = [];
}

echo json_encode($data);