<?php
session_start();

include('database-connection.php');

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $get_jhs_query = "SELECT COUNT(*) AS jhs_students FROM users_accounts WHERE user_year_level IN ('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10')";
    $get_jhs_result = mysqli_query($con, $get_jhs_query);

    if ($get_jhs_result) {
        $jhsStudentsData = mysqli_fetch_assoc($get_jhs_result);
        $jhsStudents = $jhsStudentsData['jhs_students'];

        $get_user_counts_query = "SELECT COUNT(*) AS user_count, DATE_FORMAT(account_created, '%b %d, %Y') AS date FROM users_accounts WHERE user_year_level IN ('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10') GROUP BY DATE(account_created)";
        $get_user_counts_result = mysqli_query($con, $get_user_counts_query);

        $activeCounts = [
            'labels' => [],
            'data' => []
        ];

        while ($row = mysqli_fetch_assoc($get_user_counts_result)) {
            $activeCounts['labels'][] = $row['date'];
            $activeCounts['data'][] = $row['user_count'];
        }

        $data['jhsStudents'] = $jhsStudents;
        $data['activeCounts'] = $activeCounts;
        $data['status'] = 'success';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Error fetching junior high student count.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method';
}

echo json_encode($data);
?>