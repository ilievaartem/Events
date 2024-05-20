@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid border-bottom px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('home') }}
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-primary">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">26K <span class="fs-6 fw-normal">(-12.4%)</span></div>
                        <div>Users</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a
                                class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something
                                else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">$6.200 <span class="fs-6 fw-normal">(40.9%)</span></div>
                        <div>Income</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a
                                class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something
                                else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white">
                <div class="c-chart-wrapper mt-3 mb-2">
                    <canvas id="Ages-of-events"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white bg-danger">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">44K <span class="fs-6 fw-normal">(-23.6%)</span></div>
                        <div>Sessions</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a
                                class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something
                                else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    @include('dashboard.complaints-statistic')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Traffic &amp; Popular</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <canvas id="Countries" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <canvas id="Regions"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const countriesCanvas = document.getElementById('Countries').getContext('2d');
        const regionsCanvas = document.getElementById('Regions').getContext('2d');
        const agesCanvas = document.getElementById('Ages-of-events').getContext('2d');

        const countriesData = @json($content['countries']);
        const regionsData = @json($content['regions']);
        const agesData = @json($content['events']['ageGroups']);

        const countriesLabels = countriesData.map(country => country.name);
        const countriesCounts = countriesData.map(country => country.count);

        let regionsChart;

        const countriesChart = new Chart(countriesCanvas, {
            type: 'bar',
            data: {
                labels: countriesLabels,
                datasets: [{
                    label: 'Countries of Events',
                    data: countriesCounts,
                    borderWidth: 1,
                    borderColor: 'rgb(252,82,115)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const countryIndex = elements[0].index;
                        const countryId = countriesData[countryIndex].id;
                        updateRegionsChart(countryId);
                    }
                }
            }
        });

        function updateRegionsChart(countryId) {
            const regions = regionsData[countryId] || [];
            const regionsLabels = regions.map(region => region.name);
            const regionsCounts = regions.map(region => region.count);

            if (regionsChart) {
                regionsChart.destroy();
            }

            regionsChart = new Chart(regionsCanvas, {
                type: 'bar',
                data: {
                    labels: regionsLabels,
                    datasets: [{
                        label: 'Regions of Events',
                        data: regionsCounts,
                        borderWidth: 1,
                        borderColor: 'rgb(82,122,252)',
                        backgroundColor: 'rgba(0,108,248,0.5)',
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        updateRegionsChart(null);

        const agesLabels = agesData.map(age => age.label);
        const agesCounts = agesData.map(age => age.count);

        const agesChart = new Chart(agesCanvas, {
            type: 'pie',
            data: {
                labels: agesLabels,
                datasets: [{
                    label: 'Ages of Events',
                    data: agesCounts,
                    backgroundColor: ['#e24f3f', '#287eb6', '#ecc11a', '#28cc6c', '#884EA0', '#D35400'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Ages of Events'
                    }
                }
            },
        });
    </script>
@endsection
