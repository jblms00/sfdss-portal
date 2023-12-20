<?php
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $student_number = $_POST['student_number'];

    $ex_query = "SELECT * FROM student_exam_grade WHERE student_number = '$student_number'";
    $ex_result = mysqli_query($con, $ex_query);

    if ($ex_result && mysqli_num_rows($ex_result) > 0) {
        $data['status'] = "success";
        $data['data'] = [];

        while ($row = mysqli_fetch_assoc($ex_result)) {
            $data['data'][] = [
                'subject_quarter' => $row['subject_quarter'],
                'initial_grade' => $row['initial_grade'],
                'final_grade' => $row['quarterly_grade']
            ];
        }
    } else {
        $data['status'] = "error";
        $data['message'] = "Currently no grades to display";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);