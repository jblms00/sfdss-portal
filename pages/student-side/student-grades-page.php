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

<body class="student-side-page" data-student-id="<?php echo $user_data['user_id']; ?>"
    data-year-level="<?php echo $user_data['user_year_level']; ?>"
    data-section="<?php echo $user_data['user_section']; ?>">
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
                    <a class="nav-link" href="#">Academic Grades</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="student-schedule-page.php">Class Schedule</a>
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
        <div class="banner" style="background-image: url(../../src/css/images/banner/banner8.webp);">
            <div class="message">
                <h2 class="m-0 text-green text-center text-uppercase fw-semibold" data-aos="flip-down">Academic
                    Grades</h2>
                <h5 class="text-green text-center fw-light" data-aos="zoom-in">mySFDSS Portal</h5>
            </div>
        </div>
        <div class="container-fluid school-desc grades-page">
            <div class="row my-5">
                <div class="col-sm" data-aos="fade-down">
                    <table class="table table-bordered table-striped border border-success table-hover"
                        style="width: 40rem">
                        <thead>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">
                                    <button type="button" class="btn btn-view-computation" data-quarter="1"
                                        data-bs-toggle="modal" data-bs-target="#viewComputation">
                                        View Overall Grades
                                    </button>
                                </th>
                            </tr>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">1st Quarter</th>
                            </tr>
                        </thead>
                        <thead class="align-middle">
                            <tr class="fw-bold table-success border-success">
                                <th class="fw-bold">Subjects</th>
                                <th class="fw-bold">Initial Grade</th>
                                <th class="fw-bold">Final Grade</th>
                            </tr>
                        </thead>
                        <tbody id="firstGradingTable" class="align-middle"></tbody>
                    </table>
                </div>
                <div class="col-sm" data-aos="fade-down">
                    <table class="table table-bordered table-striped border border-success table-hover"
                        style="width: 40rem">
                        <thead>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">
                                    <button type="button" class="btn btn-view-computation" data-quarter="2"
                                        data-bs-toggle="modal" data-bs-target="#viewComputation">
                                        View Overall Grades
                                    </button>
                                </th>
                            </tr>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">2nd Quarter</th>
                            </tr>
                        </thead>
                        <thead class="align-middle">
                            <tr class="fw-bold table-success border-success">
                                <th class="fw-bold">Subjects</th>
                                <th class="fw-bold">Initial Grade</th>
                                <th class="fw-bold">Final Grade</th>
                            </tr>
                        </thead>
                        <tbody id="secondGradingTable" class="align-middle"></tbody>
                    </table>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-sm" data-aos="fade-down">
                    <table class="table table-bordered table-striped border border-success table-hover"
                        style="width: 40rem">
                        <thead>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">
                                    <button type="button" class="btn btn-view-computation" data-quarter="3"
                                        data-bs-toggle="modal" data-bs-target="#viewComputation">
                                        View Overall Grades
                                    </button>
                                </th>
                            </tr>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">3rd Quarter</th>
                            </tr>
                        </thead>
                        <thead class="align-middle">
                            <tr class="fw-bold table-success border-success">
                                <th class="fw-bold">Subjects</th>
                                <th class="fw-bold">Initial Grade</th>
                                <th class="fw-bold">Final Grade</th>
                            </tr>
                        </thead>
                        <tbody id="thirdGradingTable" class="align-middle"></tbody>
                    </table>
                </div>
                <div class="col-sm" data-aos="fade-down">
                    <table class="table table-bordered table-striped border border-success table-hover"
                        style="width: 40rem">
                        <thead>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">
                                    <button type="button" class="btn btn-view-computation" data-quarter="4"
                                        data-bs-toggle="modal" data-bs-target="#viewComputation">
                                        View Overall Grades
                                    </button>
                                </th>
                            </tr>
                            <tr class="fw-bold table-success border-success">
                                <th colspan="3" class="fw-bold">4th Quarter</th>
                            </tr>
                        </thead>
                        <thead class="align-middle">
                            <tr class="fw-bold table-success border-success">
                                <th class="fw-bold">Subjects</th>
                                <th class="fw-bold">Initial Grade</th>
                                <th class="fw-bold">Final Grade</th>
                            </tr>
                        </thead>
                        <tbody id="fourthGradingTable" class="align-middle"></tbody>
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

    <!-- Modal - View Grade Computation -->
    <div class="modal fade" id="viewComputation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h1 class="modal-title fs-4 fw-bold text-uppercase"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <table class="table table-bordered border-success text-center" style="width: 100%">
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
                        <tbody id="overallGradesTable" class="align-middle"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" style="width: 15%"
                        data-bs-dismiss="modal">Close</button>
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
    <script src="../../src/js/custom-scripts/student-side-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>