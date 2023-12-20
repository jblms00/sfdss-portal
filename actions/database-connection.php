<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sfdss_db";

// If statement to connect to phpmyadmin
if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect!");
}