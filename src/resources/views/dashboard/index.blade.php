@extends('layouts.mainlayout')
@section('content')
    {{--@dd($content)--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Traffic &amp; Popular</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <canvas id="Countries"></canvas>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6">
                            <canvas id="Regions"></canvas>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row--><br>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctr = document.getElementById('Countries').getContext('2d');

        const labels_country = [
            @foreach($content['countries'] as $country)
            '{{ $country['name'] }}',
            @endforeach
        ]

        const data_country = [
            @foreach($content['countries'] as $country)
                {{ $country['count'] }},
            @endforeach
        ]

        new Chart(ctr, {
            type: 'bar',
            data: {
                labels: labels_country,
                datasets: [
                    {
                    label: 'Countries of Events',
                    data: data_country,
                    borderWidth: 1,
                    borderColor: 'rgb(252,82,115)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                }
                ]
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

        const rgn = document.getElementById('Regions').getContext('2d');

        const labels_region = [
            @foreach($content['regions'] as $region)
                '{{ $region['name'] }}',
            @endforeach
        ]

        const data_region = [
            @foreach($content['regions'] as $region)
                {{ $region['count'] }},
            @endforeach
        ]

        new Chart(rgn, {
            type: 'bar',
            data: {
                labels: labels_region,
                datasets: [
                    {
                        label: 'Regions of Events',
                        data: data_region,
                        borderWidth: 1,
                        borderColor: 'rgb(82,122,252)',
                        backgroundColor: 'rgba(0,108,248,0.5)',
                    }
                ]
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
    </script>
@endsection
