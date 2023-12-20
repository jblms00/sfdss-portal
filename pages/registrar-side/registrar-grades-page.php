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
            <a href="registrar-index-page.php" class="logo-atag">
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
                    <a class="nav-link" href="registrar-index-page.php">Home</a>
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
                    <a class="nav-link" href="#">Student Grades</a>
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
                <h2 class="m-0 text-green text-center text-uppercase fw-bold" data-aos="flip-down">Student
                    Grades</h2>
            </div>
        </div>
        <div class="container-fluid school-desc registrar-grades-page">
            <div class="row my-4">
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 7</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="7">
                            <!-- Grade 7 -->
                        </tbody>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 8</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="8">
                            <!-- Grade 8 -->
                        </tbody>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 9</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="9">
                            <!-- Grade 9 -->
                        </tbody>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 10</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="10">
                            <!-- Grade 10 -->
                        </tbody>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 11</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="11">
                            <!-- Grade 11 -->
                        </tbody>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="sectionsTable table table-bordered table-striped border border-success table-hover"
                        data-aos="fade-down">
                        <thead>
                            <tr>
                                <th class="fw-bold table-success border-success text-center" colspan="4">Grade 12</th>
                            </tr>
                        </thead>
                        <tbody data-year-level="12">
                            <!-- Grade 12 -->
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
    <!-- Modal - View Subjects -->
    <div class="modal fade" id="modalSubjects" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" id="viewSubjectsDialog"></div>
    </div>
    <!-- Modal - Upload Grades -->
    <div class="modal fade" id="modalUploadGrades" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="modalUploadGradesDialog"></div>
    </div>
    <!-- Modal - View Uploaded Grades -->
    <div class="modal fade" id="modalViewGrades" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen modal-dialog-scrollable" id="viewGradesDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">View Grades | <span id="studentSubject"></span> | Quarter
                        <span id="currentPage"></span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1">
                    <table class="table table-bordered border-success text-center">
                        <thead class="table-success border-success">
                            <tr>
                                <th colspan="14">Written Work (30%)</th>
                                <th colspan="13">Performance Tasks (50%)</th>
                                <th colspan="5">Exam (20%)</th>
                            </tr>
                        </thead>
                        <thead class="table-success border-success align-middle">
                            <tr>
                                <!-- Student Name -->
                                <th scope="col">Name</th>
                                <!-- Written Work Scores -->
                                <th scope="col">1</th>
                                <th scope="col">2</th>
                                <th scope="col">3</th>
                                <th scope="col">4</th>
                                <th scope="col">5</th>
                                <th scope="col">6</th>
                                <th scope="col">7</th>
                                <th scope="col">8</th>
                                <th scope="col">9</th>
                                <th scope="col">10</th>
                                <th scope="col">Total</th>
                                <th scope="col">PS</th>
                                <th scope="col">WS</th>
                                <!-- Performance Task Scores -->
                                <th scope="col">1</th>
                                <th scope="col">2</th>
                                <th scope="col">3</th>
                                <th scope="col">4</th>
                                <th scope="col">5</th>
                                <th scope="col">6</th>
                                <th scope="col">7</th>
                                <th scope="col">8</th>
                                <th scope="col">9</th>
                                <th scope="col">10</th>
                                <th scope="col">Total</th>
                                <th scope="col">PS</th>
                                <th scope="col">WS</th>
                                <!-- Exam Scores -->
                                <th scope="col">Exam Score</th>
                                <th scope="col">PW</th>
                                <th scope="col">WS</th>
                                <th scope="col">Initial Grade</th>
                                <th scope="col">Quarterly Grade</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="align-middle">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <div id="quarterPage">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link page-q1" href="#">1</a></li>
                                <li class="page-item"><a class="page-link page-q2" href="#">2</a></li>
                                <li class="page-item"><a class="page-link page-q3" href="#">3</a></li>
                                <li class="page-item"><a class="page-link page-q4" href="#">4</a></li>
                            </ul>
                        </nav>
                    </div>
                    <button class="modal-opt-btn" data-bs-target="#modalSubjects" data-bs-toggle="modal"
                        style="width: 15%">Go back</button>
                </div>
            </div>
        </div>
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