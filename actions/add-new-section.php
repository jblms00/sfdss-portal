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
        $fileClass = $fileParts[0];
        $fileGrade = $fileParts[1];
        $fileYearLevel = $fileParts[2];
        $fileSection = $fileParts[3];
        $gradeLevel = "Grade " . $fileYearLevel;

        $inputSection = $_POST['section_name'];
        $page_year_level = $_POST['year_level'];

        // Check the file type
        $allowedFileTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        $fileMimeType = mime_content_type($uploadedFile);

        if (!in_array($fileMimeType, $allowedFileTypes)) {
            $data['status'] = "error";
            $data['message'] = "Unsupported file type. Please upload an Excel file.";
        } else {
            // Load the Excel file using PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile);
            $worksheet = $spreadsheet->getActiveSheet();
            $pageName = $worksheet->getTitle();
            list($gradeYearLevel, $classSection) = explode("-", $pageName);

            $studentData = [];
            // Iterate through rows starting from row 3
            foreach ($worksheet->getRowIterator(4) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
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

                $studentData[] = [
                    'student_name' => $rowData[2],
                    'student_number' => $rowData[0],
                ];
            }

            foreach ($studentData as $student) {
                $student_name = $student['student_name'];
                $student_number = $student['student_number'];
                $studentNames[] = $student_name;

                if (!empty($student_name)) {
                    $get_data_query = "SELECT user_id, user_year_level, user_section FROM users_accounts WHERE user_id = '$student_number'";
                    $get_data_result = mysqli_query($con, $get_data_query);

                    if ($get_data_result) {
                        $fetch_data = mysqli_fetch_assoc($get_data_result);
                        if ($fetch_data !== null) {
                            $existing_student_number = (int) $fetch_data['user_id'];

                            if (empty($inputSection)) {
                                $data['status'] = "error";
                                $data['message'] = "Please enter the new section name.";
                            } else if ($inputSection === $fetch_data['user_section']) {
                                $data['status'] = "error";
                                $data['message'] = $inputSection . " in " . $gradeLevel . " already exists.";
                            } else if ($classSection !== $fileSection && $fetch_data['user_year_level'] === $gradeLevel) {
                                $data['status'] = "error";
                                $data['message'] = "The spreadsheet name does not match the section name or the grade year level.";
                            } else if ($student_number === $existing_student_number) {
                                $data['status'] = "error";
                                $data['message'] = "Student number with '$student_number' is already exists.";
                            } else if ($page_year_level !== $gradeYearLevel && $page_year_level !== $fileYearLevel) {
                                $data['status'] = "error";
                                $data['message'] = "Invalid file upload. The uploaded file's grade year level does not match the expected value. ";
                            } else {
                                $last_name = substr($student_name, -3);
                                // Extract the last 4 digits of the student number
                                $last_digits = substr($student_number, -5);
                                // Combine the last name and last digits to create the password
                                $user_password = base64_encode(strtoupper($last_name) . $last_digits);

                                $update_query = "UPDATE `users_accounts` SET `user_name`='$student_name', `user_year_level`='$gradeLevel', `user_section`='$inputSection' ,`user_password`='$user_password' WHERE `user_id`='$student_number'";
                                $update_result = mysqli_query($con, $update_query);

                                if ($update_result) {
                                    $data['status'] = "success";
                                    $data['message'] = "Successfully updated the existing section.";
                                } else {
                                    $data['status'] = "error";
                                    $data['message'] = "Failed to save the student data.";
                                }
                            }
                        } else {
                            if (empty($inputSection)) {
                                $data['status'] = "error";
                                $data['message'] = "Please enter the new section name.";
                            } else if ($inputSection !== $fileSection) {
                                $data['status'] = "error";
                                $data['message'] = "The spreadsheet name does not match the section name or the grade year level.";
                            } else if ($page_year_level !== $gradeYearLevel && $page_year_level !== $fileYearLevel) {
                                $data['page_year_level'] = $page_year_level;
                                $data['gradeYearLevel'] = $gradeYearLevel;
                                $data['status'] = "error";
                                $data['message'] = "Invalid file upload. The uploaded file's grade year level does not match the expected value. ";
                            } else {
                                $last_name = substr($student_name, -3);
                                // Extract the last 4 digits of the student number
                                $last_digits = substr($student_number, -5);
                                // Combine the last name and last digits to create the password
                                $user_password = base64_encode(strtoupper($last_name) . $last_digits);

                                $insert_query = "INSERT INTO `users_accounts`(`user_id`, `user_name`, `user_year_level`, `user_section`, `user_photo`, `user_password`, `user_status`, `user_type`, `account_created`) VALUES ('$student_number','$student_name','$gradeLevel','$inputSection','default-image.png','$user_password','Offline','student',NOW())";
                                $insert_result = mysqli_query($con, $insert_query);

                                if ($insert_result) {
                                    $data['status'] = "success";
                                    $data['message'] = "Successfully created new section.";
                                } else {
                                    $data['status'] = "error";
                                    $data['message'] = "Failed to save the student data.";
                                }
                            }
                        }
                    } else {
                        $data['status'] = "error";
                        $data['message'] = "SQL query error";
                        echo json_encode($data);
                        exit;
                    }
                }
            }
            $data['studentData'] = $studentData;
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
?>