$(document).ready(function () {
    loadEvents();
    addEvent();
    editEvent();
    goToStudentPage();
    handleSections();
    viewStudents();
    addNewStudents();
    addSection();
    createPost();
    loadPosts();
    deletePost();
    editPost();
});

function loadEvents() {
    // Loop through months and check if the event list is empty
    var months = [
        "january", "february", "march", "april", "may", "june", "july",
        "august", "september", "October", "november", "december"
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

                    var eventHTML = `
                        <li>
                            ${day} - ${event.event_name}
                        </li>
                        <button type="button" class="btn btn-success edit-event-btn" data-bs-toggle="modal" data-bs-target="#editEvent">View</button>
                    `;
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

function addEvent() {
    $(document).on('click', '.add-event-btn', function () {
        var modalDialog = $('#addEventDialog');
        var contentHTML = `
            <div class="modal-content text-green">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold">Add New Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-sm">
                            <p class="m-0 fw-bold">Event Name</p>
                            <input type="text" class="modal-input" id="eventName" placeholder="Add event name here" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm">
                            <p class="m-0 fw-bold">Select Event Month</p>
                            <select class="form-select" id="selectedMonth">
                                <option selected>Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <p class="m-0 fw-bold">Start Event Date</p>
                            <input type="date" id="starEventDate">
                        </div>
                        <div class="col-sm">
                            <p class="m-0 fw-bold">End Event Date</p>
                            <input type="date" id="endEventDate">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="modal-opt-btn confirm-event">Save</button>
                </div>
            </div>
        `;
        if (modalDialog.children().length > 0) {
            modalDialog.empty();
        }
        modalDialog.append(contentHTML);

        var selectedMonthInput = $('#selectedMonth');
        var startEventDateInput = $('#starEventDate');

        selectedMonthInput.on('change', function () {
            var selectedMonth = selectedMonthInput.val();

            if (selectedMonth) {
                var year = new Date().getFullYear();
                var month = (getMonthIndex(selectedMonth) + 1).toString().padStart(2, '0');
                var day = '01';
                var formattedDate = `${year}-${month}-${day}`;
                startEventDateInput.val(formattedDate);
            }
        });

        function getMonthIndex(selectedMonth) {
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            return months.indexOf(selectedMonth);
        }
    });

    $(document).on('click', '.confirm-event', function () {
        var button = $(this);
        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');

        var eventName = $('#eventName').val();
        var selectedMonth = $('#selectedMonth').val();
        var starEventDate = $('#starEventDate').val();
        var endEventDate = $('#endEventDate').val();

        $.ajax({
            url: '../../actions/admin-add-event.php',
            type: 'POST',
            data: { event_name: eventName,
                    selected_month: selectedMonth,
                    star_date: starEventDate,
                    end_date: endEventDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    modal.find('button, input, select').prop('disabled', true);

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
                console.log('AJAX Error:', error);
            }
        });
    });
}

function editEvent() {
    $(document).on('click', '.edit-event-btn', function () {
        var button = $(this);
        var monthName = button.closest('.card').find('.card-title').text();
        var modalDialog = $('#editEventDialog');
    
        $.ajax({
            url: '../../actions/get-all-events.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var contentHTML = `
                        <div class="modal-content text-green">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold">${monthName}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="eventList" class="event-list"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modal-opt-btn" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    `;
                    if (modalDialog.children().length > 0) {
                        modalDialog.empty();
                    }
                    modalDialog.append(contentHTML);
    
                    var ulId = button.closest('.card').find('.event-list').attr('id');
                    var modalList = modalDialog.find('#eventList');
                    $('#' + ulId + ' li').each(function () {
                        var listItemText = $(this).text();
                        var eventID = null;
    
                        var numberMatch = listItemText.match(/^\d+/);
                        var number = numberMatch ? numberMatch[0] : '';
    
                        var getlistItemText = listItemText.trim().replace(/^\d+\s*-\s*/, '');
    
                        $.each(response.events_info, function (i, event_info) {
                            if (event_info.event_name === getlistItemText) {
                                eventID = event_info.event_id;
                                return false;
                            }
                        });

                        if (getlistItemText !== 'Currently, there are no scheduled events.') {
                            var liHTML = `
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="m-0">${number ? number + ' - ' : ''}${listItemText}</p>
                                    ${eventID ? `<button class="change-event-btn" data-event-id="${eventID}" data-bs-target="#changeEvent" data-bs-toggle="modal">Change</button>` : ''}
                                </div>
                            `;
                        } else {
                            var liHTML = `
                                <div class="d-flex justify-content-center">
                                    <p class="m-0 text-danger text-center fw-semibold">${listItemText}</p>
                                </div>
                            `;
                        }
                        modalList.append(liHTML);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });

    $(document).on('click', '.change-event-btn', function () {
        var button = $(this);
        var event_id = button.data('event-id')
        var modalDialog = $('#changeEventDialog');

        $.ajax({
            url: '../../actions/get-event.php',
            type: 'POST',
            data: { event_id: event_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var event_info = response.event_info[0];
                    var contentHTML = `
                        <div class="modal-content text-green">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold">${event_info.event_name}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-sm">
                                        <p class="m-0 fw-bold">Event Name</p>
                                        <input type="text" class="modal-input" id="eventName" value="${event_info.event_name}" placeholder="Add event name here" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm">
                                        <p class="m-0 fw-bold">Select Event Month</p>
                                        <select class="form-select" id="selectedMonth">
                                            ${generateMonthOptions(event_info.event_month)}
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <p class="m-0 fw-bold">Start Event Date</p>
                                        <input type="date" id="starEventDate" value="${event_info.event_start_date}">
                                    </div>
                                    <div class="col-sm">
                                        <p class="m-0 fw-bold">End Event Date</p>
                                        <input type="date" id="endEventDate" value="${event_info.event_end_date}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modal-opt-btn" data-bs-target="#editEvent" data-bs-toggle="modal">Go Back</button>
                                <button type="button" class="modal-opt-btn confirm-edit" data-event-id=${event_id}>Save changes</button>
                            </div>
                        </div>
                    `;
                    if (modalDialog.children().length > 0) {
                        modalDialog.empty();
                    }
                    modalDialog.append(contentHTML);

                    var selectedMonthInput = $('#selectedMonth');
                    var startEventDateInput = $('#starEventDate');

                    selectedMonthInput.on('change', function () {
                        var selectedMonth = selectedMonthInput.val();
            
                        if (selectedMonth) {
                            var year = new Date().getFullYear();
                            var month = (getMonthIndex(selectedMonth) + 1).toString().padStart(2, '0');
                            var day = '01';
                            var formattedDate = `${year}-${month}-${day}`;
                            startEventDateInput.val(formattedDate);
                        }
                    });
            
                    function getMonthIndex(selectedMonth) {
                        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        return months.indexOf(selectedMonth);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });

        // Function to generate month options
        function generateMonthOptions(selectedMonth) {
            var months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            var options = '';

            for (var i = 0; i < months.length; i++) {
                var month = months[i];
                if (month === selectedMonth) {
                    options += `<option value="${month}" selected>${month}</option>`;
                } else {
                    options += `<option value="${month}">${month}</option>`;
                }
            }

            return options;
        }
    });

    $(document).on('click', '.confirm-edit', function () {
        var button = $(this);
        var event_id = button.data('event-id')
        var eventName = $('#eventName').val();
        var selectedMonth = $('#selectedMonth').val();
        var starEventDate = $('#starEventDate').val();
        var endEventDate = $('#endEventDate').val();

        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');

        $.ajax({
            url: '../../actions/admin-update-event.php',
            type: 'POST',
            data: { event_id: event_id,
                    event_name: eventName,
                    selected_month: selectedMonth,
                    star_date: starEventDate,
                    end_date: endEventDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    modal.find('button, input, select').prop('disabled', true);

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
                console.log('AJAX Error:', error);
            }
        });
    });
}

function goToStudentPage() {
    $(document).on('click', '#manageStudentPage', function () {
        var year_level = $(this).data('year-level')
        var studentPage = '/sfdss-portal/pages/admin-side/admin-manage-students.php?year_level=' + year_level;
        window.location.href = studentPage;
    });
}

function handleSections() {
    manageSections();
    removeSelectedSection();
    removeAllSections();

    function manageSections() {
        var year_level = $('.admin-side-page').data('year-level');
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
                                        <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditSection">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    table.html(tableContentHTML);
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

function viewStudents() {
    removeSelectedStudents();
    removeAllStudents();
    $(document).on('click', '.btn-edit', function () {
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
    
        var yearLevel = $('.admin-side-page').data('year-level');
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

function addSection() {
    $(document).on('submit', '#addSectionForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var modal = form.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');

        var year_level = $('.admin-side-page').data('year-level');
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

function createPost() {
    $(document).on('click', '#createPost', function () {
        var button = $(this);
        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');
        var postDescriptionInput = $('#postDescription');
        var post_description = postDescriptionInput.val();

        $.ajax({
            url: '../../actions/admin-create-post.php',
            type: 'POST',
            data: { post_description },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var postedFeeds = $('#postedFeeds');
                    var feedHTML = `
                        <div class="posted-feeds my-3" data-post-id="${response.post_id}">
                            <div class="admin-info">
                                <img src="../../src/css/images/student-images/default-image.png" alt="Image">
                                <p class="mb-0 fw-semibold">Admin</p>
                                <div class="posted-date">${response.user_posted_date}</div>
                                <div class="dropdown post-option">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button type="button" class="dropdown-item edit-post-modal" data-bs-toggle="modal" data-bs-target="#modalEditPost">Edit</button></li>
                                        <li><button class="dropdown-item delete-post-btn">Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-description">
                                <p class="mb-0 mt-3">${response.post_description}</p>
                            </div>
                        </div>
                    `;

                    var contentHTML = $('<p class="mb-0 mt-3 text-success text-center fw-bold">' + response.message + '</p>');
                    modal.find('button, textarea').prop('disabled', true);
                    modalBody.append(contentHTML);
                    
                    contentHTML.fadeIn(400).delay(3000).fadeOut(400, function () {
                        postedFeeds.prepend(feedHTML);
                        contentHTML.remove();
                        modal.modal('hide');

                        postDescriptionInput.val('');
                        modal.find('button, textarea').prop('disabled', false);
                    });
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

function loadPosts() {
    $.ajax({
        url: '../../actions/get-admin-posts.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var posts = response.posts;
                var postedFeeds = $('#postedFeeds');
                postedFeeds.empty();

                for (var i = 0; i < posts.length; i++) {
                    var post = posts[i];
                    var postHTML = `
                        <div class="posted-feeds my-3" data-post-id="${post.post_id}">
                            <div class="admin-info">
                                <img src="../../src/css/images/student-images/default-image.png" alt="Image">
                                <p class="mb-0 fw-semibold">Admin</p>
                                <div class="posted-date">${post.user_posted_date}</div>
                                <div class="dropdown post-option">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button type="button" class="dropdown-item edit-post-modal" data-bs-toggle="modal" data-bs-target="#modalEditPost">Edit</button></li>
                                        <li><button class="dropdown-item delete-post-btn">Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-description">
                                <p class="mb-0 mt-3">${post.post_description}</p>
                            </div>
                        </div>
                    `;
                    postedFeeds.append(postHTML);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

function deletePost() {
    $(document).on('click', '.delete-post-btn', function () {
        var button = $(this);
        var post = button.closest('.posted-feeds');
        var post_id = post.data('post-id');

        $.ajax({
            url: '../../actions/admin-delete-post.php',
            type: 'POST',
            data: { post_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    post.fadeOut(400, function() {
                        post.remove();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });
}

function editPost() {
    $(document).on('click', '.edit-post-modal', function () {
        var button = $(this);
        var post = button.closest('.posted-feeds');
        var post_id = post.data('post-id');

        $.ajax({
            url: '../../actions/get-post.php',
            type: 'POST',
            data: { post_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var post = response.post[0];
                    $('#editPostDescription').val(post.post_description);
                    $('.edit-post-btn').attr('data-post-id', post.post_id);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });

    $(document).on('click', '.edit-post-btn', function () {
        var button = $(this);
        var modal = button.closest('.modal');
        var modalBody = modal.find('.modal-body');
        var errorContent = modalBody.find('.text-danger');
        var post_id = button.data('post-id');
        var post_description = $('#editPostDescription').val();
    
        $.ajax({
            url: '../../actions/admin-edit-post.php',
            type: 'POST',
            data: { post_id, post_description },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var contentHTML = $('<p class="mb-0 mt-3 text-success text-center fw-bold">' + response.message + '</p>');
                    modal.find('button, textarea').prop('disabled', true);
                    modalBody.append(contentHTML);

                    setTimeout(function () {
                        location.reload();
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