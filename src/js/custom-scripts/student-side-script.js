$(document).ready(function () {
    studentInformation();
    studentRequestCredentials();
    studentGrades();
    loadEvents();
    displayComputedGrades();
    getNotification();
    changePassword();
    displaySubjects();

    $('.toggle-new-password').click(function () {
        var passwordInput = $('#newPassword');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });

    $('.toggle-confirm-password').click(function () {
        var passwordInput = $('#confirmPassword');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });
});

function studentInformation() {
    var student_number = $('.student-side-page').data('student-id');
    var year_level = $('.student-side-page').data('year-level');
    var section = $('.student-side-page').data('section');

    $.ajax({
        method: "POST",
        url: "../../actions/get-student-information.php",
        data: { student_number,
                year_level,
                section, },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                var student_data = response.student_info[0];
                $('#studentNumber').text(student_data.user_id);
                $('#studentName').text(student_data.user_name);
                $('#studentSection').text(student_data.user_section);
                $('#studentYearLevel').text(student_data.user_year_level);
                
                var decodedPassword = atob(student_data.user_password);
                $('#defaultPassword').text(decodedPassword);
                
                var imageColumn = $('#imageColumn');
                var imageHTML = '';
                
                if (student_data.user_photo !== "") {
                    imageHTML = `<img src="../../src/css/images/student-images/${student_data.user_photo}" class="user-profile-img" alt="Image">`;
                } else {
                    imageHTML = `<img src="../../src/css/images/student-images/default-image.jpg" class="user-profile-img border-0" alt="Image">`;
                }
                imageColumn.html(imageHTML);
            } else {
                console.log(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", error);
        }
    });
}

