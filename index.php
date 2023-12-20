<?php
session_start();
include("actions/database-connection.php");
include("actions/check-login.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="src/css/images/sfdss-logo.webp">
    <!-- Animate On Scroll -->
    <link rel="stylesheet" href="src/css/aos.css">
    <!-- CSS and Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/css/responsive-style.css">
    <link rel="stylesheet" href="src/css/main-style.css">
    <title>San Francisco De Sales School of San Pedro Laguna, Inc.</title>
</head>

<body class="index-page">
    <div class="header">
        <div class="logo">
            <a href="index.php" class="logo-atag">
                <img src="src/css/images/sfdss-logo.webp" alt="Logo">
                <div class="school-name">
                    <h1 class="fs-4 ms-2 text-uppercase">San Francisco De Sales</h1>
                    <h1 class="fs-4 ms-2 text-uppercase">School of San Pedro Laguna, Inc.</h1>
                </div>
            </a>
        </div>
    </div>
    <nav class="navbar sticky-navbar navbar-expand-lg bg-body-tertiary p-0">
        <div class="container-fluid p-0">
            <ul class=" nav justify-content-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-hover="dropdown">
                        About
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pages/sfdss-administration-page.php">Administration</a></li>
                        <li><a class="dropdown-item" href="pages/sfdss-hymn-page.php">Alma Mater Song</a></li>
                        <li><a class="dropdown-item" href="pages/sfdss-history-page.php">Brief History</a></li>
                        <li><a class="dropdown-item" href="pages/sfdss-mission-vision-page.php">Goal, Mission and
                                Vision</a> </li>
                        <li class="nav-item dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Policies, Regulations, Guidelines
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="pages/sfdss-governing-bodies-page.php">Governing
                                        Bodies</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages/sfdss-sgp-page.php">Statement of General
                                        Policies</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages/sfdss-portal-policy-page.php">Portal Privacy
                                        Policy</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="pages/sfdss-legalities-disclaimers-page.php">Legalities
                                        and
                                        Disclaimers</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Academics
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pages/sfdss-jhs-page.php">Junior High School</a></li>
                        <li><a class="dropdown-item" href="pages/sfdss-shs-page.php">Senior High School</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admissions
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pages/sfdss-admission-policies-page.php">Admission
                                Policies</a>
                        <li><a class="dropdown-item" href="pages/sfdss-admission-process-page.php">Admission Process</a>
                        </li>
                        <li class="nav-item dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Application Forms
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="https://forms.gle/TfvMoFwrgJsC97nJ7"
                                        target="_blank">Junior High
                                        School</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="https://forms.gle/i42YdjqgEUT2cEGs6"
                                        target="_blank">Senior High
                                        School</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Events
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pages/sfdss-events-gallery-page.php">Past Events Gallery</a>
                        </li>
                        <li><a class="dropdown-item" href="pages/sfdss-calendar-page.php">Academic Calendar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="pages/sfdss-news-announcement-page.php">
                        News & Announcements
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Student Life
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pages/sfdss-athletics-sports-page.php">Athletics and
                                Sports</a>
                        </li>
                        <li><a class="dropdown-item" href="pages/sfdss-clubs-org-page.php">Clubs and Organizations</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        FAQs
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="pages/sfdss-student-faq-page.php">FAQs for Students</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages/sfdss-general-faq-page.php">General FAQs</a>
                        <li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="pages/sfdss-contact-info-page.php">
                        Contact Information
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <div class="banner" style="background-image: url(src/css/images/banner/banner12.webp);">
        </div>
        <div class="container-fluid school-desc">
            <div class="row align-items-center">
                <div class="col-sm">
                    <h2 class="text-green text-uppercase fw-semibold" data-aos="fade-down">Dignified Learning
                        Journey</h2>
                    <h5 class="text-green fw-light" style="font-family: 'Titillium Web', sans-serif;"
                        data-aos="zoom-in">San Francisco De Sales School of San Pedro Laguna, Inc. is a
                        respected educational
                        institution
                        dedicated to nurturing responsible student development within an enriching environment.
                        Committed to fostering positive relationships and exemplary lives, the school aims to equip
                        students with skills to excel in
                        society while upholding core values of service, faith, dignity, spirituality, and skillfulness.
                        Established in 1980 as Saint Francis Children's House and the institution has a rich history of
                        affordable education
                        and character-building, with its values aligned with the Patron Saint of Educators, San
                        Francisco De Sales.</h5>
                </div>
                <div class="col-sm">
                    <div class="img-gallery" data-aos="zoom-in">
                        <img src="src/css/images/231294388_1474292219577378_8487594937527156206_n.webp" alt="image">
                        <img src="src/css/images/IMG_20230822_195029.webp" alt="image">
                        <img src="src/css/images/IMG_20230822_195045.webp" alt="image">
                        <img src="src/css/images/GOPR0562.webp" alt="image">
                    </div>
                </div>
            </div>
        </div>
        <div class="login-container">
            <img class="school-logo" src="src/css/images/sfdss-logo.webp" alt="Logo" data-aos="fade-right">
            <form id="loginForm" class="login-form">
                <div class="row">
                    <div class="col-sm">
                        <h4 class="text-light m-0" data-aos="fade-down">mySFDSS Portal</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input id="userNumber" type="text" name="user_number" placeholder="Student Number"
                            data-aos="fade-down" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <input id="userPassword" type="password" name="user_password" placeholder="Password"
                            data-aos="fade-down" autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="right"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Enter the last 3 letters of your last name followed by the last 5 digits of your student number.">
                        <div class="show-password" data-aos="fade-down">
                            <input type="checkbox" class="toggle-password" id="showPassword">
                            <label class="text-light">Show Password</label>
                        </div>
                    </div>
                </div>
                <div id="displayMessage"></div>
                <button type="submit" class="btn-login" data-aos="zoom-in">Login</button>
            </form>
        </div>
        <div class="featured-events">
            <div class="gallery-wrap" data-aos="zoom-in">
                <div class="item item-1"></div>
                <div class="item item-2"></div>
                <div class="item item-3"></div>
                <div class="item item-4"></div>
                <div class="item item-5"></div>
                <div class="item item-6"></div>
                <div class="item item-7"></div>
                <div class="item item-8"></div>
            </div>
        </div>
        <div class="footer-clean">
            <footer>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">About</h5>
                            <ul>
                                <li><a href="pages/sfdss-administration-page.php">Administration</a></li>
                                <li><a href="pages/sfdss-hymn-page.php">Alma Mater Song</a></li>
                                <li><a href="pages/sfdss-history-page.php">Brief History</a></li>
                                <li><a href="pages/sfdss-contact-info-page.php">Contact Information</a></li>
                                <li><a href="pages/sfdss-mission-vision-page.php">Goal, Mission and Vision</a></li>
                                <li><a href="pages/sfdss-governing-bodies-page.php">Governing Bodies</a></li>
                                <li><a href="pages/sfdss-sgp-page.php">Statement of General Policies</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">Admission</h5>
                            <ul>
                                <li><a href="pages/sfdss-admission-policies-page.php">Admission Policies</a></li>
                                <li><a href="pages/sfdss-admission-process-page.php">Admission Process</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">FAQs</h5>
                            <ul>
                                <li><a href="pages/sfdss-student-faq-page.php">FAQs for Students</a></li>
                                <li><a href="pages/sfdss-general-faq-page.php">General FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">Legal Information</h5>
                            <ul>
                                <li><a href="pages/sfdss-portal-policy-page.php">Portal Privacy Policy</a></li>
                                <li><a href="pages/sfdss-legalities-disclaimers-page.php">Legalities and Disclaimers</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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

    <!-- JavaScript Libraries -->
    <!-- JQuery -->
    <script src="src/js/jquery-3.6.1.min.js"></script>
    <!-- Animate On Scroll -->
    <script src="src/js/aos.js"></script>
    <!-- Bootstrap JS -->
    <script src="src/js/popper.min.js"></script>
    <script src="src/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="src/js/scroll-to-top-script.js"></script>
    <script src="src/js/custom-scripts/sfdss-login.js"></script>
    <script>
        AOS.init();

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>