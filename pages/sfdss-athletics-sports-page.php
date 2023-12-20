<?php
session_start();
include("../actions/database-connection.php");
include("../actions/check-login.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../src/css/images/sfdss-logo.webp">
    <!-- Animate On Scroll -->
    <link rel="stylesheet" href="../src/css/aos.css">
    <!-- CSS and Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/responsive-style.css">
    <link rel="stylesheet" href="../src/css/main-style.css">
    <title>San Francisco De Sales School of San Pedro Laguna, Inc.</title>
</head>

<body class="athsports-page">
    <div class="header">
        <div class="logo">
            <a href="../index.php" class="logo-atag">
                <img src="../src/css/images/sfdss-logo.webp" alt="Logo">
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
                        <li><a class="dropdown-item" href="sfdss-administration-page.php">Administration</a></li>
                        <li><a class="dropdown-item" href="sfdss-hymn-page.php">Alma Mater Song</a></li>
                        <li><a class="dropdown-item" href="sfdss-history-page.php">Brief History</a></li>
                        <li><a class="dropdown-item" href="sfdss-mission-vision-page.php">Goal, Mission and
                                Vision</a> </li>
                        <li class="nav-item dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Policies, Regulations, Guidelines
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="sfdss-governing-bodies-page.php">Governing
                                        Bodies</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="sfdss-sgp-page.php">Statement of General
                                        Policies</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="sfdss-portal-policy-page.php">Portal Privacy
                                        Policy</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="sfdss-legalities-disclaimers-page.php">Legalities
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
                        <li><a class="dropdown-item" href="sfdss-jhs-page.php">Junior High School</a></li>
                        <li><a class="dropdown-item" href="sfdss-shs-page.php">Senior High School</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admissions
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="sfdss-admission-policies-page.php">Admission Policies</a>
                        <li><a class="dropdown-item" href="sfdss-admission-process-page.php">Admission Process</a>
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
                        <li><a class="dropdown-item" href="sfdss-events-gallery-page.php">Past Events Gallery</a>
                        </li>
                        <li><a class="dropdown-item" href="sfdss-calendar-page.php">Academic Calendar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="sfdss-news-announcement-page.php">
                        News & Announcements
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Student Life
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Athletics and Sports</a></li>
                        <li><a class="dropdown-item" href="sfdss-clubs-org-page.php">Clubs and Organizations</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        FAQs
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="sfdss-student-faq-page.php">FAQs for Students</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="sfdss-general-faq-page.php">General FAQs</a>
                        <li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="sfdss-contact-info-page.php">
                        Contact Information
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <div class="banner" style="background-image: url(../src/css/images/banner/banner12.webp);">
            <div class="message">
                <h3 class="fw-bold text-uppercase mb-0">Athletics & Sports</h3>
            </div>
        </div>
        <div class="container-fluid p-5">
            <div class="row align-items-center">
                <div class="col-sm">
                    <h5 class="text-green mb-4">Welcome to the dynamic world of athletics and sports at San Francisco De
                        Sales School of San
                        Pedro Laguna, Inc.! Our Athletics and Sports department is the beating heart of spirited
                        competition and personal growth. We offer a diverse range of sports and activities, providing
                        opportunities for students of all levels to engage, learn, and excel.</h5>
                    <h5 class="text-green mb-4">From the court to the field, our student-athletes experience the thrill
                        of
                        competition while
                        developing essential life skills such as teamwork, discipline, and leadership. Our dedicated
                        coaches and support staff are committed to guiding our athletes toward success, on and off the
                        playing surface.</h5>
                    <h5 class="text-green mb-4">Explore our sports offerings through a visual journey. Take a look at
                        our
                        dynamic basketball
                        team, our powerful volleyball squad, and two more impressive teams, all captured in action.
                        These images encapsulate the spirit and dedication that define the athletic culture at San
                        Francisco De Sales School of San Pedro Laguna, Inc.</h5>
                    <h5 class="text-green mb-4">Stay updated with the latest sports events, schedules, and team news.
                        Whether
                        you're an athlete,
                        a proud parent, or a sports enthusiast, this page is your gateway to the world of sports at San
                        Francisco De Sales School of San Pedro Laguna, Inc.</h5>
                </div>
                <div class="col-sm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm">
                                <div class="img-box">
                                    <img src="../src/css/images/athletic-sports/basketball-team.webp" alt="Image" />
                                    <div class="transparent-box">
                                        <div class="caption">
                                            <p>Basketball</p>
                                            <p class="opacity-low">mySFDSS Sports Team</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="img-box">
                                    <img src="../src/css/images/athletic-sports/volleyball-team.webp" alt="Image" />
                                    <div class="transparent-box">
                                        <div class="caption">
                                            <p>Volleyball</p>
                                            <p class="opacity-low">mySFDSS Sports Team</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="img-box">
                                    <img src="../src/css/images/athletic-sports/table-tennis-team.webp" alt="Image" />
                                    <div class="transparent-box">
                                        <div class="caption">
                                            <p>Table Tennis</p>
                                            <p class="opacity-low">mySFDSS Sports Team</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="img-box">
                                    <img src="../src/css/images/athletic-sports/badminton-team.webp" alt="Image" />
                                    <div class="transparent-box">
                                        <div class="caption">
                                            <p>Badminton</p>
                                            <p class="opacity-low">mySFDSS Sports Team</p>
                                        </div>
                                    </div>
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
                    <div class="row justify-content-center">
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">About</h5>
                            <ul>
                                <li><a href="sfdss-administration-page.php">Administration</a></li>
                                <li><a href="sfdss-hymn-page.php">Alma Mater Song</a></li>
                                <li><a href="sfdss-history-page.php">Brief History</a></li>
                                <li><a href="sfdss-contact-info-page.php">Contact Information</a></li>
                                <li><a href="sfdss-mission-vision-page.php">Goal, Mission and Vision</a></li>
                                <li><a href="sfdss-governing-bodies-page.php">Governing Bodies</a></li>
                                <li><a href="sfdss-sgp-page.php">Statement of General Policies</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">Admission</h5>
                            <ul>
                                <li><a href="sfdss-admission-policies-page.php">Admission Policies</a></li>
                                <li><a href="sfdss-admission-process-page.php">Admission Process</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">FAQs</h5>
                            <ul>
                                <li><a href="#">FAQs for Students</a></li>
                                <li><a href="sfdss-general-faq-page.php">General FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-3 footer-item">
                            <h5 class="fw-bold">Legal Information</h5>
                            <ul>
                                <li><a href="#">Portal Privacy Policy</a></li>
                                <li><a href="sfdss-legalities-disclaimers-page.php">Legalities and Disclaimers</a></li>
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
    <script src="../src/js/jquery-3.6.1.min.js"></script>
    <!-- Animate On Scroll -->
    <script src="../src/js/aos.js"></script>
    <!-- Bootstrap JS -->
    <script src="../src/js/popper.min.js"></script>
    <script src="../src/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../src/js/scroll-to-top-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>