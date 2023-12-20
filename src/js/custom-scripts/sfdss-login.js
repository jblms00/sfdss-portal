$(document).ready(function () {
    portalLogin();
    loadEvents();
    loadNewsAnnouncements();

    $('.toggle-password').click(function () {
        var passwordInput = $('#userPassword');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });
});


function portalLogin() {
    $(document).on('submit', '#loginForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var messageStatus = form.find('#displayMessage');
        var userNumberInput = form.find('#userNumber');
        var userPasswordInput = form.find('#userPassword');
        var submitButton = form.find('button[type="submit"]');
        var links = form.closest('.index-page').find('a');
        var showPassword = form.find('#showPassword');

        form.find('.alert-danger').remove();
        userNumberInput.css('outline', '');
        userPasswordInput.css('outline', '');
        
        $.ajax({
            method: "POST",
            url: "actions/user-login.php",
            data: { 
                user_number: userNumberInput.val(),
                user_password: userPasswordInput.val() 
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    userNumberInput.prop('disabled', true);
                    userPasswordInput.prop('disabled', true);
                    submitButton.prop('disabled', true);
                    showPassword.prop('disabled', true);
                    links.on('click', function(event) {
                        event.preventDefault();
                    });
                    
                    var successMessage = $('<p class="alert alert-success p-2 text-center" data-aos="fade-left">Login Successfully!</p>').hide();
                    messageStatus.append(successMessage);
                    successMessage.fadeIn(100);

                    if (response.user_type === 'student') {
                        successMessage.delay(3000).fadeOut(function () {
                            window.location.href = 'pages/student-side/student-index-page.php';
                        });
                    } else if (response.user_type === 'registrar') {
                        successMessage.delay(3000).fadeOut(function () {
                            window.location.href = 'pages/registrar-side/registrar-index-page.php';
                        });
                    } else if (response.user_type === 'admin') {
                        successMessage.delay(3000).fadeOut(function () {
                            window.location.href = 'pages/admin-side/admin-index-page.php';
                        });
                    } 
                } else {
                    if (response.message === "Please enter your student number and password") {
                        userPasswordInput.css('outline', '2px solid #dc3545ba');
                        userNumberInput.css('outline', '2px solid #dc3545ba');
                    } else if (response.message === "Please enter your student number" || response.message === "Incorrect student number") {
                        userNumberInput.css({
                            'outline': '2px solid #dc3545ba',
                            'color': '#dc3545ba'
                        });
                    } else if (response.message === "Please enter your password" || response.message === "Incorrect password") {
                        userPasswordInput.css({
                            'outline': '2px solid #dc3545ba',
                            'color': '#dc3545ba'
                        });
                    }

                    var errorMessage = $('<p class="alert alert-danger p-2 text-center" data-aos="fade-left">' + response.message + '</p>').hide();
                    messageStatus.append(errorMessage);
                    errorMessage.fadeIn(100);
                    errorMessage.delay(3000).fadeOut(function () {
                        userNumberInput.css({
                            'outline': '',
                            'color': ''
                        });
                        userPasswordInput.css({
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
        url: '../actions/get-all-events.php',
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

function loadNewsAnnouncements() {
    $.ajax({
        url: '../actions/get-admin-posts.php',
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
                                <img src="../src/css/images/student-images/default-image.png" alt="Image">
                                <p class="mb-0 fw-semibold">Admin</p>
                                <div class="posted-date">${post.user_posted_date}</div>
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