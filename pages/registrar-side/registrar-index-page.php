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

<body class="registrar-side-page" data-registrar-id="<?php echo $user_data['user_id']; ?>">
    <div class="header">
        <div class="logo">
            <a href="#" class="logo-atag">
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
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-hover="dropdown">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Junior High School
                            </a>
                            <ul class="dropdown-menu student-year">
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="7">Grade
                                        7</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="8">Grade
                                        8</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="9">
                                        Grade 9
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="10">
                                        Grade 10
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Senior High School
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="11">Grade
                                        11</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" id="manageStudentPage" href="#" data-year-level="12">Grade
                                        12</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="registrar-grades-page.php">Student Grades</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="registrar-credentials-page.php">Student Requests</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="registrar-profile-page.php">My Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-light" href="../../actions/user-logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <div class="banner" style="background-image: url(../../src/css/images/banner/banner4.webp);">
            <div class="message">
                <h2 class="fw-bold text-uppercase">Welcome to the SFDSS Portal
                    <?php echo $user_data['user_name'] ?>!
                </h2>
                <h5 class="fw-light">Effortlessly manage student grades, streamline credential requests, and optimize
                    administrative tasks all in one place. Stay organized and efficient as you navigate your role in
                    supporting our academic community.</h5>
            </div>
        </div>
        <div class="container-fluid school-desc">
            <div class="row align-items-center">
                <div class="col-sm-5 fb-frame">
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FSFDSSAdmin&tabs=timeline&width=515&height=650&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId=1025938825075524"
                        width="515" height="650" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
                <div class="col-sm-7">
                    <div class="container-fluid">
                        <div class="row my-5 notification-row">
                            <div class="col-sm">
                                <div class="registrar-notification">
                                    <h4 class="fw-bold text-center mb-4">mySFDSS <span
                                            class="text-uppercase">Notification</span></h4>
                                    <ul id="registrarNotification"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </div>
            </footer>
        </div>
    </div>
    <button type="button" class="btn btn-back-to-top" id="btn-back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>


    <!-- Modal - Notification -->
    <div class="modal fade" id="modalNotification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="modalNotificationDialog"></div>
    </div>


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
    <script src="../../src/js/custom-scripts/registrar-side-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>