function studentRequestCredentials() {
    $(document).on('submit', '#requestForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var student_number = $('.student-side-page').data('student-id');
        var userName = $('#userName').val();
        var userEmail = $('#userEmail').val();
        var userContactNumber = $('#userContactNumber').val();
        var userYear = $('#userYear').val();
        var form137Checked = $('#form137').prop('checked');
        var goodMoralChecked = $('#goodMoral').prop('checked');
        var certificateEnrollmentChecked = $('#certificateEnrollment').prop('checked');
        var certificateGraduationChecked = $('#certificateGraduation').prop('checked');
        var secondDiplomaChecked = $('#secondDiploma').prop('checked');
        var userAnswer = $('#userAnswer').val();

        var userNameInput = $('#userName');
        var userEmailInput = $('#userEmail');
        var userContactNumberInput = $('#userContactNumber');
        var userYearInput = $('#userYear');
        var userAnswerInput = $('#userAnswer');

        form.find('.display-message p').hide();
        userNameInput.css('outline', '');
        userEmailInput.css('outline', '');
        userContactNumberInput.css('outline', '');
        userYearInput.css('outline', '');
        userAnswerInput.css('outline', '');
        $.ajax({
            method: "POST",
            url: "../../actions/student-request-credentials.php",
            data: { 
                student_number: student_number,
                student_name: userName,
                student_email: userEmail,
                student_contact_number: userContactNumber,
                student_year_graduated: userYear,
                form137Checked,
                goodMoralChecked,
                certificateEnrollmentChecked,
                certificateGraduationChecked,
                secondDiplomaChecked,
                userAnswer
            },
            dataType: "json",
            success: function (response) {
                var displayMessage = $('.display-message');
                if (response.status === 'success') {
                    form.find('input[type="text"]').prop('disabled', true);
                    form.find('input[type="checkbox"]').prop('disabled', true);
                    form.find('.submit-request-btn').prop('disabled', true);

                    var successMessage = $('<p class="alert alert-success mt-3 p-2 text-center">' + response.message + '</p>').hide();
                    displayMessage.append(successMessage);
                    successMessage.fadeIn(100);

                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    var errorMessage = $('<p class="alert alert-danger mt-3 p-2 text-center">' + response.message + '</p>').hide();
                    displayMessage.append(errorMessage);
                    errorMessage.fadeIn(100);
                    errorMessage.delay(3000).fadeOut(function () {
                        userNameInput.css({
                            'outline': '',
                            'color': ''
                        });
                        userEmailInput.css({
                            'outline': '',
                            'color': ''
                        });
                        userContactNumberInput.css({
                            'outline': '',
                            'color': ''
                        });
                        userYearInput.css({
                            'outline': '',
                            'color': ''
                        });
                        userAnswerInput.css({
                            'outline': '',
                            'color': ''
                        });
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });
}

function studentGrades() {
    var student_number = $('.student-side-page').data('student-id');
    $.ajax({
        url: "../../actions/get-student-final-grade.php",
        type: 'POST',
        data: { student_number: student_number },
        dataType: 'json',
        success: function(response) {
            var gradeTables = $("#firstGradingTable, #secondGradingTable, #thirdGradingTable, #fourthGradingTable");
            var displayMessage = '';
            if (response.status === 'success') {
                gradeTables.empty();

                var subjectMapping = {
                    "AP": "Araling Panlipunan",
                    "ARTS": "Arts",
                    "ENG": "English",
                    "ESP": "Edukasyon sa Pagpapakatao (EsP)",
                    "FIL": "Filipino",
                    "HEALTH": "Health",
                    "MATH": "Math",
                    "MUSIC": "Music",
                    "PE": "Physical Education",
                    "SCI": "Science"
                };

                $.each(response.data, function(index, row) {
                    var tableId = "";
                    var quarter = row.subject_quarter.toLowerCase();

                    if (quarter.includes("q1")) {
                        tableId = "firstGradingTable";
                    } else if (quarter.includes("q2")) {
                        tableId = "secondGradingTable";
                    } else if (quarter.includes("q3")) {
                        tableId = "thirdGradingTable";
                    } else if (quarter.includes("q4")) {
                        tableId = "fourthGradingTable";
                    }

                    var subjectCode = row.subject_quarter.replace(/_Q[1-4]/i, "");
                    var subjectName = subjectMapping[subjectCode] || subjectCode;

                    // Check if all of the specified columns for a subject have values of 0
                    var allColumnsAreZero = true;
                    $.each(["initial_grade", "final_grade"], function (index, columnName) {
                        if (parseInt(row[columnName]) !== 0) {
                            allColumnsAreZero = false;
                            return false; // Exit the loop early since we found a non-zero value
                        }
                    });

                    if (tableId && !allColumnsAreZero) {
                        var tableRow = `
                            <tr data-subcode="${row.subject_quarter}">
                                <td>${subjectName}</td>
                                <td>${row.initial_grade}</td>
                                <td class="text-danger fw-bold">${row.final_grade}</td>
                            </tr>
                        `;
                        $("#" + tableId).append(tableRow);
                    }
                });

                gradeTables.each(function(index, table) {
                    if ($(table).is(":empty")) {
                        displayMessage = `<tr><td colspan="3" class="fw-light fw-semibold text-danger">Currently no grades to display</td></tr>`;
                        $(table).append(displayMessage);
                    }
                });
            } else {
                displayMessage = `<tr><td colspan="3" class="fw-light fw-semibold text-danger">${response.message}</td></tr>`;
                gradeTables.append(displayMessage);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}

function displayComputedGrades() {
    $(document).on('click', '.btn-view-computation', function () {
        var button = $(this);
        var quarter = button.data('quarter');
        var student_number = $('.student-side-page').data('student-id');

        var modalTitle = '';

        if (quarter === 1) {
            modalTitle = 'First Quarter';
        } else if (quarter === 2) {
            modalTitle = 'Second Quarter';
        } else if (quarter === 3) {
            modalTitle = 'Third Quarter';
        } else if (quarter === 4) {
            modalTitle = 'Fourth Quarter';
        }

        // Update the modal title
        $('#viewComputation .modal-title').text(modalTitle);

        $.ajax({
            url: "../../actions/get-computed-grades.php",
            type: 'POST',
            data: {
                student_number: student_number,
                quarter: quarter
            },
            dataType: 'json',
            success: function (response) {
                var tableBody = $('#overallGradesTable');
                tableBody.empty();
                if (response.status === 'success') {
                    var student_data = response.student_data;
                    var subjectWrittenWorks = student_data.student_written_works;
                    var subjectPerformanceTasks = student_data.student_performance_tasks;
                    var subjectExam = student_data.student_exam;
            
                    var subjectMap = [
                        "AP",
                        "ARTS",
                        "ENG",
                        "ESP",
                        "FIL",
                        "HEALTH",
                        "MATH",
                        "MUSIC",
                        "PE",
                        "SCI"
                    ];

                    var rows = '';
                    if (subjectWrittenWorks.length === 0 || subjectPerformanceTasks.length === 0 || subjectExam.length === 0) {
                        var displayMessage = `<tr><td colspan="32" class="fw-light fw-semibold text-danger">Currently no grades to display</td></tr>`;
                        tableBody.append(displayMessage);
                    } else {
                        for (var i = 0; i < subjectWrittenWorks.length; i++) {
                            var wwData = subjectWrittenWorks[i];
                            var ptData = subjectPerformanceTasks[i];
                            var exData = subjectExam[i];

                            rows += '<tr>';

                            // Check if any of the specified columns have non-zero values
                            var hasNonZeroValue = false;

                            $.each(["w1", "w2", "w3", "w4", "w5", "w6", "w7", "w8", "w9", "w10", "total", "pw", "ws"], function (index, columnName) {
                                if (parseInt(wwData[columnName]) !== 0) {
                                    hasNonZeroValue = true;
                                    return false; // Exit the loop early since we found a non-zero value
                                }
                            });

                            // Check the same for Performance Tasks
                            if (!hasNonZeroValue) {
                                $.each(["p1", "p2", "p3", "p4", "p5", "p6", "p7", "p8", "p9", "p10", "total", "pw", "ws"], function (index, columnName) {
                                    if (parseInt(ptData[columnName]) !== 0) {
                                        hasNonZeroValue = true;
                                        return false; // Exit the loop early since we found a non-zero value
                                    }
                                });
                            }

                            // Check the same for Exam
                            if (!hasNonZeroValue) {
                                $.each(["exam_score", "pw", "ws", "initial_grade", "quarterly_grade"], function (index, columnName) {
                                    if (parseInt(exData[columnName]) !== 0) {
                                        hasNonZeroValue = true;
                                        return false; // Exit the loop early since we found a non-zero value
                                    }
                                });
                            }

                            // If at least one of the columns has a non-zero value, display the row
                            if (hasNonZeroValue) {
                                var subjectCode = wwData.subject_quarter.split('_')[0];
                                var subjectIndex = subjectMap.indexOf(subjectCode);
                                var subjectName = subjectIndex !== -1 ? subjectMap[subjectIndex] : '';

                                rows += '<tr>';
                                rows += `<td>${subjectName}</td>`;
                                // Written Works
                                $.each(["w1", "w2", "w3", "w4", "w5", "w6", "w7", "w8", "w9", "w10", "total", "pw", "ws"], function (index, columnName) {
                                    rows += `<td>${wwData[columnName]}</td>`;
                                });

                                // Performance Tasks
                                $.each(["p1", "p2", "p3", "p4", "p5", "p6", "p7", "p8", "p9", "p10", "total", "pw", "ws"], function (index, columnName) {
                                    rows += `<td>${ptData[columnName] || ''}</td>`;
                                });

                                // Exam
                                $.each(["exam_score", "pw", "ws", "initial_grade", "quarterly_grade"], function (index, columnName) {
                                    var cellValue = exData[columnName] || '';
                                    var isQuarterlyGrade = (columnName === 'quarterly_grade');
                                    if (isQuarterlyGrade) {
                                        rows += `<td class="fw-bold text-danger">${cellValue}</td>`;
                                    } else {
                                        rows += `<td>${cellValue}</td>`;
                                    }
                                });
                                rows += '</tr>';
                            }
                        }
                        tableBody.append(rows);
                    }
                } else {
                    var displayMessage = `<tr><td colspan="40" class="fw-light text-danger">Currently no grades to display</td></tr>`;
                    tableBody.append(displayMessage);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });
}

function loadEvents() {
    // Loop through months and check if the event list is empty
    var months = [
        "january", "february", "march", "april", "may", "june", "july",
        "august", "september", "october", "november", "december"
    ];
    
    months.forEach(function (month) {
        var eventList = $(`#${month}.event-list`);
        var hasEvents = eventList.find('li').length === 0;
    
        if (hasEvents) {
            eventList.empty();
            eventList.append('<li class="text-danger fw-semibold">Currently, there are no scheduled events.</li>');
        }
    });

    $.ajax({
        url: '../../actions/get-all-events.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var events = response.events_info;

                events.forEach(function (event) {
                    var dateParts = event.event_start_date.split('-');
                    var day = dateParts[2];

                    var eventHTML = `<li>${day} - ${event.event_name}</li>`;
                    $(`#${event.event_month.toLowerCase()}.event-list`).append(eventHTML);
                });
            } else {
                console.error('Failed to load events: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

function getNotification() {
    var user_id = $('.student-side-page').data('student-id');
    console.log(user_id);
    $.ajax({
        method: "POST",
        url: "../../actions/get-user-notification.php",
        data: { user_id: user_id },
        dataType: "json",
        success: function (response) {
            var notificationList = $("#studentNotification");
            notificationList.empty();

            if (response.status === 'success') {
                response.notifications.forEach(function (notification) {
                    var listItem = `
                        <li class="dropdown-item d-flex align-items-center">
                            <div class="notif-content d-flex align-items-center">
                                <img src="../../src/css/images/student-images/${notification.user_information.user_photo}" class="display-photo" alt="Image">
                                <p class="m-0 ms-1">${notification.remarks}</p>
                                <p class="notif-time">${notification.sent_at}</p>
                            </div>
                        </li>
                    `;
                    notificationList.append(listItem);
                });
            } else {
                // Display the 'no notifications' message
                notificationList.addClass('d-flex align-items-center justify-content-center');
                notificationList.html('<li class="text-muted"><p class="text-danger fw-semibold mb-0">Currently, there are no notifications.</p></li>');
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", error);
        }
    });
}

function changePassword() {
    $(document).on('click', '.user-change-password', function () {
        var button = $(this);
        var user_id = $('.student-side-page').data('student-id');
        var old_password = $('#oldPassword').val();
        var new_password = $('#newPassword').val();
        var confirm_password = $('#confirmPassword').val();

        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');

        $.ajax({
            method: "POST",
            url: "../../actions/student-change-password.php",
            data: { user_id: user_id,
                    old_password: old_password,
                    new_password: new_password,
                    confirm_password: confirm_password},
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    modal.find('button, input').prop('disabled', true);

                    var contentHTML = `<p class="mb-0 mt-3 text-success text-center fw-bold">${response.message}</p>`;
                    modalBody.append(contentHTML);

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    if (errorContent.length) {
                        errorContent.text(response.message);
                    } else {
                        errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">' + response.message + '</p>');
                        modalBody.append(errorContent);
                    }
                    errorContent.fadeIn(400).delay(3000).fadeOut(400, function () {
                        errorContent.remove();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });
}

function displaySubjects() {
    var year_level = $('.student-side-page').data('year-level');
    var section = $('.student-side-page').data('section');
    var subjectsContainer = $('#studentSubjects');

    student_section = section.substring(1);
    if (year_level === 'Grade 7' || year_level === 'Grade 8' || year_level === 'Grade 9' || year_level === 'Grade 10') {
        var jhsSubjects = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Grading - Fourth Grading</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Araling Panlipunan</td>
                        </tr>
                        <tr>
                            <td>Arts</td>
                        </tr>
                        <tr>
                            <td>English</td>
                        </tr>
                        <tr>
                            <td>Edukasyon sa Pagpapakatao (EsP)</td>
                        </tr>
                        <tr>
                            <td>Filipino</td>
                        </tr>
                        <tr>
                            <td>Health</td>
                        </tr>
                        <tr>
                            <td>Math</td>
                        </tr>
                        <tr>
                            <td>Music</td>
                        </tr>
                        <tr>
                            <td>Physical Education</td>
                        </tr>
                        <tr>
                            <td>Science</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(jhsSubjects);
    } else if (year_level === 'Grade 11' && student_section === 'ABM') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oral Communication</td>
                        </tr>
                        <tr>
                            <td>Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino</td>
                        </tr>
                        <tr>
                            <td>General Mathematics</td>
                        </tr>
                        <tr>
                            <td>Earth and Life Science</td>
                        </tr>
                        <tr>
                            <td>Personal Development</td>
                        </tr>
                        <tr>
                            <td>Understanding Culture, Society and Politics</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>English for Academic and Professional Purposes</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Reading and Writing Skills</td>
                        </tr>
                        <tr>
                            <td>Pagbasa at Pagsusuri ng Iba't-Ibang Teksto Tungo sa Pananaliksik</td>
                        </tr>
                        <tr>
                            <td>Statistics and Probability</td>
                        </tr>
                        <tr>
                            <td>Physical Science</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Empowerment Technologies</td>
                        </tr>
                        <tr>
                            <td>Business Math</td>
                        </tr>
                        <tr>
                            <td>Fundamentals of Accountancy Business and Management 1</td>
                        </tr>
                        <tr>
                            <td>Organization and Management</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else if (year_level === 'Grade 12' && student_section === 'ABM') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>21st Century from the Philippines and the World</td>
                        </tr>
                        <tr>
                            <td>Introduction to Philisophy of the Human Person </td>
                        </tr>
                        <tr>
                            <td>Contemporary Philippine Arts from the Regions</td>
                        </tr>
                        <tr>
                            <td>Media an information Literacy</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 2</td>
                        </tr>
                        <tr>
                            <td>Business Finance</td>
                        </tr>
                        <tr>
                            <td>Fundamentals of Accountancy Business and Mangement 2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Entrepreneurship</td>
                        </tr>
                        <tr>
                            <td>Research Project</td>
                        </tr>
                        <tr>
                            <td>Pagsulat sa Filipino sa Piling Larangan</td>
                        </tr>
                        <tr>
                            <td>Applied Economics</td>
                        </tr>
                        <tr>
                            <td>Business Ethics  and Social Responsibility</td>
                        </tr>
                        <tr>
                            <td>Principles  Marketing</td>
                        </tr>
                        <tr>
                            <td>Business Enterprise Simulation</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else if (year_level === 'Grade 11' && student_section === 'HUMSS') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oral Communication</td>
                        </tr>
                        <tr>
                            <td>Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino</td>
                        </tr>
                        <tr>
                            <td>General Mathematics</td>
                        </tr>
                        <tr>
                            <td>Earth and Life Science</td>
                        </tr>
                        <tr>
                            <td>Understanding Culture, Society and Politics</td>
                        </tr>
                        <tr>
                            <td>Contemporary Philippines Arts from the Regions</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>English for Academic and Professional Purposes</td>
                        </tr>
                        <tr>
                            <td>Empowerment Technologies</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Reading and Writing Skills</td>
                        </tr>
                        <tr>
                            <td>Pagbasa at Pagsusuri ng Iba't -Ibang Teksto Tungo sa Pananaliksik</td>
                        </tr>
                        <tr>
                            <td>Statistics and Probability</td>
                        </tr>
                        <tr>
                            <td>Personal Development</td>
                        </tr>
                        <tr>
                            <td>21st Century Literature from the Philippines and the World</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 1</td>
                        </tr>
                        <tr>
                            <td>Discipline and Ideas in the Social Sciences</td>
                        </tr>
                        <tr>
                            <td>Introduction to the World Religions and Belief Systems</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else if (year_level === 'Grade 12' && student_section === 'HUMSS') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Introduction to the Philosophy of the Human Person</td>
                        </tr>
                        <tr>
                            <td>Media and Information Literacy</td>
                        </tr>
                        <tr>
                            <td>Physical Science</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Filipino sa Piling Larangan</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 2</td>
                        </tr>
                        <tr>
                            <td>Creative Writing</td>
                        </tr>
                        <tr>
                            <td>Disciplines and Ideas in the Applied Social Sciences</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Entrepreneurship</td>
                        </tr>
                        <tr>
                            <td>Research Project</td>
                        </tr>
                        <tr>
                            <td>Creative Nonfiction</td>
                        </tr>
                        <tr>
                            <td>Trends Networks and Critical Thinking in the 21st Century Culture</td>
                        </tr>
                        <tr>
                            <td>Community Engagement, Solidarity and Citizenship</td>
                        </tr>
                        <tr>
                            <td>Philippine Politics and Governance</td>
                        </tr>
                        <tr>
                            <td>Culminating Activity</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else if (year_level === 'Grade 11' && student_section === 'STEM') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Introduction to the Phylosophy of the Human Person</td>
                        </tr>
                        <tr>
                            <td>Oral Communication</td>
                        </tr>
                        <tr>
                            <td>Earth Science</td>
                        </tr>
                        <tr>
                            <td>Empowerment  Technologies</td>
                        </tr>
                        <tr>
                            <td>General Mathematics</td>
                        </tr>
                        <tr>
                            <td>Pre- Calculus</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health  </td>
                        </tr>
                        <tr>
                            <td>Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Personal Development </td>
                        </tr>
                        <tr>
                            <td>Reading and Writing Skills</td>
                        </tr>
                        <tr>
                            <td>Pagbasa at Pagsusuri ng Iba't -Ibang Teksto Tungo sa Pananaliksik</td>
                        </tr>
                        <tr>
                            <td>General Chemistry 1</td>
                        </tr>
                        <tr>
                            <td>Statistics and Probability</td>
                        </tr>
                        <tr>
                            <td>Basic Calculus</td>
                        </tr>
                        <tr>
                            <td>Disaster  Readiness and Risk Reduction</td>
                        </tr>
                        <tr>
                            <td>PE</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else if (year_level === 'Grade 12' && student_section === 'STEM') {
        var firstSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">First Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Contemporary Philippine Arts from the Regions</td>
                        </tr>
                        <tr>
                            <td>Pagsulat sa Filipino sa Piling Larang</td>
                        </tr>
                        <tr>
                            <td>English for Academic and Professional Purposes</td>
                        </tr>
                        <tr>
                            <td>21ST Century from  the Philippines and the World</td>
                        </tr>
                        <tr>
                            <td>Understanding  Culture, Society and Politics</td>
                        </tr>
                        <tr>
                            <td>General Physics 1</td>
                        </tr>
                        <tr>
                            <td>General Biology 1</td>
                        </tr>
                        <tr>
                            <td>Media and Information Literacy</td>
                        </tr>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        var secondSemesterTable = `
            <div class="col-sm">
                <table class="table table-bordered table-striped border border-success table-hover">
                    <thead>
                        <tr>
                            <th class="fw-bold table-success border-success" colspan="1">Second Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Physical Education and Health</td>
                        </tr>
                        <tr>
                            <td>Research in Daily Life 2</td>
                        </tr>
                        <tr>
                            <td>Entrepreneurship</td>
                        </tr>
                        <tr>
                            <td>Research Project</td>
                        </tr>
                        <tr>
                            <td>General Physics 2</td>
                        </tr>
                        <tr>
                            <td>General Chemistry 2</td>
                        </tr>
                        <tr>
                            <td>General  Biology 2</td>
                        </tr>
                        <tr>
                            <td>Capstone Project</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;

        subjectsContainer.html(firstSemesterTable + secondSemesterTable);
    } else {
        subjectsContainer.empty();
    }
}
