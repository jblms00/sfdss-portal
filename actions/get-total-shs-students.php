<?php
session_start();

include('database-connection.php');

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $get_shs_query = "SELECT COUNT(*) AS shs_students FROM users_accounts WHERE user_year_level IN ('Grade 11', 'Grade 12')";
    $get_shs_result = mysqli_query($con, $get_shs_query);

    if ($get_shs_result) {
        $shsStudentsData = mysqli_fetch_assoc($get_shs_result);
        $shsStudents = $shsStudentsData['shs_students'];

        $get_user_counts_query = "SELECT COUNT(*) AS user_count, DATE_FORMAT(account_created, '%b %d, %Y') AS date FROM users_accounts WHERE user_year_level IN ('Grade 11', 'Grade 12') GROUP BY DATE(account_created)";
        $get_user_counts_result = mysqli_query($con, $get_user_counts_query);

        $activeCounts = [
            'labels' => [],
            'data' => []
        ];

        while ($row = mysqli_fetch_assoc($get_user_counts_result)) {
            $activeCounts['labels'][] = $row['date'];
            $activeCounts['data'][] = $row['user_count'];
        }

        $data['shsStudents'] = $shsStudents;
        $data['activeCounts'] = $activeCounts;
        $data['status'] = 'success';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Error fetching senior high student count.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method';
}

echo json_encode($data);
?>