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

<body class="admin-side-page admin-dashboard" data-admin-id="<?php echo $user_data['user_id']; ?>">
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
                    <a class="nav-link" href="admin-manage-calendar-page.php">Academic Calendar</a>
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
                <h2 class="fw-bold text-uppercase">Manage News and Announcements</h2>
            </div>
        </div>
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-sm-5">
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FSFDSSAdmin&tabs=timeline&width=515&height=650&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId=1025938825075524"
                        width="515" height="650" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
                <div class="col-sm-7">
                    <div class="container-fluid container-feeds">
                        <div class="row mb-4">
                            <div class="col-sm">
                                <div class="post-container">
                                    <button type="button" class="btn post-btn" data-bs-toggle="modal"
                                        data-bs-target="#modalPost">Post News/Announcements Here..</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm" id="postedFeeds"></div>
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

    <!-- Modal - Post News or Announcements -->
    <div class="modal fade" id="modalPost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-post-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Post News/Announcements</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="postDescription" cols="30" rows="7" placeholder="Write something here.."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="createPost" class="modal-opt-btn">Post</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Edit News or Announcements Post -->
    <div class="modal fade" id="modalEditPost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-post-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit News/Announcements</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="editPostDescription" cols="30" rows="7"
                        placeholder="Write something here.."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn edit-post-btn" data-post-id="0">Save changes</button>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="../../src/js/scroll-to-top-script.js"></script>
    <script src="../../src/js/custom-scripts/admin-side-script.js"></script>
    <script src="../../src/js/custom-scripts/admin-charts-script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>