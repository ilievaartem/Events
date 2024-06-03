@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid border-bottom px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('home') }}
            </ol>
        </nav>
    </div>
    @include('dashboard.four-statistics')
    @include('dashboard.complaints-statistic')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Traffic &amp; Popular</div>
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-0">Country of events</h4>
                            <div class="small text-body-secondary mb-3">Click on bar of country to see stats of regions
                                this country. Double click to close
                            </div>
                        </div>
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

        const countriesData = @json($content['countries']);
        const regionsData = @json($content['regions']);

        const countriesLabels = countriesData.map(country => country.name);
        const countriesCounts = countriesData.map(country => country.count);

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

        let regionsChart;
        let selectedCountryId = null;

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
    </script>
@endsection
