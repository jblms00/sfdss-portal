<?php
session_start();

include("../../actions/database-connection.php");
include("../../actions/check-login.php");

$user_data = check_login($con);
$user_name = $user_data['user_name'];
$parts = explode(' ', $user_name); // Split the full name by space

$first_name = $parts[0];
$middle_name = isset($parts[1]) ? $parts[1] : '';
$full_first_name = $middle_name ? $first_name . ' ' . $middle_name : $first_name;

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
                    <a class="nav-link" href="student-profile-page.php">My Profile</a>
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
                <h5 class="fw-light">We're excited to introduce your digital hub for all things related to your
                    educational journey at SFDSS. From class schedules to assignments and more, everything you need is
                    right here. Stay connected, organized, and make the most of your time at our school.</h5>
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
                                <div class="student-notification">
                                    <h4 class="fw-bold text-center mb-4">mySFDSS <span
                                            class="text-uppercase">Notification</span></h4>
                                    <ul id="studentNotification"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-5 event-container" id="eventContainer">
            <div class="row">
                <div class="col-sm">
                    <h3>SFDSS Academic Calendar</h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">January</h5>
                            <ul id="january" class="event-list" type="none">
                                <li>1 - New Year's Day</li>
                                <li>2 - New Year Holiday</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">February</h5>
                            <ul id="february" class="event-list" type="none">
                                <li>14 - Valentine's Day</li>
                                <li>24 - Day off for People Power Anniversary</li>
                                <li>25 - People Power Anniversary</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">March</h5>
                            <ul id="march" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">April</h5>
                            <ul id="april" class="event-list" type="none">
                                <li>6 - Maundy Thursday</li>
                                <li>7 - Good Friday</li>
                                <li>8 - Black Saturday</li>
                                <li>10 - The Day of Valor</li>
                                <li>21 - Eidul-Fitar Holiday</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">May</h5>
                            <ul id="may" class="event-list" type="none">
                                <li>1 - Labor Day</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">June</h5>
                            <ul id="june" class="event-list" type="none">
                                <li>12 - Independence Day</li>
                                <li>28 - Eid al-Adha (Feast of the Sacrifice)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">July</h5>
                            <ul id="july" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">August</h5>
                            <ul id="august" class="event-list" type="none">
                                <li>21 - Ninoy Aquino Day</li>
                                <li>28 - National Heroes Day</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">September</h5>
                            <ul id="september" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">October</h5>
                            <ul id="october" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">November</h5>
                            <ul id="november" class="event-list" type="none">
                                <li>1 - All Saints' Day</li>
                                <li>2 - All Souls' Day</li>
                                <li>27 - Bonifacio Day</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">December</h5>
                            <ul id="december" class="event-list" type="none">
                                <li>25 - Christmas Day</li>
                                <li>30 - Rizal Day</li>
                                <li>31 - New Year's Eve</li>
                            </ul>
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