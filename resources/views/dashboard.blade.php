@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="card">
                            <div class="chart">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        
                        {{-- <div class="card">
                            <div class="chart">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chart1');
        // const ctx2 = document.getElementById('chart2');

        let cours = {!! json_encode($cours) !!};

        // data for chart 1
        let names = cours.map(cour => cour.nom);
        let arrayOfDates = cours.map(cour => cour.created_at);

        let monthCounts = {};
        // Initialize monthCounts with all months set to 0
        for (let i = 1; i <= 12; i++) {
            monthCounts[i] = 0;
        }
        arrayOfDates.forEach(date => {
            let month = (new Date(date)).getMonth() + 1;
            monthCounts[month]++;
        });
        let numbers = Object.values(monthCounts);

        // global options
        Chart.defaults.color = '#777';
        Chart.defaults.font.family = 'Lato';

        // data for chart 2
        // enrolls.map(enroll => {
        //     cours.forEach(cour => {
        //         if (cour.id == enroll.cour_id) {
        //             enroll.cour_id = cour.nom;
        //         }
        //     })
        //     // return enroll.cour_id;
        // })
        // const courNames = [];
        // const counts = [];

        // for (const enroll of enrolls) {
        //     const courName = enroll.cour_id;
        //     const existingIndex = courNames.indexOf(courName);
        //     if (existingIndex !== -1) {
        //         counts[existingIndex]++;
        //     } else {
        //         courNames.push(courName);
        //         counts.push(1);
        //     }
        // }
        // console.log(courNames)
        // console.log(counts);
        function generateBluishColors(count) {
            const colors = [];
            const hue = 200; // Blue hue value

            for (let i = 0; i < count; i++) {
                const saturation = Math.floor(Math.random() * 41) + 60; // Random saturation between 60 and 100
                const lightness = Math.floor(Math.random() * 41) + 20; // Random lightness between 30 and 70
                const color = `hsl(${hue}, ${saturation}%, ${lightness}%)`;
                colors.push(color);
            }

            return colors;
        }

        // chart 1
        let chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['jan', 'feb', 'mar', 'apr', 'mai', 'jun', 'jul', 'aou', 'oct', 'nov', 'dec'],
                datasets: [{
                    label: 'Courses published',
                    data: numbers,
                    backgroundColor: generateBluishColors(12),
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderColor: '#000',
                    hoverBorderColor: 3
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Number of courses published',
                        font: {
                            size: 25
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

        //* chart 2
        // let chart2 = new Chart(ctx2, {
        //     type: 'bar',
        //     data: {
        //         labels: courNames,
        //         datasets: [{
        //             label: 'Courses published',
        //             data: counts,
        //             backgroundColor: generateBluishColors(courNames.length),
        //             borderWidth: 1,
        //             borderColor: '#777',
        //             hoverBorderColor: '#000',
        //             hoverBorderColor: 3
        //         }]
        //     },
        //     options: {
        //         plugins: {
        //             title: {
        //                 display: true,
        //                 text: 'The most popular courses',
        //                 font: {
        //                     size: 25
        //                 }
        //             },
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // });
    </script>
@endsection
