<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">Complaints</h4>
                <div class="small text-body-secondary">January - July 2023</div>
            </div>
            <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                    <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
                    <label class="btn btn-outline-secondary"> Day</label>
                    <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked="">
                    <label class="btn btn-outline-secondary active"> Month</label>
                    <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
                    <label class="btn btn-outline-secondary"> Year</label>
                </div>
                <button class="btn btn-primary" type="button">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                </button>
            </div>
        </div>
        <div class="c-chart-wrapper " style="height:400px;margin-top:40px;">
            <canvas class="chart" id="Complaints" height="400" style="width: 100%;"></canvas>
        </div>
    </div>
    <div class="card-footer">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-4 mb-2 text-center">

        </div>
    </div>
</div>

<script>


    document.addEventListener('DOMContentLoaded', function () {
        const complaintStats = @json($complaintsStatistics);

        const complaintCanvas = document.getElementById('Complaints').getContext('2d');

        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Unresolved',
                    data: complaintStats.notResolved,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Resolved Positive',
                    data: complaintStats.resolvedPositive,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(79, 192, 75)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Resolved Negative',
                    data: complaintStats.resolvedNegative,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...complaintStats.notResolved, ...complaintStats.resolvedPositive, ...complaintStats.resolvedNegative) + 5 // встановлення адекватного масштабу
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
                    tooltip: {
                        enabled: true
                    }
                }
            }
        };

        const complaintChart = new Chart(complaintCanvas, config);
    });

</script>
