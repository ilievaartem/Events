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
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div class="mt-2 text-white">
                            <div class="fs-4 fw-semibold">Ages for events</div>
                            <span class="fs-6 fw-normal">(2024)</span>
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
                            <div class="fs-4 fw-semibold">36K <span class="fs-6 fw-normal">(-23%)</span></div>
                            <div>Stuff</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-info">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">Count of events <span class="fs-6 fw-normal">(2024)</span>
                            </div>
                            <div>Last three month</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper">
                        <canvas id="Count-of-events" width="270" height="310"></canvas>
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
        const agesCanvas = document.getElementById('Ages-of-events').getContext('2d');
        const countCanvas = document.getElementById('Count-of-events').getContext('2d');

        const countriesData = @json($content['countries']);
        const regionsData = @json($content['regions']);
        const agesData = @json($content['events']['ageGroups']);
        let countData = {};

        const countriesLabels = countriesData.map(country => country.name);
        const countriesCounts = countriesData.map(country => country.count);

        const currentDate = new Date();
        const currentMonthIndex = currentDate.getMonth();
        const monthNamesShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const countEventsLabels = [];
        for (let i = currentMonthIndex - 3; i <= currentMonthIndex; i++) {
            let monthIndex;
            if (i < 0) {
                monthIndex = 12 + i;
            } else {
                monthIndex = i;
            }
            countEventsLabels.push(monthNamesShort[monthIndex]);
        }

        function convertMonthsToNumbers(countEventsLabels) {
            const monthMap = {
                'Jan': 1,
                'Feb': 2,
                'Mar': 3,
                'Apr': 4,
                'May': 5,
                'Jun': 6,
                'Jul': 7,
                'Aug': 8,
                'Sep': 9,
                'Oct': 10,
                'Nov': 11,
                'Dec': 12
            };
            return countEventsLabels.map(month => monthMap[month]);
        }

        function fetchMonthOfEvents(countEventsLabels) {
            const year = new Date().getFullYear();
            const numberMonths = convertMonthsToNumbers(countEventsLabels);
            const monthsQueryString = numberMonths.map(month => `months[]=${month}`).join('&');
            const endpoint = `{{ route('dashboard.count') }}?year=${year}&${monthsQueryString}`;
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    countData = data;
                    updateEventsChart();
                })
                .catch(error => console.error('Error fetching event data:', error));
        }

        function updateEventsChart() {
            if (!countData || Object.keys(countData).length === 0) {
                console.error('No event data available');
                return;
            }

            const eventCounts = countEventsLabels.map(monthLabel => {
                const monthNumber = convertMonthsToNumbers([monthLabel])[0];
                return countData[String(monthNumber).padStart(2, '0')];
            });

            const eventsChart = {
                type: 'bar',
                data: {
                    labels: countEventsLabels,
                    datasets: [{
                        barThickness: 25,
                        maxBarThickness: 25,
                        label: 'Count of Events',
                        data: eventCounts,
                        borderWidth: 0.1,
                        borderColor: 'rgb(236,232,0)',
                        backgroundColor: 'rgba(30,8,239,0.65)',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                color: 'rgba(69,112,227,0.4)'
                            },
                            ticks: {
                                color: 'white',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: 'rgba(69,112,227,0.4)'
                            },
                            ticks: {
                                color: 'white',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    responsive: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: 15
                                }
                            },
                            position: 'top',
                        },
                    }
                },
            };

            if (window.myChart) {
                window.myChart.destroy();
            }
            window.myChart = new Chart(countCanvas, eventsChart);
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchMonthOfEvents(countEventsLabels);
        });

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
