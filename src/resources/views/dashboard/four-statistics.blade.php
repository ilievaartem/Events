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
                        <div class="fs-4 fw-semibold">Count of tags<span class="fs-6 fw-normal">(2024)</span></div>
                        <div>Last three month</div>
                    </div>
                </div>
                <div class="c-chart-wrapper">
                    <canvas id="Count-of-tags-of-events" width="270" height="310"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const agesCanvas = document.getElementById('Ages-of-events').getContext('2d');
    const countEventsCanvas = document.getElementById('Count-of-events').getContext('2d');
    const countTagsCanvas = document.getElementById('Count-of-tags-of-events').getContext('2d');

    const agesData = @json($content['events']['ageGroups']);
    let countEventData = {};
    let countTagData = {};
    let countCategoriesData = {};
    let countUsersData = {};

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

    const currentDate = new Date();
    const currentMonthIndex = currentDate.getMonth();
    const monthNamesShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const countLabels = [];
    for (let i = currentMonthIndex - 3; i <= currentMonthIndex; i++) {
        let monthIndex;
        if (i < 0) {
            monthIndex = 12 + i;
        } else {
            monthIndex = i;
        }
        countLabels.push(monthNamesShort[monthIndex]);
    }

    function convertMonthsToNumbers(countLabels) {
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
        return countLabels.map(month => monthMap[month]);
    }

    function fetchMonthOfEvents(countLabels) {
        const year = new Date().getFullYear();
        const numberMonths = convertMonthsToNumbers(countLabels);
        const monthsEventsQueryString = numberMonths.map(month => `events[months][]=${month}`).join('&');
        const monthsTagsQueryString = numberMonths.map(month => `tags[months][]=${month}`).join('&');
        const monthsCategoriesQueryString = numberMonths.map(month => `categories[months][]=${month}`).join('&');
        const monthsUsersQueryString = numberMonths.map(month => `months[months][]=${month}`).join('&');
        const endpoint = `{{ route('dashboard.count') }}?events[year]=${year}&${monthsEventsQueryString}
        &tags[year]=${year}&${monthsTagsQueryString}
        &categories[year]=${year}&${monthsCategoriesQueryString}
        &users[year]=${year}&${monthsUsersQueryString}`;
        console.log(endpoint)
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                countEventData = data.events;
                countTagData = data.tags;
                countCategoriesData = data.categories;
                countUsersData = data.users;
                updateEventsChart();
                updateTagsChart();
                updateCategoriesChart();
                updateUsersChart();
            })
            .catch(error => console.error('Error fetching event data:', error));
    }

    function updateEventsChart() {
        if (!countEventData || Object.keys(countEventData).length === 0) {
            console.error('No event data available');
            return;
        }

        const eventCounts = countLabels.map(monthLabel => {
            const monthNumber = convertMonthsToNumbers([monthLabel])[0];
            return countEventData[String(monthNumber).padStart(2, '0')];
        });

        const eventsChart = {
            type: 'bar',
            data: {
                labels: countLabels,
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
        window.myChart = new Chart(countEventsCanvas, eventsChart);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchMonthOfEvents(countLabels);
    });

    function updateTagsChart() {
        if (!countTagData || Object.keys(countTagData).length === 0) {
            console.error('No event data available');
            return;
        }

        const tagsCounts = countLabels.map(monthLabel => {
            const monthNumber = convertMonthsToNumbers([monthLabel])[0];
            return countTagData[String(monthNumber).padStart(2, '0')];
        });

        const tagsChart = {
            type: 'line',
            data: {
                labels: countLabels,
                datasets: [{
                    barThickness: 25,
                    maxBarThickness: 25,
                    label: 'Count of Events',
                    data: tagsCounts,
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
        window.myChart = new Chart(countEventsCanvas, tagsChart);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchMonthOfEvents(countLabels);
    });

    // function updateCategoriesChart() {
    //     if (!countCategoriesData || Object.keys(countCategoriesData).length === 0) {
    //         console.error('No event data available');
    //         return;
    //     }
    //
    //     const categoriesCounts = countLabels.map(monthLabel => {
    //         const monthNumber = convertMonthsToNumbers([monthLabel])[0];
    //         return countCategoriesData[String(monthNumber).padStart(2, '0')];
    //     });
    // }
    //
    // function updateUsersChart() {
    //     if (!countUsersData || Object.keys(countUsersData).length === 0) {
    //         console.error('No event data available');
    //         return;
    //     }
    //
    //     const usersCounts = countLabels.map(monthLabel => {
    //         const monthNumber = convertMonthsToNumbers([monthLabel])[0];
    //         return countUsersData[String(monthNumber).padStart(2, '0')];
    //     });
    // }

</script>
