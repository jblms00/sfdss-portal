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

<body class="admin-side-page" data-admin-id="<?php echo $user_data['user_id']; ?>">
    <div class="header">
        <div class="logo">
            <a href="admin-index-page.php" class="logo-atag">
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
                    <a class="nav-link" href="admin-index-page.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#">Academic Calendar</a>
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
                            <ul class="dropdown-menu">
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
                    <a class="nav-link" href="admin-manage-na-page.php">News & Announcements</a>
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
                <h3 class="fw-bold text-uppercase">Manage Academic Calender</h3>
            </div>
        </div>
        <div class="container-fluid p-5" id="eventContainer">
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-success add-event-btn" data-bs-toggle="modal"
                        data-bs-target="#addEvent" data-aos="fade-down">Add Event</button>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">January</h5>
                            <ul id="january" class="event-list" type="none">
                                <li>01 - New Year's Day</li>
                                <li>02 - New Year Holiday</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
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
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">March</h5>
                            <ul id="march" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">April</h5>
                            <ul id="april" class="event-list" type="none">
                                <li>06 - Maundy Thursday</li>
                                <li>07 - Good Friday</li>
                                <li>08 - Black Saturday</li>
                                <li>10 - The Day of Valor</li>
                                <li>21 - Eidul-Fitar Holiday</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">May</h5>
                            <ul id="may" class="event-list" type="none">
                                <li>01 - Labor Day</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
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
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">July</h5>
                            <ul id="july" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
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
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">September</h5>
                            <ul id="september" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">October</h5>
                            <ul id="october" class="event-list" type="none"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">November</h5>
                            <ul id="november" class="event-list" type="none">
                                <li>01 - All Saints' Day</li>
                                <li>02 - All Souls' Day</li>
                                <li>27 - Bonifacio Day</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm my-3 d-flex justify-content-center align-items-center">
                    <div class="card text-green" data-aos="fade-down">
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
                </div>
            </footer>
        </div>
    </div>
    <button type="button" class="btn btn-back-to-top" id="btn-back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Modal - Add Event -->
    <div class="modal fade" id="addEvent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="addEventDialog"></div>
    </div>
    <!-- Modal - Edit Event -->
    <div class="modal fade" id="editEvent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="editEventDialog"></div>
    </div>
    <!-- Modal - Edit Event -->
    <div class="modal fade" id="changeEvent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="changeEventDialog"></div>
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
    <script src="../../src/js/custom-scripts/admin-side-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>