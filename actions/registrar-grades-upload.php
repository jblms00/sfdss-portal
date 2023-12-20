<?php
include("../actions/database-connection.php");
require '../vendor/autoload.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['excelFile']['tmp_name'];
        $fileName = $_FILES['excelFile']['name'];

        // Remove the file extension
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

        $fileParts = explode('-', $fileNameWithoutExtension);
        $fileSubject = $fileParts[0];
        $fileGradeYear = $fileParts[1];
        $fileSection = $fileParts[2];

        $yearLevel = $_POST['yearLevel'];
        $student_year_level = "Grade " . $yearLevel;
        $student_section = $_POST['studentsSection'];
        $student_subject = $_POST['studentSubject'];

        // Check the file type
        $allowedFileTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        $fileMimeType = mime_content_type($uploadedFile);

        if (!in_array($fileMimeType, $allowedFileTypes)) {
            $data['status'] = "error";
            $data['message'] = "Unsupported file type. Please upload an Excel file.";
        } else {
            // Load the Excel file using PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile);
            $studentData = [];
            $studentNames = [];
            $studentNumbers = [];

            // Loop through all four quarters (Q1, Q2, Q3, Q4)
            for ($quarterIndex = 0; $quarterIndex <= 3; $quarterIndex++) {
                $worksheet = $spreadsheet->getSheet($quarterIndex);
                $pageName = $worksheet->getTitle();
                list($subjectName, $quarter) = explode("_", $pageName);
                $studentData = [];

                // Iterate through rows starting from row 4
                foreach ($worksheet->getRowIterator(5) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Include empty cells
                    $rowData = [];

                    // Check if the row is entirely null or empty
                    $isEmptyRow = true;

                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();

                        // If any cell in the row is not null or empty, mark the row as not empty
                        if (!empty($cell->getValue())) {
                            $isEmptyRow = false;
                        }
                    }

                    // Skip rows that are entirely null or empty
                    if ($isEmptyRow) {
                        continue;
                    }

                    // Check if the row is a gender label ("MALE" or "FEMALE")
                    if (count($rowData) === 1 && in_array($rowData[0], ["MALE", "FEMALE"])) {
                        continue; // Skip gender labels
                    }

                    $subjectName = mapSubjectName($student_subject);
                    $studentData[] = [
                        'name' => $rowData[0],
                        // Written Works
                        'ww_grades' => array_slice($rowData, 4, 10),
                        'ww_total' => $worksheet->getCellByColumnAndRow(15, $row->getRowIndex())->getCalculatedValue(),
                        'ww_pw' => $worksheet->getCellByColumnAndRow(15, $row->getRowIndex())->getCalculatedValue(),
                        'ww_ws' => $worksheet->getCellByColumnAndRow(16, $row->getRowIndex())->getCalculatedValue(),
                        // Performance Tasks
                        'pt_grades' => array_slice($rowData, 17, 10),
                        'pt_total' => $worksheet->getCellByColumnAndRow(28, $row->getRowIndex())->getCalculatedValue(),
                        'pt_pw' => $worksheet->getCellByColumnAndRow(28, $row->getRowIndex())->getCalculatedValue(),
                        'pt_ws' => $worksheet->getCellByColumnAndRow(29, $row->getRowIndex())->getCalculatedValue(),
                        // Exam and Quarterly Grade
                        'exam' => $rowData[30],
                        'ex_ps' => $worksheet->getCellByColumnAndRow(31, $row->getRowIndex())->getCalculatedValue(),
                        'ex_ws' => $worksheet->getCellByColumnAndRow(32, $row->getRowIndex())->getCalculatedValue(),
                        'initial_grade' => $worksheet->getCellByColumnAndRow(33, $row->getRowIndex())->getCalculatedValue(),
                        'quarterly_grade' => $worksheet->getCellByColumnAndRow(34, $row->getRowIndex())->getCalculatedValue(),
                    ];
                }

                foreach ($studentData as $student) {
                    $student_name = $student['name'];
                    $studentNames[] = $student_name;

                    // Check if the student name is not empty or null
                    if (!empty($student_name)) {
                        $get_data_query = "SELECT user_id, user_year_level, user_section FROM users_accounts WHERE user_name = '$student_name'";
                        $get_data_result = mysqli_query($con, $get_data_query);

                        if ($get_data_result) {
                            $fetch_data = mysqli_fetch_assoc($get_data_result);

                            if ($fetch_data !== null) {
                                $student_number = $fetch_data['user_id'];
                                $studentNumbers[] = $student_number;

                                if ($fileSubject !== mapSubjectName($student_subject)) {
                                    $data['status'] = "error";
                                    $data['message'] = "Incorrect file upload";
                                } else if ($fileGradeYear !== $yearLevel && $yearLevel !== $fileGradeYear) {
                                    $data['status'] = "error";
                                    $data['message'] = "Incorrect file upload. Please ensure it corresponds to " . $fetch_data['user_year_level'] . ", " . $fetch_data['user_section'];
                                } else if ($student_year_level !== $fetch_data['user_year_level'] && $student_section !== $fetch_data['user_section']) {
                                    $data['status'] = "error";
                                    $data['message'] = "Incorrect file upload. Please ensure it corresponds to " . $fetch_data['user_year_level'] . ", " . $fetch_data['user_section'];
                                } else {
                                    // Check if a record with the same student information exists in student_written_works_grade
                                    $check_ww_query = "SELECT * FROM student_written_works_grade WHERE student_number = '$student_number' AND student_name = '$student_name' AND student_year = '$student_year_level' AND subject_quarter = '$pageName'";
                                    $check_ww_result = mysqli_query($con, $check_ww_query);

                                    if (mysqli_num_rows($check_ww_result) > 0) {
                                        // If a record exists, update it
                                        $update_ww_query = "UPDATE student_written_works_grade SET student_section = '$student_section', student_year = '$student_year_level', w1 = '{$student['ww_grades'][0]}', w2 = '{$student['ww_grades'][1]}', w3 = '{$student['ww_grades'][2]}', w4 = '{$student['ww_grades'][3]}', w5 = '{$student['ww_grades'][4]}', w6 = '{$student['ww_grades'][5]}', w7 = '{$student['ww_grades'][6]}', w8 = '{$student['ww_grades'][7]}', w9 = '{$student['ww_grades'][8]}', w10 = '{$student['ww_grades'][9]}', total = '{$student['ww_total']}', pw = '{$student['ww_pw']}', ws = '{$student['ww_ws']}' WHERE student_number = '$student_number' AND subject_quarter = '$pageName'";
                                        $update_ww_result = mysqli_query($con, $update_ww_query);

                                        if ($update_ww_result) {
                                            // Set status to "success" only when the update is successful
                                            $data['status'] = "success";
                                            $data['message'] = "Student data updated successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            // Set status to "error" if the update fails
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to update the grades";
                                        }
                                    } else {
                                        // If no record exists, insert a new one
                                        $insert_ww_query = "INSERT INTO student_written_works_grade (student_number, student_name, student_section, student_year, subject_quarter, w1, w2, w3, w4, w5, w6, w7, w8, w9, w10, total, pw, ws) VALUES ('$student_number', '$student_name', '$student_section', '$student_year_level', '$pageName', '{$student['ww_grades'][0]}', '{$student['ww_grades'][1]}', '{$student['ww_grades'][2]}', '{$student['ww_grades'][3]}', '{$student['ww_grades'][4]}', '{$student['ww_grades'][5]}', '{$student['ww_grades'][6]}', '{$student['ww_grades'][7]}', '{$student['ww_grades'][8]}', '{$student['ww_grades'][9]}', '{$student['ww_total']}', '{$student['ww_pw']}', '{$student['ww_ws']}')";
                                        $insert_ww_result = mysqli_query($con, $insert_ww_query);

                                        if ($insert_ww_result) {
                                            // Set status to "success" only when the insert is successful
                                            $data['status'] = "success";
                                            $data['message'] = "Student data inserted successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            // Set status to "error" if the insert fails
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to insert the grades";
                                        }
                                    }

                                    // Check if a record with the same student information exists in student_performance_tasks_grade
                                    $check_pt_query = "SELECT * FROM student_performance_tasks_grade WHERE student_number = '$student_number' AND student_name = '$student_name' AND student_year = '$student_year_level' AND subject_quarter = '$pageName'";
                                    $check_pt_result = mysqli_query($con, $check_pt_query);

                                    if (mysqli_num_rows($check_pt_result) > 0) {
                                        // If a record exists, update it
                                        $update_pt_query = "UPDATE student_performance_tasks_grade SET student_section = '$student_section', student_year = '$student_year_level', p1 = '{$student['pt_grades'][0]}', p2 = '{$student['pt_grades'][1]}', p3 = '{$student['pt_grades'][2]}', p4 = '{$student['pt_grades'][3]}', p5 = '{$student['pt_grades'][4]}', p6 = '{$student['pt_grades'][5]}', p7 = '{$student['pt_grades'][6]}', p8 = '{$student['pt_grades'][7]}', p9 = '{$student['pt_grades'][8]}', p10 = '{$student['pt_grades'][9]}', total = '{$student['pt_total']}', pw = '{$student['pt_pw']}', ws = '{$student['pt_ws']}' WHERE student_number = '$student_number' AND subject_quarter = '$pageName'";
                                        $update_pt_result = mysqli_query($con, $update_pt_query);

                                        if ($update_pt_result) {
                                            // Set status to "success" only when the update is successful
                                            $data['status'] = "success";
                                            $data['message'] = "Student data updated successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            // Set status to "error" if the update fails
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to update the grades";
                                        }
                                    } else {
                                        // If no record exists, insert a new one
                                        $insert_pt_query = "INSERT INTO student_performance_tasks_grade (student_number, student_name, student_section, student_year, subject_quarter, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, total, pw, ws) VALUES ('$student_number', '$student_name', '$student_section', '$student_year_level', '$pageName', '{$student['pt_grades'][0]}', '{$student['pt_grades'][1]}', '{$student['pt_grades'][2]}', '{$student['pt_grades'][3]}', '{$student['pt_grades'][4]}', '{$student['pt_grades'][5]}', '{$student['pt_grades'][6]}', '{$student['pt_grades'][7]}', '{$student['pt_grades'][8]}', '{$student['pt_grades'][9]}', '{$student['pt_total']}', '{$student['pt_pw']}', '{$student['pt_ws']}')";
                                        $insert_pt_result = mysqli_query($con, $insert_pt_query);

                                        if ($insert_pt_result) {
                                            $data['status'] = "success";
                                            $data['message'] = "Student data inserted successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to insert the grades";
                                        }
                                    }

                                    // Check if a record with the same student information exists in student_exam_grade
                                    $check_ex_query = "SELECT * FROM student_exam_grade WHERE student_number = '$student_number' AND student_name = '$student_name' AND student_year = '$student_year_level' AND subject_quarter = '$pageName'";
                                    $check_ex_result = mysqli_query($con, $check_ex_query);

                                    if (mysqli_num_rows($check_ex_result) > 0) {
                                        // If a record exists, update it
                                        $update_ex_query = "UPDATE student_exam_grade SET student_section = '$student_section', student_year = '$student_year_level', exam_score = '{$student['exam']}', pw = '{$student['ex_ps']}', ws = '{$student['ex_ws']}', initial_grade = '{$student['initial_grade']}', quarterly_grade = '{$student['quarterly_grade']}' WHERE  student_number = '$student_number' AND subject_quarter = '$pageName'";
                                        $update_ex_result = mysqli_query($con, $update_ex_query);

                                        if ($update_ex_result) {
                                            // Set status to "success" only when the update is successful
                                            $data['status'] = "success";
                                            $data['message'] = "Student data updated successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            // Set status to "error" if the update fails
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to update the grades";
                                        }
                                    } else {
                                        // If no record exists, insert a new one
                                        $insert_ex_query = "INSERT INTO student_exam_grade (student_number, student_name, student_section, student_year, subject_quarter, exam_score, pw, ws, initial_grade, quarterly_grade) VALUES ('$student_number', '$student_name', '$student_section', '$student_year_level', '$pageName', '{$student['exam']}', '{$student['ex_ps']}', '{$student['ex_ws']}', '{$student['initial_grade']}', '{$student['quarterly_grade']}')";
                                        $insert_ex_result = mysqli_query($con, $insert_ex_query);

                                        if ($insert_ex_result) {
                                            // Set status to "success" only when the insert is successful
                                            $data['status'] = "success";
                                            $data['message'] = "Student data inserted successfully!";
                                            $data['studentData'] = $studentData;
                                        } else {
                                            // Set status to "error" if the insert fails
                                            $data['status'] = "error";
                                            $data['message'] = "Failed to insert the grades";
                                        }
                                    }
                                }
                            } else {
                                $data['status'] = "error";
                                $data['message'] = "Student name not found in the database";
                            }
                        } else {
                            $data['status'] = "error";
                            $data['message'] = "SQL query error";
                        }
                    }
                }
            }

            // // Check for and insert missing quarters if needed
            // for ($quarterIndex = 0; $quarterIndex <= 3; $quarterIndex++) {
            //     $quarterName = "Q" . $quarterIndex;
            //     $quarterExists = false;

            //     foreach ($studentData as $student) {
            //         if ($pageName === $quarterName) {
            //             $quarterExists = true;
            //             break;
            //         }
            //     }

            //     if ($student_year_level !== $fetch_data['user_year_level'] && $student_section !== $fetch_data['user_section']) {
            //         $data['status'] = "error";
            //         $data['message'] = "Incorrect file upload. Please ensure it corresponds to " . $fetch_data['user_year_level'] . ", " . $fetch_data['user_section'];
            //     } else if ($student_subject !== strtoupper($subjectName)) {
            //         $data['status'] = "error";
            //         $data['message'] = "Wrong excel file to upload for the subject: $subjectName. Please check the file and try again.";
            //     } else {
            //         if (!$quarterExists) {
            //             // Insert empty records for the missing quarter
            //             $insertMissingQuarterQuery = "INSERT INTO student_written_works_grade (student_number, student_name, student_section, student_year, subject_quarter, w1, w2, w3, w4, w5, w6, w7, w8, w9, w10, total, pw, ws) VALUES ('$student_number', '', '', '', '$quarterName', '', '', '', '', '', '', '', '', '', '', '', '', '')";
            //             $insertMissingQuarterResult = mysqli_query($con, $insertMissingQuarterQuery);

            //             if ($insertMissingQuarterResult) {
            //                 // Set status to "success" if the insert is successful
            //                 $data['status'] = "success";
            //                 $data['message'] = "Inserted empty records for missing quarters.";
            //             } else {
            //                 // Set status to "error" if the insert fails
            //                 $data['status'] = "error";
            //                 $data['message'] = "Failed to insert empty records for missing quarters.";
            //             }
            //         }
            //     }


            // }

        }
    } else {
        $data['status'] = "error";
        $data['message'] = "Please upload a file";
    }
} else {
    $data['status'] = "error";
    $data['message'] = "Invalid request method";
}

