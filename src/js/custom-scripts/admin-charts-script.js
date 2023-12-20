$(document).ready(function () {
    getJHStudents();
    getSHStudents();
});

let jhStudentChart;
let shStudentChart;

// Total JHS Students
function getJHStudents() {
    $.ajax({
        url: '../../actions/get-total-jhs-students.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                updateJHStudents(response.jhsStudents);
                updateJHStudentsGraph(response.activeCounts);
            } else {
                console.log('Error: ' + response.message);
            }
        },
        error: function () {
            console.log('Error fetching user data');
        }
    });

    function updateJHStudents(count) {
        $('#jhStudents').text(count);
    }

    function updateJHStudentsGraph(activeCounts) {
        const jhStudentCanvas = document.getElementById("jhGraph");

        if (activeCounts && activeCounts.labels) {
            if (jhStudentChart) {
                jhStudentChart.destroy();
            }

            function customPointStyle() {
                return 'circle';
            }

            const data = {
                labels: activeCounts.labels,
                datasets: [{
                    data: activeCounts.data,
                    borderColor: '#035543',
                    borderWidth: 1.5,
                    pointRadius: 5,
                    pointStyle: customPointStyle,
                    fill: false
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#035543'
                            },
                            grid: {
                                display: false,
                            }
                        },
                        x: {
                            ticks: {
                                color: '#035543'
                            },
                            grid: {
                                display: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    }
                }
            };
            jhStudentChart = new Chart(jhStudentCanvas, config);
        } else {
            console.log('Error: Invalid data structure in the response');
        }
    }
}

// Total SHS Students
function getSHStudents() {
    $.ajax({
        url: '../../actions/get-total-shs-students.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                updateSHStudents(response.shsStudents);
                updateSHStudentsGraph(response.activeCounts);
            } else {
                console.log('Error: ' + response.message);
            }
        },
        error: function () {
            console.log('Error fetching user data');
        }
    });

    function updateSHStudents(count) {
        $('#shStudents').text(count);
    }

    function updateSHStudentsGraph(activeCounts) {
        const shStudentCanvas = document.getElementById("shGraph");

        if (activeCounts && activeCounts.labels) {
            if (shStudentChart) {
                shStudentChart.destroy();
            }

            function customPointStyle() {
                return 'circle';
            }

            const data = {
                labels: activeCounts.labels,
                datasets: [{
                    data: activeCounts.data,
                    borderColor: '#035543',
                    borderWidth: 1.5,
                    pointRadius: 5,
                    pointStyle: customPointStyle,
                    fill: false
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#035543'
                            },
                            grid: {
                                display: false,
                            }
                        },
                        x: {
                            ticks: {
                                color: '#035543'
                            },
                            grid: {
                                display: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    }
                }
            };
            shStudentChart = new Chart(shStudentCanvas, config);
        } else {
            console.log('Error: Invalid data structure in the response');
        }
    }
}