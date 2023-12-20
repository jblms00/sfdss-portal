<?php
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['studentName']) && isset($_POST['studentNumber'])) {
        $student_names = $_POST['studentName'];
        $student_numbers = $_POST['studentNumber'];
        $student_section = $_POST['section'];
        $student_year_level = $_POST['yearLevel'];
        $year_level = "Grade " . $student_year_level;

        $insertedStudents = [];
        $existingStudents = [];

        $allNumeric = true; // Flag to check if all student numbers are numeric

        foreach ($student_names as $index => $student_name) {
            $student_number = mysqli_real_escape_string($con, $student_numbers[$index]);

            // Check if the student number is numeric
            if (!is_numeric($student_number)) {
                $allNumeric = false; // Set the flag to false
                break; // Exit the loop if a non-numeric student number is found
            }

            // Check if the student number already exists in the database
            $sql_check_existing = "SELECT COUNT(*) FROM users_accounts WHERE user_id = '$student_number'";
            $result_check_existing = mysqli_query($con, $sql_check_existing);
            $count_existing = mysqli_fetch_row($result_check_existing)[0];

            if ($count_existing > 0) {
                $existingStudents[] = $student_name;
            } else {
                // Extract the last 3 letters of the last name
                $last_name = substr($student_name, -3);

                // Extract the last 4 digits of the student number
                $last_digits = substr($student_number, -5);

                // Combine the last name and last digits to create the password
                $user_password = base64_encode(strtoupper($last_name) . $last_digits);

                $sql = "INSERT INTO users_accounts (user_id, user_name, user_year_level, user_section, user_photo, user_password, user_status, user_type, account_created) 
                        VALUES ('$student_number', '$student_name', '$year_level', '$student_section', 'default-image.png', '$user_password', 'Offline', 'student', NOW())";

                $result = mysqli_query($con, $sql);

                if ($result) {
                    $insertedStudents[] = $student_name;
                }
            }
        }

        if (!$allNumeric) {
            $data['status'] = 'error';
            $data['message'] = 'Invalid student number. Student numbers must be numeric.';
        } elseif (!empty($existingStudents)) {
            $data['status'] = 'error';
            $data['message'] = 'Student number already existed';
        } elseif (!empty($insertedStudents)) {
            $data['status'] = 'success';
            $data['message'] = 'Students added successfully: ' . implode(', ', $insertedStudents);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No valid students to add';
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No valid students to add';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method';
}

echo json_encode($data);
?>