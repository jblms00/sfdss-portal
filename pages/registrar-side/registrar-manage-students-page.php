<?php
session_start();

include("../../actions/database-connection.php");
include("../../actions/check-login.php");

$user_data = check_login($con);

if (isset($_GET['year_level'])) {
    $url_year_level = $_GET['year_level'];
}

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

<body class="registrar-side-page manage-student-page" data-registrar-id="<?php echo $user_data['user_id']; ?>"
    data-year-level="<?php echo $url_year_level; ?>">
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
                <h2 class="fw-bold text-uppercase text-green text-center">Manage Grade
                    <?php echo $url_year_level; ?> Students
                </h2>
            </div>
        </div>
        <div class="main-container">
            <div class="container-fluid manage-students-container">
                <div class="row align-items-center mb-4">
                    <div class="col-sm">
                        <div class="table-responsive">
                            <div class="search-container text-center my-4">
                                <button type="button" class="btn add-section-btn" data-bs-toggle="modal"
                                    data-bs-target="#modalAddSection">
                                    Add New Section
                                </button>
                                <button type="button" class="remove-selected-btn d-none" id="removeSelected"
                                    data-bs-toggle="modal" data-bs-target="#modalRemoveSelectedSections">Remove
                                    Selected</button>
                                <button id="removedAll" class="btn remove-all-btn d-none" data-bs-toggle="modal"
                                    data-bs-target="#modalRemoveSections">Remove All Data</button>
                                <input type="text" class="search-input" id="searchInput" placeholder="Search Section"
                                    autocomplete="off">
                                <button class="btn sort-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Sort Table
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" data-sort-type="az">A-Z</button></li>
                                    <li><button class="dropdown-item" data-sort-type="za">Z-A</button></li>
                                </ul>
                            </div>
                            <table
                                class="table table-bordered border-success manage-student-table text-center align-middle"
                                data-aos="fade" style="width: 60%">
                                <thead>
                                    <tr class="table-success border-success">
                                        <th style="width: 10%"><input type="checkbox" id="selectAll"></th>
                                        <th>Section</th>
                                        <th style="width: 25%">Option</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr id="noResultsRow" class="d-none">
                                        <td colspan="5" class="text-danger fw-semibold">No result found</td>
                                    </tr>
                                </tbody>
                            </table>
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
    <!-- Modal - Remove Selected Sections -->
    <div class="modal fade" id="modalRemoveSelectedSections" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Remove Sections</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-green">Are you sure you want to remove the selected sections?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">No</button>
                    <button type="button" class="modal-opt-btn confirm-remove-section-btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - Remove All Sections -->
    <div class="modal fade" id="modalRemoveSections" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Remove Sections</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-green">Are you sure you want to remove all the sections?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">No</button>
                    <button type="button" class="modal-opt-btn remove-all-sections-confirm">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - View Students per Section -->
    <div class="modal fade" id="modalEditSection" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" id="editSectionDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container-fluid">
                    <div class="search-container text-center my-4">
                        <button type="button" class="remove-selected-btn d-none" id="removeSelectedStudents"
                            data-bs-toggle="modal" data-bs-target="#modalRemoveSelectedStudents">Remove
                            Selected</button>
                        <button id="removedAllStudents" class="btn remove-all-btn d-none" data-bs-toggle="modal"
                            data-bs-target="#modalRemoveStudents">Remove All Data</button>
                        <input type="text" class="search-student-input text-center" id="searchStudent"
                            placeholder="Search Section" autocomplete="off" style="width: 62%">
                        <button class="btn btn-add-student ms-3" id="addNewStudents" data-bs-toggle="modal"
                            data-bs-target="#modalAddStudents">Add Students</button>
                    </div>
                    <table class="table table-bordered border-success manage-student-table text-center align-middle"
                        style="width: 80%">
                        <thead>
                            <tr class="table-success border-success">
                                <th style="width: 10%"><input type="checkbox" id="selectAllStudents"></th>
                                <th style="width: 40%">Student Number</th>
                                <th style="width: 50%">Name</th>
                            </tr>
                        </thead>
                        <tbody id="tableSectionsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - Remove Selected Students -->
    <div class="modal fade" id="modalRemoveSelectedStudents" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Remove Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-green">Are you sure you want to remove the selected students?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-toggle="modal"
                        data-bs-target="#modalEditSection">No</button>
                    <button type="button" class="modal-opt-btn confirm-remove-students-btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - Remove All Students -->
    <div class="modal fade" id="modalRemoveStudents" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Remove Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-green">Are you sure you want to remove all the students?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-toggle="modal"
                        data-bs-target="#modalEditSection">No</button>
                    <button type="button" class="modal-opt-btn remove-all-students-confirm">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - Add New Students per Section -->
    <div class="modal fade" id="modalAddStudents" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-add-student-content">
                <form id="addStudentsForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Students</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body container-fluid">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="modal-opt-btn" id="addInput" style="width: 35%">
                                Add More Students
                            </button>
                        </div>
                        <div class="form-group my-3">
                            <input type="text" class="form-control" name="studentNumber[]" placeholder="Student Number"
                                autocomplete="off">
                            <input type="text" class="form-control" name="studentName[]" placeholder="Student Name"
                                autocomplete="off">
                            <button type="button" class="remove-added-student"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <!-- Dynamic input fields will be added here -->
                        <div id="dynamicInputs"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-opt-btn" data-bs-toggle="modal"
                            data-bs-target="#modalEditSection" style="width: 30%">Cancel</button>
                        <button type="submit" class="modal-opt-btn" style="width: 30%">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal - Add New Section -->
    <div class="modal fade" id="modalAddSection" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content add-section-content">
                <form id="addSectionForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add New Section</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="fw-semibold mb-0 text-green">Section</p>
                                <input type="text" id="sectionName" name="section_name"
                                    placeholder="Add section name here" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="file" class="input-excel" id="excelFile" name="excel_file"
                                    accept=".xls, .xlsx">
                                <div class="d-flex justify-content-center mt-3" id="loadSpinner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="upload-record modal-opt-btn">Save</button>
                    </div>
                </form>
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