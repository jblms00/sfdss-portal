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
                    <a class="nav-link" href="student-grades-page.php">Academic Grades</a>
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
                    <a class="nav-link" href="#">My Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-light" href="../../actions/user-logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <div class="banner" style="background-image: url(../../src/css/images/banner/banner3.webp);">
            <div class="message">
                <h2 class="m-0 text-green text-center text-uppercase fw-semibold" data-aos="flip-down">Student
                    Profile</h2>
                <h5 class="text-green text-center fw-light" data-aos="zoom-in">mySFDSS Portal</h5>
            </div>
        </div>
        <div class="container-fluid school-desc">
            <div class="row align-items-center mb-4">
                <div class="col-sm text-center" data-aos="zoom-in" id="imageColumn">
                    <img src="../../src/css/images/student-images/" id="userImage" class="user-profile-img" alt="Image">
                </div>
            </div>
            <div class="row align-items-center my-4">
                <div class="col-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="border-success" data-aos="fade-down">
                                    <th class="fw-bold text-uppercase table-success border-success">Student Number (LRN)
                                    </th>
                                    <th class="fw-light" id="studentNumber"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-success" data-aos="fade-down">
                                    <td class="fw-bold text-uppercase table-success border-success">Name</td>
                                    <td id="studentName"></td>
                                </tr>
                                <tr class="border-success" data-aos="fade-down">
                                    <td class="fw-bold text-uppercase table-success border-success">Section</td>
                                    <td id="studentSection"></td>
                                </tr>
                                <tr class="border-success" data-aos="fade-down">
                                    <td class="fw-bold text-uppercase table-success border-success">Grade Year Level
                                    </td>
                                    <td id="studentYearLevel"></td>
                                </tr>
                                <tr class="border-success" data-aos="fade-down">
                                    <td class="fw-bold text-uppercase table-success border-success">Password
                                    </td>
                                    <td id="defaultPassword"></td>
                                </tr>
                                <tr class="border-success" data-aos="fade-down">
                                    <td colspan="2" class="fw-bold text-uppercase table-success border-success">
                                        <button type="button" class="btn change-pass-btn" data-bs-toggle="modal"
                                            data-bs-target="#modalChangePassword">Change Password</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            </footer>
        </div>
    </div>
    <button type="button" class="btn btn-back-to-top" id="btn-back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Modal - Change Password -->
    <div class="modal fade" id="modalChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content change-password-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <p class="mb-0">Current Password</p>
                            <input type="text" id="oldPassword">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="mb-0">New Password</p>
                            <input class="mb-1" type="password" id="newPassword">
                            <div class="show-password mb-4">
                                <input type="checkbox" class="toggle-new-password mb-0">
                                <label>Show Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="mb-0">Confirm New Password</p>
                            <input class="mb-1" type="password" id="confirmPassword">
                            <div class="show-password">
                                <input type="checkbox" class="toggle-confirm-password mb-0">
                                <label>Show Password</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="modal-opt-btn user-change-password">Save</button>
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