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
        <div class="banner" style="background-image: url(../../src/css/images/banner/banner11.webp);">
            <div class="message">
                <h5 class="fw-light">We're here to assist you in obtaining the credentials you need for your academic
                    journey at SFDSS. Whether you're looking for transcripts, certificates, or other documents, SFDSS
                    portal ensures a hassle-free process. Simply submit your requests here, and we'll take
                    care of the rest, helping you stay focused on your education.</h5>
            </div>
        </div>
        <div class="container-fluid school-desc">
            <div class="row align-items-center my-4">
                <div class="col-sm">
                    <form id="requestForm">
                        <div class="box">
                            <div class="form-header mb-4">
                                <h2 class="m-0 text-light text-center text-uppercase fw-semibold">
                                    Request
                                    Credentials</h2>
                                <h5 class="text-light text-center fw-light">mySFDSS Portal</h5>
                            </div>
                            <div class="input-data">
                                <h5>Student Number <span class="text-danger">*</span></h5>
                                <input type="text" id="userStudentNumber" value="<?php echo $user_data['user_id']; ?>"
                                    placeholder="Your student number" autocomplete="off">
                            </div>
                            <div class="input-data">
                                <h5>Name <span class="text-danger">*</span></h5>
                                <input type="text" id="userName" value="<?php echo $user_data['user_name']; ?>"
                                    placeholder="Your name" autocomplete="off">
                            </div>
                            <div class="input-data">
                                <h5>Email <span class="text-danger">*</span></h5>
                                <input type="text" id="userEmail" placeholder="Your email" autocomplete="off">
                            </div>
                            <div class="input-data">
                                <h5>Contact Number <span class="text-danger">*</span></h5>
                                <input type="text" id="userContactNumber" placeholder="Your contact number"
                                    autocomplete="off">
                            </div>
                            <div class="input-data">
                                <h5>Year Graduated (if applicable)</h5>
                                <input type="text" id="userYear" placeholder="Your year" autocomplete="off">
                            </div>
                            <div class="input-data">
                                <h5>Which Registrar Document(s) do you need? Please select the relevant document(s) by
                                    checking the box(es) below <span class="text-danger">*</span></h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Form 137" id="form137">
                                    <label for="form137">Form 137</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Good Moral" id="goodMoral">
                                    <label for="goodMoral">Good Moral</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Certificate of Enrollment"
                                        id="certificateEnrollment">
                                    <label for="certificateEnrollment">Certificate of Enrollment</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Certificate of Graduation"
                                        id="certificateGraduation">
                                    <label for="certificateGraduation">Certificate of Graduation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2nd Copy of Diploma"
                                        id="secondDiploma">
                                    <label for="secondDiploma">2nd Copy of Diploma</label>
                                </div>
                            </div>
                            <div class="input-data">
                                <h5>What is the purpose of the requested credential(s)? <span
                                        class="text-danger">*</span></h5>
                                <input type="text" id="userAnswer" placeholder="Your answer" autocomplete="off">
                            </div>
                            <div class="display-message"></div>
                            <div class="submit-button text-center">
                                <button type="submit" class="submit-request-btn">Submit Request</button>
                            </div>
                        </div>
                    </form>
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
    <script src="../../src/js/custom-scripts/student-side-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>