echo json_encode($data);

// Function to map subject codes to subject names
function mapSubjectName($subjectCode)
{
    $subjectMapping = [
        // Grade 7 to 10
        "AP" => "Araling Panlipunan",
        "Araling Panlipunan" => "AP",
        "ARTS" => "Arts",
        "Arts" => "ARTS",
        "ENG" => "English",
        "English" => "ENG",
        "ESP" => "Edukasyon sa Pagpapakatao (EsP)",
        "Edukasyon sa Pagpapakatao (EsP)" => "ESP",
        "FIL" => "Filipino",
        "Filipino" => "FIL",
        "HEALTH" => "Health",
        "Health" => "HEALTH",
        "MATH" => "Math",
        "Math" => "MATH",
        "MUSIC" => "Music",
        "Music" => "MUSIC",
        "PE" => "Physical Education",
        "Physical Education" => "PE",
        "SCI" => "Science",
        "Science" => "SCI",
        // Grade 11 - 1st Sem - ABM
        "ORALCOMM" => "Oral Communication",
        "Oral Communication" => "ORALCOMM",
        "KPWKP" => "Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino",
        "Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino" => "KPWKP",
        "GENMATH" => "General Mathematics",
        "General Mathematics" => "GENMATH",
        "ELS" => "Earth and Life Science",
        "Earth and Life Science" => "ELS",
        "PDEV" => "Personal Development",
        "Personal Development" => "PDEV",
        "UCSP" => "Understanding Culture, Society and Politics",
        "Understanding Culture, Society and Politics" => "UCSP",
        "PEH" => "Physical Education and Health",
        "Physical Education and Health" => "PEH",
        "EAPP" => "English for Academic and Professional Purposes",
        "English for Academic and Professional Purposes" => "EAPP",
        "RDL1" => "Research in Daily Life 1",
        "Research in Daily Life 1" => "RDL1",
    ];

    return isset($subjectMapping[$subjectCode]) ? $subjectMapping[$subjectCode] : null;
}
?>