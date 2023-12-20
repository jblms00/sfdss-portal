<?php
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $year_level = $_POST['year_level'];
    $student_subject = $_POST['student_subject'];
    $student_section = $_POST['student_section'];
    $quarter = $_POST['quarter'];

    $subject_code = array_search($student_subject, mapSubjectName());
    $subject_quarter = $subject_code . "_" . $quarter;
    $subject_name = mapSubjectName($student_subject);

    $ww_query = "SELECT * FROM student_written_works_grade WHERE student_year = '$year_level' AND subject_quarter = '$subject_quarter' AND student_section = '$student_section' GROUP BY student_name ASC";
    $pt_query = "SELECT * FROM student_performance_tasks_grade WHERE student_year = '$year_level' AND subject_quarter = '$subject_quarter' AND student_section = '$student_section' GROUP BY student_name ASC";
    $ex_query = "SELECT * FROM student_exam_grade WHERE student_year = '$year_level' AND subject_quarter = '$subject_quarter' AND student_section = '$student_section' GROUP BY student_name ASC";

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
        $student_data['subject_quarter'] = $subject_quarter;
        $student_data['student_written_works'] = $ww_datas;
        $student_data['student_performance_tasks'] = $pt_datas;
        $student_data['student_exam'] = $ex_datas;

        $data['status'] = "success";
        $data['student_data'] = $student_data;
    } else {
        $data['status'] = "error";
        $data['message'] = "Failed to fetch data from the database.";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

if (empty($data['student_data'])) {
    $data['status'] = 'success';
    $data['student_data'] = [];
}

echo json_encode($data);

function mapSubjectName()
{
    return [
        "AP" => "Araling Panlipunan",
        "ARTS" => "Arts",
        "ENG" => "English",
        "ESP" => "Edukasyon sa Pagpapakatao (EsP)",
        "FIL" => "Filipino",
        "HEALTH" => "Health",
        "MATH" => "Math",
        "MUSIC" => "Music",
        "PE" => "Physical Education",
        "SCI" => "Science",
        "ORALCOMM" => "Oral Communication",
        "KPWKP" => "Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino",
        "GENMATH" => "General Mathematics",
        "ELS" => "Earth and Life Science",
        "PDEV" => "Personal Development",
        "UCSP" => "Understanding Culture, Society and Politics",
        "PEH" => "Physical Education and Health",
        "EAPP" => "English for Academic and Professional Purposes",
        "RDL1" => "Research in Daily Life 1",
    ];
}