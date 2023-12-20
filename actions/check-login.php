<?php

function check_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM users_accounts WHERE user_id = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    header("Location: /sfdss-portal/index.php");
    exit();
}
?>