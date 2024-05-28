<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Complaints</h4>
                    <div class="small text-body-secondary">Select a month to view details</div>
                </div>
                <form id="monthForm">
                    <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                        <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                            <label for="month" class="form-label">Choose month</label>
                            <select class="form-control" aria-label="Default select example" id="month" name="month">
                                <option value="">All month</option>
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">June</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" value="Find">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="c-chart-wrapper" style="height:400px;margin-top:40px;">
                <canvas class="chart" id="Complaints" height="400" style="width: 100%;"></canvas>
            </div>
        </div>
        <div class="card-footer">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-4 mb-2 text-center">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const complaintsYearStats = @json($complaintsStatistics);

        const complaintCanvas = document.getElementById('Complaints').getContext('2d');

        const config = {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Unresolved',
                        data: complaintsYearStats.notResolved,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Positive',
                        data: complaintsYearStats.resolvedPositive,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(79, 192, 75)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Negative',
                        data: complaintsYearStats.resolvedNegative,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...complaintsYearStats.notResolved, ...complaintsYearStats.resolvedPositive, ...complaintsYearStats.resolvedNegative) + 5
                    }
                },
                animations: {
                    radius: {
                        duration: 400,
                        easing: 'linear',
                        loop: (context) => context.active
                    }
                },
                hoverRadius: 12,
                hoverBackgroundColor: 'yellow',
                interaction: {
                    mode: 'nearest',
                    intersect: false,
                    axis: 'x'
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 22
                            }
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        };

        let myChart = new Chart(complaintCanvas, config);

        const monthForm = document.getElementById('monthForm');

        monthForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const month = document.getElementById('month').value;

            fetchComplaintsByMonth(month);
        });

        function fetchComplaintsByMonth(month) {
            if (month === "") {
                drawYearlyChart();
                return
            }
            const year = new Date().getFullYear();
            const daysInMonth = new Date(year, parseInt(month) + 1, 0).getDate();
            let created_from = new Date(new Date().getFullYear(), month).toISOString().match(/(\d{4}\-\d{2}\-\d{2})T(\d{2}:\d{2}:\d{2})/);
            created_from = created_from[1] + ' ' + created_from[2];
            let created_to = new Date(new Date().getFullYear(), ++month).toISOString().match(/(\d{4}\-\d{2}\-\d{2})T(\d{2}:\d{2}:\d{2})/);
            created_to = created_to[1] + ' ' + created_to[2];

            fetch(`{{ route('dashboard.filter') }}?created_from=${created_from}&created_to=${created_to}`)
                .then(response => response.json())
                .then(data => {
                    let complaints = Array.from({length: daysInMonth}, () => ({
                        notResolved: 0,
                        resolvedPositive: 0,
                        resolvedNegative: 0
                    }));

                    data.forEach(complaint => {
                        let complaintDate = new Date(complaint.created_at).getDate() - 1;
                        if (complaint.resolved_at == null) {
                            complaints[complaintDate].notResolved++;
                        } else if (complaint.resolve_message === 'Applied') {
                            complaints[complaintDate].resolvedPositive++;
                        } else if (complaint.resolve_message === 'Declined') {
                            complaints[complaintDate].resolvedNegative++;
                        }
                    });

                    drawMonthlyChart(complaints, daysInMonth);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to fetch data for the selected month. Please try again later.');
                });
        }

        function drawYearlyChart() {
            const yearData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Unresolved',
                        data: complaintsYearStats.notResolved,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Positive',
                        data: complaintsYearStats.resolvedPositive,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(79, 192, 75)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Negative',
                        data: complaintsYearStats.resolvedNegative,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            };

            const yearConfig = {
                type: 'line',
                data: yearData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(...complaintsYearStats.notResolved, ...complaintsYearStats.resolvedPositive, ...complaintsYearStats.resolvedNegative) + 5
                        }
                    },
                    animations: {
                        radius: {
                            duration: 400,
                            easing: 'linear',
                            loop: (context) => context.active
                        }
                    },
                    hoverRadius: 12,
                    hoverBackgroundColor: 'yellow',
                    interaction: {
                        mode: 'nearest',
                        intersect: false,
                        axis: 'x'
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 22
                                }
                            }
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            };

            myChart.destroy();
            myChart = new Chart(complaintCanvas, yearConfig);
        }

        function drawMonthlyChart(complaints, daysInMonth) {
            const days = Array.from({length: daysInMonth}, (_, i) => i + 1);

            myChart.destroy();

            const monthData = {
                labels: days,
                datasets: [
                    {
                        label: 'Unresolved',
                        data: complaints.map(c => c.notResolved),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Positive',
                        data: complaints.map(c => c.resolvedPositive),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(79, 192, 75)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Resolved Negative',
                        data: complaints.map(c => c.resolvedNegative),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            };

            const monthConfig = {
                type: 'line',
                data: monthData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 22
                                }
                            }
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            };

            myChart = new Chart(complaintCanvas, monthConfig);
        }
    });

</script>
