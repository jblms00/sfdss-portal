<?php
session_start();

include("../../actions/database-connection.php");
include("../../actions/check-login.php");

$user_data = check_login($con);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../../src/css/images/sfdss-logo.webp">
    <!-- Animate On Scroll -->
    <link rel="stylesheet" href="../../src/css/aos.css">
    <!-- CSS and Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/responsive-style.css">
    <link rel="stylesheet" href="../../src/css/main-style.css">
    <title>San Francisco De Sales School of San Pedro Laguna, Inc.</title>
</head>

<body class="student-side-page schedule-page">
    <div class="header">
        <div class="logo">
            <a href="student-index-page.php" class="logo-atag">
                <img src="../../src/css/images/sfdss-logo.webp" alt="Logo">
                <div class="school-name">
                    <h1 class="fs-4 ms-2 text-uppercase">San Francisco De Sales</h1>
                    <h1 class="fs-4 ms-2 text-uppercase">School of San Pedro Laguna, Inc.</h1>
                </div>
            </a>
        </div>
    </div>
    <nav class="navbar sticky-navbar navbar-expand-lg bg-body-tertiary p-0">
        <div class="container-fluid p-0">
            <ul class="nav justify-content-center">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-index-page.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-grades-page.php">Academic Grades</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#">Class Schedule</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-request-credential-page.php">Credential Request</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-subjects-page.php">Subjects</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-profile-page.php">My Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-light" href="../../actions/user-logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <div class="banner" style="background-image: url(../../src/css/images/banner/banner7.webp);">
            <div class="message">
                <h2 class="m-0 text-green text-center text-uppercase fw-semibold" data-aos="flip-down">Class Schedule
                </h2>
                <h5 class="text-green text-center fw-light" data-aos="zoom-in">mySFDSS Portal</h5>
            </div>
        </div>
        <div class="container-fluid school-desc">
            <div class="row align-items-center my-4">
                <div class="col-sm">
                    <table class="table table-bordered table-striped border border-success table-hover" data-aos="fade">
                        <thead>
                            <tr class="fw-bold table-success border-success" data-aos="fade-down">
                                <th class="fw-bold">Subjects</th>
                                <th class="fw-bold">Days</th>
                                <th class="fw-bold">Period</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-aos="fade-down">
                                <td>Math</td>
                                <td>Monday to Friday</td>
                                <td>7:00am - 8:00am</td>
                            </tr>
                            <tr data-aos="fade-down">
                                <td>English</td>
                                <td>Monday to Wednesday</td>
                                <td>9:00am - 10:00am</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="footer-clean">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-lg footer-item text-center">
                            <p class="copyright">San Francisco De Sales School of San Pedro Laguna, Inc. © 2023</p>
                        </div>
                    </div>
            </footer>
        </div>
    </div>
    <button type="button" class="btn btn-back-to-top" id="btn-back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- JavaScript Libraries -->
    <!-- JQuery -->
    <script src="../../src/js/jquery-3.6.1.min.js"></script>
    <!-- Animate On Scroll -->
    <script src="../../src/js/aos.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../src/js/popper.min.js"></script>
    <script src="../../src/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../../src/js/scroll-to-top-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>