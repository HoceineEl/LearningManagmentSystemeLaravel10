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

                        {{-- <div style="overflow-x: auto;">
                            <h3>Users</h3>
                            <table class="table table-bordered table-striped align-text-center">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Roles
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        @if($user->approved)
                                            <tr>
                                                <td>
                                                    {{ $user['id'] }}
                                                </td>
                                                <td>
                                                    {{ $user['name'] }}
                                                </td>
                                                <td>
                                                    {{ $user['email'] }}
                                                </td>
                                                <td>
                                                    {{ $user['role'] }}
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                Aucun utilisateur
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> --}}

                        <div class="d-flex justify-content-evenly">
                            <div class="card w-25 align-text-center box">
                                <div class="card-title">
                                    <i class="fa fa-solid fa-graduation-cap fa-lg"></i>
                                    Courses Count
                                </div>
                                <p class="number">
                                    {{ count($cours) }}
                                </p>
                            </div>
                            <div class="card w-25 align-text-center box">
                                <div class="card-title">
                                    <i class="fa fa-solid fa-user fa-lg"></i>
                                    Users Count
                                </div>
                                <p class="number">
                                    {{ $users->where('approved', '1')->where('role', '!=', '1')->count() }}
                                </p>
                            </div>
                            <div class="card w-25 align-text-center box">
                                <div class="card-title">
                                    <i class="fa fa-solid fa-video fa-lg"></i>
                                        Videos Count
                                </div>
                                <p class="number">
                                    {{ $videosNumbers }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div class="chart card">
                                <canvas id="chart1"></canvas>
                            </div>
                            <div class="chart card">
                                <canvas id="chart2"></canvas>
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
        const ctx2 = document.getElementById('chart2');

        let cours = {!! json_encode($cours) !!};
        let truePercent = {!! json_encode($truePercent) !!};
        let courNames = Object.keys(truePercent);
        truePercentage = Object.values(truePercent);
      

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

        // function generating bluish colors
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
            type: 'pie',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Courses published',
                    data: numbers,
                    backgroundColor: [
                        '#003f5c',
                        '#2f4b7c',
                        '#665191',
                        '#a05195',
                        '#d45087',
                        '#f95d6a',
                        '#ff7c43',
                        '#ffa600', 
                        '#bad0af', 
                        '#de425b', 
                        '#f0b8b8', 
                        '#f1f1f1'
                    ],
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderColor: '#000',
                    hoverBorderColor: 3
                }]
            },
            options: {
                aspectRatio: 0.8,
                plugins: {
                    title: {
                        display: true,
                        text: 'Courses Published Per Month',
                        font: {
                            size: 30
                        }
                    },
                    legend: {
                        display: true
                    }
                }
            }
        });

        // chart 2
        let chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: courNames,
                datasets: [{
                    label: 'fished by',
                    data: truePercentage,
                    backgroundColor: generateBluishColors(12),
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderColor: '#000',
                    hoverBorderColor: 3
                }]
            },
            options: {
                aspectRatio: 0.8,
                plugins: {
                    title: {
                        display: true,
                        text: 'Most 10 Enrolled Courses',
                        font: {
                            size: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        suggestedMax: 100,
                        ticks: {
                            callback: function(value) {
                                return value + "%";
                            }
                        },
                        title: {
                            display: true,
                            text: "Percentage Of Users Who Finished The Courses"
                        }
                    },
                    x: {
                        grid: {
                            display: true
                        }
                    }
                }
            }
        });

        //* chart enrollements
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
