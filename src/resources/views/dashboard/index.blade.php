@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid border-bottom px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('home') }}
            </ol>
        </nav>
    </div>
    <style>
        .card {
            height: 100%;
        }
    </style>
    <div class="container">
        <div class="row d-flex justify-content-between g-4 mb-4 mt-1">
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start mx-3">
                        <div class="mx-3 text-white">
                            <div class="fs-4 fw-semibold">Ages for events</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mb-2">
                        <canvas id="Ages-of-events"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-warning">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">26K <span class="fs-6 fw-normal">(-12.4%)</span></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-info">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">36K <span class="fs-6 fw-normal">(-23%)</span></div>
                            <div>Stuff</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-danger">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">44K <span class="fs-6 fw-normal">(-23.6%)</span></div>
                            <div>Sessions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.complaints-statistic')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Traffic &amp; Popular</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                                <canvas id="Countries" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="regions-chart-container" style="display: none;">
                            <div>
                                <canvas id="Regions"></canvas>
                            </div>
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
        let selectedCountryId = null;

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
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 17
                            }
                        }
                    }
                },
                indexAxis: 'y',
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 16,
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 15,
                            }
                        }
                    }
                },
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const countryIndex = elements[0].index;
                        const countryId = countriesData[countryIndex].id;
                        if (selectedCountryId === countryId) {
                            document.getElementById('regions-chart-container').style.display = 'none';
                            selectedCountryId = null;
                        } else {
                            updateRegionsChart(countryId);
                            selectedCountryId = countryId;
                        }
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
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 17
                                }
                            }
                        }
                    },
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            document.getElementById('regions-chart-container').style.display = 'block';
        }

        const agesLabels = agesData.map(age => age.label);
        const agesCounts = agesData.map(age => age.count);

        const agesChart = new Chart(agesCanvas, {
            type: 'pie',
            data: {
                labels: agesLabels,
                datasets: [{
                    label: 'Ages of Events',
                    data: agesCounts,
                    backgroundColor: ['#cb5b50', '#207fbd', '#ccb040', '#47b175', '#884EA0', '#D35400'],
                    borderColor: ['#d3301f', '#0f8de1', '#eac21f', '#41d37f', '#884EA0', '#D35400'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 17
                            }
                        },
                        position: 'top',
                    },
                }
            },
        });
    </script>
@endsection
