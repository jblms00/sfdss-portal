$(document).ready(function () {
    registrarInformation();
    studentRequest();
    removeRequest();
    getNotification();
    displaySections();
    uploadGrades();
    viewGrades();
    goToStudentPage();
    handleSections();
    addSection();
    viewStudents();
    addNewStudents();

    var ascending = true;
    $('.za-filter-table').click(function() {
        ascending = !ascending;
        var icon = $(this).find('i');
        
        if (ascending) {
            icon.removeClass('bi-sort-alpha-down').addClass('bi-sort-alpha-up-alt');
        } else {
            icon.removeClass('bi-sort-alpha-up-alt').addClass('bi-sort-alpha-down');
        }
        
        sortTable(ascending);
    });
    
});

// Get Registrar Profile
function registrarInformation() {
    var registrar_id = $('.registrar-side-page').data('registrar-id');
    $.ajax({
        method: "POST",
        url: "../../actions/get-registrar-information.php",
        data: { registrar_id },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                var registrar_data = response.registrar_info[0];
                $('#registrarNumber').text(registrar_data.user_id);
                $('#registrarName').text(registrar_data.user_name);
                
                var imageColumn = $('#imageColumn');
                var imageHTML = '';
                
                if (registrar_data.user_photo !== "") {
                    imageHTML = `<img src="../../src/css/images/student-images/${registrar_data.user_photo}" class="user-profile-img" alt="Image">`;
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

// Display Student Request || Search Function and Sort Table
function studentRequest() {
    $.ajax({
        method: "GET",
        url: "../../actions/get-student-requests.php",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                var table = $("#studentRequest");
                var tableContentHTML = '';

                if (response.student_requests.length === 0) {
                    tableContentHTML += `
                        <tr>
                            <td colspan="7" class="no-data-table text-center text-danger fw-semibold">There are currently no request/s to display.</td>
                        </tr>
                    `;
                } else {
                    $.each(response.student_requests, function (i, request) {
                        var requestedAt = new Date(request.requested_at);
                        // Format the date in "M d Y" format
                        var formattedDate = requestedAt.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                
                        tableContentHTML += `
                            <tr data-student-number=${request.student_number} data-request-id="${request.request_id}">
                                <td><input type="checkbox" class="user-checkbox" class="row-checkbox"></td>
                                <td>${request.student_name}</td>
                                <td>${request.request_status}</td>
                                <td>${formattedDate}</td>
                                <td>
                                    <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editCredentialStatus">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-remove"><i class="bi bi-x-lg"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                }
                table.append(tableContentHTML);
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", error);
        }
    });
    
    function filterTable(searchQuery) {
        var rows = $('#studentRequest tr[data-student-number][data-request-id]');
        var existingRows = $('#studentRequest tr .no-data-table');
        var lowerSearchQuery = searchQuery.toLowerCase();
        var anyMatch = false;
    
        rows.each(function () {
            var row = $(this);
            var studentNumber = row.data('student-number').toString().toLowerCase();
            var studentName = row.find('td:nth-child(2)').text().toLowerCase();
            var requestedCredentials = row.find('td:nth-child(3)').text().toLowerCase();
            var requestStatus = row.find('td:nth-child(4)').text().toLowerCase();
    
            if (
                studentNumber.includes(lowerSearchQuery) ||
                studentName.includes(lowerSearchQuery) ||
                requestedCredentials.includes(lowerSearchQuery) ||
                requestStatus.includes(lowerSearchQuery)
            ) {
                row.removeClass('d-none');
                anyMatch = true;
            } else {
                row.addClass('d-none');
            }
        });
    
        if (anyMatch) {
            $('#noResultsRow').addClass('d-none');
        } else {
            existingRows.remove();
            $('#noResultsRow').removeClass('d-none');
        }
    }
    
    $('#searchInput').on('input', function () {
        var searchQuery = $(this).val();
        filterTable(searchQuery);
    });
    

    $(document).on('click', '.btn-edit', function () {
        var button = $(this);
        var student_number = button.closest('tr').data('student-number');
        var request_id = button.closest('tr').data('request-id');
        $.ajax({
            url: "../../actions/get-student-credential.php",
            type: 'POST',
            data: { student_number: student_number,
                    request_id: request_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var modalDialog = $('#modalDialog');
                    var student_info = response.student_info[0];

                    var modalContent = `
                        <div class="modal-content">
                            <div class="modal-header" data-request-id="${student_info.request_id}">
                                <h1 class="modal-title fs-5">${student_info.student_number} | ${student_info.student_name}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-green fw-semibold">Credentials Requested</h5>
                                <ul class="text-green">
                                    ${student_info.student_requested.split(',').map(item => `<li>${item}</li>`).join('')}
                                </ul>
                                <h5 class="text-green fw-semibold">Remarks</h5>
                                <textarea id="registrarRemarks" cols="30" rows="5">You are now welcome to visit the school's registrar office. Kindly ensure to bring along a request letter with you.</textarea>
                                <select class="form-select">
                                    <option selected>Select status</option>
                                    <option value="Done">Done</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="modal-opt-btn btn-save">Save changes</button>
                            </div>
                        </div>
                    `;
                    if (modalDialog.children().length > 0) {
                        modalDialog.html(modalContent);
                    } else {
                        modalDialog.append(modalContent);
                    }
                } else {
                    console.log(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });

    $(document).on('click', '.btn-save', function () {
        var button = $(this);
        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var student_number = modal.find('.modal-title').text().split(' | ')[0].trim();
        var request_id = modal.find('.modal-header').data('request-id');
        var remarks  = $('#registrarRemarks').val();
        var selectValue  = modalBody.find('select.form-select').val();
        var errorContent = modalBody.find('.text-danger');
        errorContent.empty();
        
        $.ajax({
            url: "../../actions/registrar-update-request.php",
            type: 'POST',
            data: { student_number: student_number,
                    request_id: request_id,
                    remarks: remarks,
                    selected_value: selectValue },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    modal.find('button, textarea, select').prop('disabled', true);

                    var contentHTML = `<p class="mb-0 mt-3 text-success text-center fw-bold">${response.message}</p>`;
                    modalBody.append(contentHTML);

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    if (errorContent.length) {
                        errorContent.text(response.message);
                    } else {
                        errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
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

function sortTable(ascending) {
    var table = $('#studentRequest');
    var tableRows = table.find('tr');
    tableRows.sort(function(a, b) {
        var valueA = $(a).find('td:first-child').text().toUpperCase();
        var valueB = $(b).find('td:first-child').text().toUpperCase();

        if (ascending) {
            return (valueA < valueB) ? -1 : (valueA > valueB) ? 1 : 0;
        } else {
            return (valueA > valueB) ? -1 : (valueA < valueB) ? 1 : 0;
        }
    });
    tableRows.detach().appendTo(table);
}

function removeRequest() {
    var selectedRequest = [];

    $(document).on('click', '.user-checkbox', function () {
        var anyCheckboxChecked = $('.user-checkbox:checked').length > 0;
        $('.btn-remove-modal').toggleClass('d-none', !anyCheckboxChecked);
    });

    // Remove Selected Request/s
    $('.btn-remove-modal').on('click', function () {
        $('.user-checkbox:checked').each(function () {
            selectedRequest.push($(this).closest('tr').data('request-id'));
        });

        if (selectedRequest.length > 0) {
            $.ajax({
                url: "../../actions/registrar-remove-request.php",
                method: 'POST',
                data: { selected_request: selectedRequest },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        var modalBody = $('#modalRemovedData .modal-body p');
                        modalBody.text("Selected request/s have been removed successfully.");
                        $('#modalRemovedData').modal('show');

                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        }
    });

    // Remove All Requests
    $('#removeAllDataButton').on('click', function () {
        $('.user-checkbox').prop('checked', true);

        var modalDialog = $('#removeAllRequestsDialog');
        var contentHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove All Student Requests</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-green">Are you certain you wish to delete all requested student credentials?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="modal-opt-btn confirm-btn">Confirm</button>
                </div>
            </div>
        `;
        if (modalDialog.children().length > 0) {
            modalDialog.empty();
        }
        modalDialog.append(contentHTML);
    });

    // Confirm Removing All Requests
    $(document).on('click', '.confirm-btn', function () {
        var button = $(this);
        $.ajax({
            url: "../../actions/registrar-remove-all-request.php",
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#modalRemovedAllData').modal('show');
                    button.closest('.modal-content').find('button').prop('disabled', true);
                    var modalBody = $('#modalRemovedAllData .modal-body p').addClass('text-center text-success fw-semibold');
                    modalBody.text("All request/s have been removed successfully.");

                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });

    $(document).on('click', '.btn-remove', function () {
        var button = $(this);
        var tableTR = button.closest('tr');
        var request_id = tableTR.data('request-id');

        $.ajax({
            url: "../../actions/registrar-remove-request.php",
            data: { selected_request: request_id },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    tableTR.remove();
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });
}

function getNotification() {
    var user_id = $('.registrar-side-page').data('registrar-id');
    $.ajax({
        method: "POST",
        url: "../../actions/get-user-notification.php",
        data: { user_id: user_id },
        dataType: "json",
        success: function (response) {
            var notificationList = $("#registrarNotification");
            notificationList.empty();

            if (response.status === 'success') {
                response.notifications.forEach(function (notification) {
                    var listItem = `
                        <li class="dropdown-item">
                            <button type="button" class="open-notif" data-bs-toggle="modal" data-bs-target="#modalNotification" data-student-id="${notification.student_number}" data-activity-id="${notification.activity_id}">
                                <div class="notif-content">
                                    <img src="../../src/css/images/student-images/${notification.user_information ? notification.user_information.user_photo : 'default-image.jpg'}" class="display-photo" alt="Image">
                                    <p class="m-0 ms-1">${notification.student_number} requested credentials.</p>
                                    <p class="notif-time">${notification.sent_at}</p>
                                </div>
                            </button>
                            <div class="dropdown me-2">
                                <button class="notif-option-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu notif-menu">
                                    <li><button type="button" data-notif-id="${notification.notification_id}" class="markread-notification dropdown-item">Mark as Read</button></li>
                                    <li><button type="button" data-notif-id="${notification.notification_id}" class="remove-notif dropdown-item">Remove Notification</button></li>
                                </ul>
                            </div>
                        </li>
                    `;
                    notificationList.append(listItem);
                });
            } else {
                // Display the 'no notifications' message
                notificationList.addClass('d-flex align-items-center justify-content-center');
                notificationList.html('<li class="text-muted fw-bold"><p>Currently, there are no notifications.</p></li>');
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", error);
        }
    });

    $(document).on('click', '.open-notif', function () {
        var button = $(this);
        var request_id = button.data('activity-id');
        var student_number = button.data('student-id');
        $.ajax({
            url: "../../actions/get-student-credential.php",
            type: 'POST',
            data: { request_id: request_id,
                    student_number: student_number},
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    var student_info = response.student_info[0];
                    var modalDialog = $('#modalNotificationDialog');
                    var modalContent = `
                        <div class="modal-content">
                            <div class="modal-header" data-request-id="${student_info.request_id}">
                                <h1 class="modal-title fs-5">${student_info.student_number} | ${student_info.student_name}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-green fw-semibold">Credentials Requested</h5>
                                <ul class="text-green">
                                    ${student_info.student_requested.split(',').map(item => `<li>${item}</li>`).join('')}
                                </ul>
                                <h5 class="text-green fw-semibold">Remarks</h5>
                                <textarea id="registrarRemarks" cols="30" rows="5">You are now welcome to visit the school's registrar office. Kindly ensure to bring along a request letter with you.</textarea>
                                <select class="form-select">
                                    <option selected>Select status</option>
                                    <option value="Done">Done</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="modal-opt-btn btn-save">Save changes</button>
                            </div>
                        </div>
                    `;
                    if (modalDialog.children().length > 0) {
                        modalDialog.empty();
                    }
                    modalDialog.append(modalContent);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });
}

// Display Sections in Table
function displaySections() {
    var tables = $('.sectionsTable');
    tables.each(function() {
        var table = $(this);
        var year_level = table.find('tbody').data('year-level');
        $.ajax({
            method: "POST",
            url: "../../actions/get-sections.php",
            data: { year_level: year_level },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    var tbody = table.find('tbody');
                    tbody.empty();
                    response.section_info.forEach(function(section) {
                        var tableContentHTML = `
                            <tr class="text-center align-middle" data-year-level="${year_level}">
                                <td class="section">${section.user_section}</td>
                                <td>
                                    <button class="btn btn-view-subjects" data-bs-toggle="modal" data-bs-target="#modalSubjects"><i class="bi bi-pencil-square"></i></button>
                                </td>
                            </tr>
                        `;
                        tbody.append(tableContentHTML);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    });
}

// Upload Student Grades
function uploadGrades() {
    // Modal View Subjects
    $(document).on('click', '.btn-view-subjects', function () {
        var button = $(this);
        var year_level = button.closest('tr').data('year-level');
        var section = button.closest('tr').find('.section').text();
        var student_section = section.substring(1);
        var modalDialog = $('#viewSubjectsDialog');
        var modalContent = '';


        // NEED TO ADD THE GRADE 11 AND 12
        // UPLOAD GRADES FOR THIS


        if (year_level === 7 || year_level === 8 || year_level === 9 || year_level === 10) {
            modalContent = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Grade ${year_level} | ${section}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered border-success align-middle text-center">
                            <thead>
                                <tr>
                                    <th class="table-success border-success">Subjects</th>
                                    <th class="table-success border-success">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="subject">Araling Panlipunan</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Arts</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">English</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Edukasyon sa Pagpapakatao (EsP)</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Filipino</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Health</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Math</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Music</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Physical Education</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Science</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        } else if (year_level === 11 && student_section === 'ABM') {
            modalContent = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Grade ${year_level} | ${section}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered border-success align-middle text-center">
                            <thead>
                                <tr>
                                    <th class="table-success border-success">Subjects</th>
                                    <th class="table-success border-success">1st Sem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="subject">Oral Communication</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">General Mathematics</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Earth and Life Science</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Personal Development</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Understanding Culture, Society and Politics</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Physical Education and Health</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">English for Academic and Professional Purposes</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Research in Daily Life 1</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered border-success align-middle text-center mt-4">
                            <thead>
                                <tr>
                                    <th class="table-success border-success">Subjects</th>
                                    <th class="table-success border-success">2nd Sem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="subject">Reading and Writing Skills</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Pagbasa at Pagsusuri ng Iba't-Ibang Teksto Tungo sa Pananaliksik</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Statistics and Probability</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Physical Science</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Physical Education and Health</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Empowerment Technologies</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Business Math</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Fundamentals of Accountancy Business and Management 1</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subject">Organization and Management</td>
                                    <td>
                                        <button class="btn btn-view-grades" data-bs-toggle="modal" data-bs-target="#modalViewGrades"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUploadGrades"><i class="bi bi-upload"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        } else {
            modalDialog.empty();
        }

        if (modalDialog.children().length > 0) {
            modalDialog.empty();
        }
        modalDialog.append(modalContent);
    });

    // Modal Upload
    $(document).on('click', '.btn-upload', function () {
        var button = $(this);
        var subject = button.closest('tr').find('.subject').text();
        var year_level = button.closest('.modal-content').find('.modal-title').text().match(/Grade (\d+)/)[1];
        var section = button.closest('.modal-content').find('.modal-title').text().match(/\| (.+)/)[1];

        var modalDialog = $('#modalUploadGradesDialog');
        var modalContent = `
            <div class="modal-content">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Upload Grades | Grade ${year_level} | ${section}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" class="input-excel" name="excelFile" accept=".xls, .xlsx">
                        <div class="d-flex justify-content-center mt-3" id="loadSpinner"></div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="modal-opt-btn" data-bs-toggle="modal" data-bs-target="#modalSubjects">Go Back</button>
                        <button type="submit" class="modal-opt-btn upload-grades-btn" data-subject="${subject}" data-section="${section}" data-year="${year_level}">Upload</button>
                    </div>
                </form>
            </div>
        `;
        if (modalDialog.children().length > 0) {
            modalDialog.empty();
        }
        modalDialog.append(modalContent);
    });

    // Upload Form
    $(document).on('submit', '#uploadForm', function (event) {
        event.preventDefault();
        var button = $(this);
        var modal = button.closest('#modalUploadGrades');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');
        var spinner = $('<div class="spinner-border text-success text-center" role="status"></div>');

        var studentsSection = $(this).find('.upload-grades-btn').data('section');
        var yearLevel = $(this).find('.upload-grades-btn').data('year');
        var studentSubject = $(this).find('.upload-grades-btn').data('subject');
        

        var formData = new FormData(this);
        formData.append('yearLevel', yearLevel);
        formData.append('studentsSection', studentsSection);
        formData.append('studentSubject', studentSubject);

        modal.find('button, input').prop('disabled', true);
        modalBody.find('#loadSpinner').append(spinner);

        $.ajax({
            url: "../../actions/registrar-grades-upload.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                spinner.remove();
                if (response.status === 'error') {
                    modal.find('button, input').prop('disabled', false);
                    if (errorContent.length) {
                        errorContent.text(response.message);
                    } else {
                        errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
                        modalBody.append(errorContent);
                    }
                    errorContent.fadeIn(400).delay(3000).fadeOut(400, function () {
                        errorContent.remove();
                    });
                } else {
                    modal.find('button, input').prop('disabled', true);

                    var contentHTML = `<p class="mb-0 mt-3 text-success text-center fw-bold">${response.message}</p>`;
                    modalBody.append(contentHTML);

                    setTimeout(function () {
                        modal.modal('hide');
                    }, 3000);
                }
            },
            error: function (xhr, status, error) {
                // Hide spinner
                spinner.remove();
                modal.find('button, input').prop('disabled', false);
                console.log("AJAX Error:", error);
            }
        });
    });
}

function viewGrades() {
    // Modal View Uploaded Grades
    $(document).on('click', '.btn-view-grades', function () {
        var button = $(this);
        var modalTitle = button.closest('.modal-content').find('.modal-title').text();
        var parts = modalTitle.split('|');
    
        var year_level = parts[0].trim();
        var section = parts[1].trim();
        var subject = button.closest('tr').find('.subject').text();
        var currentPage = 1;
        $('.page-q1').addClass('active');
        $('.page-q2, .page-q3, .page-q4').removeClass('active');

    $('.page-q1').on('click', function (event) {
        event.preventDefault();
        $('.page-q1').addClass('active');
        $('.page-q2, .page-q3, .page-q4').removeClass('active');
        fetchStudentGrades(currentPage, year_level, section, subject, 1);
    });

    $('.page-q2').on('click', function (event) {
        event.preventDefault();
        $('.page-q2').addClass('active');
        $('.page-q1, .page-q3, .page-q4').removeClass('active');
        fetchStudentGrades(currentPage, year_level, section, subject, 2);
    });

    $('.page-q3').on('click', function (event) {
        event.preventDefault();
        $('.page-q3').addClass('active');
        $('.page-q1, .page-q2, .page-q4').removeClass('active');
        fetchStudentGrades(currentPage, year_level, section, subject, 3);
    });

    $('.page-q4').on('click', function (event) {
        event.preventDefault();
        $('.page-q4').addClass('active');
        $('.page-q1, .page-q2, .page-q3').removeClass('active');
        fetchStudentGrades(currentPage, year_level, section, subject, 4);
    });

        // Initially fetch data for Quarter 1
        fetchStudentGrades(currentPage, year_level, section, subject, 1);
    });
}

// Fetch student grades for the selected quarter
function fetchStudentGrades(currentPage, year_level, section, subject, quarter) {
    $.ajax({
        method: "POST",
        url: "../../actions/get-student-grades.php",
        data: {
            year_level: year_level,
            student_subject: subject,
            student_section: section,
            quarter: `Q${quarter}`
        },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                $('#studentSubject').text(subject);
                $('#currentPage').text(`Quarter ${quarter}`);
                generateGradeRows(response.student_data, currentPage);
            } else {
                $('#tableBody').html('<tr><td colspan="14">No data available.</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", error);
        }
    });
}

function generateGradeRows(studentData, currentPage) {
    var subjectWrittenWorks = studentData.student_written_works;
    var subjectPerformanceTasks = studentData.student_performance_tasks;
    var subjectExam = studentData.student_exam;

    if (subjectWrittenWorks.length === 0 && subjectPerformanceTasks.length === 0 && subjectExam.length === 0) {
        $('#tableBody').html(`<tr><td colspan="40" class="text-danger fw-semibold">No grades currently uploaded.</td></tr>`);
    } else {
        var startIndex = (currentPage - 1) * 20;
        var endIndex = startIndex + 19;
        var rows = '';
    
        for (var i = startIndex; i <= endIndex; i++) {
            if (i >= subjectWrittenWorks.length) {
                break;
            }
    
            var wwData = subjectWrittenWorks[i];
            var ptData = subjectPerformanceTasks[i];
            var exData = subjectExam[i];
    
            rows += '<tr>';
    
            $.each(["student_name", "w1", "w2", "w3", "w4", "w5", "w6", "w7", "w8", "w9", "w10", "total", "pw", "ws"], function (index, columnName) {
                rows += `<td>${wwData[columnName]}</td>`;
            });
    
            $.each(["p1", "p2", "p3", "p4", "p5", "p6", "p7", "p8", "p9", "p10", "total", "pw", "ws"], function (index, columnName) {
                rows += `<td>${ptData[columnName] || ''}</td>`;
            });
    
            $.each(["exam_score", "pw", "ws", "initial_grade", "quarterly_grade"], function (index, columnName) {
                var cellValue = exData[columnName] || '';

                if (columnName === 'quarterly_grade') {
                    rows += `<td class="fw-bold text-danger">${cellValue}</td>`;
                } else {
                    rows += `<td>${cellValue}</td>`;
                }
            });
    
            rows += '</tr>';
        }
    
        // Update the table body
        $('#tableBody').html(rows);
    }

}

function goToStudentPage() {
    $(document).on('click', '#manageStudentPage', function () {
        var year_level = $(this).data('year-level')
        var studentPage = '/sfdss-portal/pages/registrar-side/registrar-manage-students-page.php?year_level=' + year_level;
        window.location.href = studentPage;
    });
}

function handleSections() {
    manageSections();
    removeSelectedSection();
    removeAllSections();

    function manageSections() {
        var year_level = $('.registrar-side-page').data('year-level');
        $.ajax({
            method: "POST",
            url: "../../actions/get-students.php",
            data: { year_level },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    var table = $("#tableBody");
                    var tableContentHTML = '';
    
                    if (response.student_info.length === 0) {
                        tableContentHTML += `
                            <tr>
                                <td colspan="5" class="no-data-table text-center text-danger fw-semibold">There are currently no student/s to display.</td>
                            </tr>
                        `;
                    } else {
                        $.each(response.student_info, function (i, info) {
                            var section = '';

                            if (info.user_year_level === 'Grade 11' || info.user_year_level === 'Grade 12') {
                                section = `<td>${info.user_section.charAt(0)}-${info.user_section.substring(1)}</td>`;
                            } else {
                                section = `<td>${info.user_section}</td>`;
                            }

                            tableContentHTML += `
                                <tr data-students-section="${info.user_section}">
                                    <td><input type="checkbox" class="section-checkbox" class="row-checkbox"></td>
                                    ${section}
                                    <td>
                                        <button class="btn btn-edit-section" data-bs-toggle="modal" data-bs-target="#modalEditSection">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    table.append(tableContentHTML);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });
    
        // Search
        function filterTable(searchQuery) {
            var rows = $('#tableBody tr[data-students-section]');
            var existingRows = $('#tableBody tr .no-data-table');
            var lowerSearchQuery = searchQuery.toLowerCase();
            var anyMatch = false;
        
            rows.each(function () {
                var row = $(this);
                var studentSection = row.data('students-section').toString().toLowerCase();
        
                if (studentSection.includes(lowerSearchQuery)) {
                    row.removeClass('d-none');
                    anyMatch = true;
                } else {
                    row.addClass('d-none');
                }
            });
        
            if (anyMatch) {
                $('#noResultsRow').addClass('d-none');
            } else {
                existingRows.remove();
                $('#noResultsRow').removeClass('d-none');
            }
        }
        
        $('#searchInput').on('input', function () {
            var searchQuery = $(this).val();
            filterTable(searchQuery);
        });
    
        // Filter Table
        $('.table-responsive .dropdown-item').click(function (e) {
            e.preventDefault();
            var sortType = $(this).data('sort-type');
            sortTable(sortType);
        });
    
        function sortTable(sortType) {
            var table = $('#tableBody');
            var tableRows = table.find('tr');
            tableRows.sort(function (a, b) {
                var valueA, valueB;
    
                switch (sortType) {
                    case 'az':
                        valueA = $(a).find('td:nth-child(2)').text().toUpperCase();
                        valueB = $(b).find('td:nth-child(2)').text().toUpperCase();
                        return valueA.localeCompare(valueB);
    
                    case 'za':
                        valueA = $(a).find('td:nth-child(2)').text().toUpperCase();
                        valueB = $(b).find('td:nth-child(2)').text().toUpperCase();
                        return valueB.localeCompare(valueA);

                    default:
                        return 0;
                }
            });
    
            tableRows.detach().appendTo(table);
        }
    }

    // Remove Selected
    function removeSelectedSection() {
        toggleRemoveSelectedButton();
        var selectedSections = [];
    
        function toggleRemoveSelectedButton() {
            if ($('.section-checkbox:checked').length > 0) {
                $('#removeSelected').removeClass('d-none');
            } else {
                $('#removeSelected').addClass('d-none');
            }
        }
    
        $(document).on('change', '.section-checkbox', function () {
            toggleRemoveSelectedButton();
        });
    
        $(document).on('click', '#removeSelected', function () {
            selectedSections = [];
    
            $('.section-checkbox:checked').each(function () {
                var studentSection = $(this).closest('tr').data('students-section');
                selectedSections.push(studentSection);
            });
    
            if (selectedSections.length > 0) {
                $('#confirmationModal').modal('show');
            }
        });
    
        $(document).on('click', '.confirm-remove-section-btn', function () {
            var year_level = $('.manage-student-page').data('year-level');
            var modal = $(this).closest('#modalRemoveSelectedSections');
            var modalBody = modal.find('.modal-body p');
            var errorContent = modal.find('.text-danger');

            $.ajax({
                url: "../../actions/admin-remove-sections.php",
                method: 'POST',
                data: { selected_sections: selectedSections,
                        year_level: year_level },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        modalBody.text("Selected users have been removed successfully.");
                        $('#modalRemoveSelectedSections').modal('show');
    
                        modal.find('button').prop('disabled', true);
                        $('.section-checkbox:checked').closest('tr').remove();
                        $('#removeSelected').addClass('d-none');
                        modal.find('button').prop('disabled', true);

                        setTimeout(function () {
                            modal.modal('hide');
                        }, 2000);
                    } else {
                        if (errorContent.length) {
                            errorContent.text(response.message);
                        } else {
                            errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
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

    // Remove All
    function removeAllSections() {
        // Select All
        $('#selectAll').on('click', function () {
            var isChecked = $(this).prop('checked');
            $('.section-checkbox').prop('checked', isChecked);

            if (isChecked) {
                $('#removedAll').removeClass('d-none');
            } else {
                $('#removedAll').addClass('d-none');
            }
        });

        // Remove All - Show Confirmation Modal
        $('#removeAll').on('click', function () {
            $('#confirmationModal').modal('show');
        });

        // Confirmation Modal for Remove All
        $(document).on('click', '.remove-all-sections-confirm', function () {
            var allSections = [];
            var year_level = $('.manage-student-page').data('year-level');

            var modal = $(this).closest('#modalRemoveSections');
            var modalBody = modal.find('.modal-body');
            var errorContent = modal.find('.text-danger');

            $('.section-checkbox').each(function () {
                var studentSection = $(this).closest('tr').data('students-section');
                allSections.push(studentSection);
            });

            $.ajax({
                url: "../../actions/admin-remove-sections.php",
                method: 'POST',
                data: { selected_sections: allSections,
                        year_level: year_level },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        var tableBody = $('#tableBody');
                        var tr = `
                            <tr>
                                <td colspan="5" class="no-data-table text-center text-danger fw-semibold">There are currently no students to display.</td>
                            </tr>
                        `;
                        tableBody.empty().append(tr);
                        $('#modalRemoveSections .modal-body p').text("All selected users have been removed successfully.");
                        $('#removedAllSections').addClass('d-none');
                        $('#selectAll').prop('checked', false);
                        $('#modalRemoveSections').find('button').prop('disabled', true);

                        setTimeout(function () {
                            $('#modalRemoveSections').modal('hide');
                        }, 2000);
                    } else {
                        if (errorContent.length) {
                            errorContent.text(response.message);
                        } else {
                            errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
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
}

function addSection() {
    $(document).on('submit', '#addSectionForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var modal = form.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');

        var year_level = $('.registrar-side-page').data('year-level');
        var sectionName = $('#sectionName').val();
        var excelFile = $('#excelFile')[0].files[0];

        var formData = new FormData();
        formData.append('section_name', sectionName);
        formData.append('year_level', year_level);
        formData.append('excelFile', excelFile);

        $.ajax({
            url: '../../actions/add-new-section.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
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
                console.log('AJAX Error:', error);
            }
        });
    });
}

function viewStudents() {
    removeSelectedStudents();
    removeAllStudents();
    $(document).on('click', '.btn-edit-section', function () {
        var year_level = $('.manage-student-page').data('year-level');
        var section = $(this).closest('tr').data('students-section');
        var modalDialog = $('#editSectionDialog');
        var tableBody = modalDialog.find('#tableSectionsBody');

        $.ajax({
            url: "../../actions/get-students-data.php",
            method: 'POST',
            data: { section: section,
                    year_level: year_level},
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var student_info = response.student_info;
                    modalDialog.find('.modal-title').text(section);
                    tableBody.empty();

                    student_info.forEach(function (student) {
                        var row = `
                            <tr data-student-number=${student.user_id}>
                                <td><input type="checkbox" class="student-checkbox" class="row-checkbox"></td>
                                <td>${student.user_id}</td>
                                <td>${student.user_name}</td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });
                } else {
                    tableBody.html('<tr><td colspan="3" class="text-danger fw-semibold">No result found</td></tr>');
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", error);
            }
        });

        // Search
        $('#searchStudent').on('input', function () {
            var searchQuery = $(this).val();
            filterTable(searchQuery);
        });

        function filterTable(searchQuery) {
            var rows = modalDialog.find('#tableSectionsBody tr[data-student-number]');
            var lowerSearchQuery = searchQuery.toLowerCase();
            var anyMatch = false;
        
            rows.each(function () {
                var row = $(this);
                var studentNumber = row.data('student-number').toString().toLowerCase();
                var studentName = row.find('td:nth-child(2)').text().toLowerCase();
        
                if (studentNumber.includes(lowerSearchQuery) || studentName.includes(lowerSearchQuery)) {
                    row.removeClass('d-none');
                    anyMatch = true;
                } else {
                    row.addClass('d-none');
                }
            });
        
            var noResultRow = tableBody.find('.no-result-row');
        
            if (!anyMatch) {
                if (noResultRow.length === 0) {
                    tableBody.append('<tr class="no-result-row"><td colspan="3" class="text-danger fw-semibold">No result found</td></tr>');
                }
            } else {
                noResultRow.remove();
                $('#sectionNoResultsRow').addClass('d-none');
            }
        }
    });

    // Remove Selected
    function removeSelectedStudents() {
        toggleRemoveSelectedButton();
        var selectedStudents = [];
    
        function toggleRemoveSelectedButton() {
            if ($('.student-checkbox:checked').length > 0) {
                $('#removeSelectedStudents').removeClass('d-none');
            } else {
                $('#removeSelectedStudents').addClass('d-none');
            }
        }
    
        $(document).on('change', '.student-checkbox', function () {
            toggleRemoveSelectedButton();
        });
    
        $(document).on('click', '#removeSelectedStudents', function () {
            selectedStudents = [];
    
            $('.student-checkbox:checked').each(function () {
                var studentNumber = $(this).closest('tr').data('student-number');
                selectedStudents.push(studentNumber);
            });
    
            if (selectedStudents.length > 0) {
                $('#confirmationModal').modal('show');
            }
        });
    
        $(document).on('click', '.confirm-remove-students-btn', function () {
            var year_level = $('.manage-student-page').data('year-level');
            var modal = $(this).closest('#modalRemoveSelectedStudents');
            var modalBodyPText = modal.find('.modal-body p');
            var modalBody = modal.find('.modal-body');
            var errorContent = modalBody.find('.text-danger');
        
            $.ajax({
                url: "../../actions/admin-remove-students.php",
                method: 'POST',
                data: { selected_users: selectedStudents,
                        year_level: year_level },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        modalBodyPText.text("Selected users have been removed successfully.");
        
                        modal.find('button').prop('disabled', true);
                        $('.student-checkbox:checked').closest('tr').remove();
                        $('#removeSelectedStudents').addClass('d-none');
                        modal.find('button').prop('disabled', true);
        
                        setTimeout(function () {
                            modal.modal('hide');
                        }, 2000);
                    } else {
                        if (errorContent.length) {
                            errorContent.text(response.message);
                        } else {
                            errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
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

    // Remove All
    function removeAllStudents() {
        // Select All
        $('#selectAllStudents').on('click', function () {
            var isChecked = $(this).prop('checked');
            $('.student-checkbox').prop('checked', isChecked);

            if (isChecked) {
                $('#removedAllStudents').removeClass('d-none');
            } else {
                $('#removedAllStudents').addClass('d-none');
            }
        });

        // Remove All - Show Confirmation Modal
        $('#removedAllStudents').on('click', function () {
            $('#confirmationModal').modal('show');
        });

        // Confirmation Modal for Remove All
        $(document).on('click', '.remove-all-students-confirm', function () {
            var allStudents = [];
            var year_level = $('.manage-student-page').data('year-level');
            var modal = $(this).closest('#modalRemoveStudents');
            var modalBody = modal.find('.modal-body');
            var errorContent = modal.find('.text-danger');

            $('.student-checkbox').each(function () {
                var studentNumber = $(this).closest('tr').data('student-number');
                allStudents.push(studentNumber);
            });

            $.ajax({
                url: "../../actions/admin-remove-students.php",
                method: 'POST',
                data: { selected_users: allStudents,
                        year_level: year_level },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        var tableSectionsBody = $('#tableSectionsBody');
                        var tr = `
                            <tr>
                                <td colspan="5" class="no-data-table text-center text-danger fw-semibold">There are currently no students to display.</td>
                            </tr>
                        `;
                        tableSectionsBody.empty().append(tr);
                        $('#modalRemoveStudents .modal-body p').text("All selected users have been removed successfully.");
                        $('#removedAllStudents').addClass('d-none');
                        $('#selectAllStudents').prop('checked', false);
                        $('#modalRemoveStudents').find('button').prop('disabled', true);

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        if (errorContent.length) {
                            errorContent.text(response.message);
                        } else {
                            errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">'+ response.message +'</p>');
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
}

function addNewStudents() {
    var dynamicInputs = $('#dynamicInputs');
    var addStudentsForm = $('#addStudentsForm');

    // Add a new input field
    $('#addInput').click(function () {
        var newStudentHTML = `
            <div class="form-group my-3">
                <input type="text" class="form-control" name="studentNumber[]" placeholder="Student Number" autocomplete="off">
                <input type="text" class="form-control" name="studentName[]" placeholder="Student Name" autocomplete="off">
                <button type="button" class="remove-added-student"><i class="bi bi-x-lg"></i></button>
            </div>
        `;
        dynamicInputs.append(newStudentHTML);

        $('.remove-added-student').click(function () {
            $(this).parent().remove();
        });
    });

    // Reset Modal
    $('#modalAddStudents').on('hidden.bs.modal', function () {
        addStudentsForm.trigger('reset');
        dynamicInputs.empty();
    });

    $(document).on('submit', '#addStudentsForm', function (event) {
        event.preventDefault();
        var modal = $(this).closest('#modalAddStudents');
        var modalBody = modal.find('.modal-body');
        var errorContent = modal.find('.text-danger');
    
        // Check if any student names and numbers are entered
        var studentNames = $(this).find('input[name="studentName[]"]');
        var studentNumbers = $(this).find('input[name="studentNumber[]"]');
        var hasStudentData = false;
    
        studentNames.each(function (index) {
            if ($(this).val().trim() !== '' && studentNumbers.eq(index).val().trim() !== '') {
                hasStudentData = true;
                return false;
            }
        });
    
        if (!hasStudentData) {
            // Display an error message if no student names and numbers are entered
            if (errorContent.length) {
                errorContent.text('Please enter both student name and student number for at least one student.');
            } else {
                errorContent = $('<p class="mb-0 mt-3 text-danger text-center fw-bold">Please enter both student name and student number for at least one student.</p>');
                modalBody.append(errorContent);
            }
            errorContent.fadeIn(400).delay(3000).fadeOut(400, function () {
                errorContent.remove();
            });
            return; // Exit the function
        }
    
        var yearLevel = $('.registrar-side-page').data('year-level');
        var section = $('#modalEditSection').find('.modal-title').text();
    
        var formData = $(this).serializeArray();
        formData.push({ name: 'yearLevel', value: yearLevel });
        formData.push({ name: 'section', value: section });
    
        $.ajax({
            url: '../../actions/admin-add-new-student.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    modal.find('button').prop('disabled', true);
                    modal.find('.text-danger').addClass('d-none');
    
                    var successMessage = $('<p class="text-success text-center fw-bold">').text(response.message);
                    modal.find('.modal-body').append(successMessage);
    
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
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
                console.log('AJAX Error:', error);
            }
        });
    });
}