@extends("layout.layout")
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your business dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Monthly Report</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Withdrawals and Deposits</h4>
                                <span style="color:black">{{$dateRange}}</span>
                            </div>
                            <div class="card-body">
                                <canvas id="withdrawalsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Expense and Bonus</h4>
                                <span style="color:black">{{$dateRange}}</span>
                            </div>
                            <div class="card-body">
                                <canvas id="profitsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card equal-height">
                            <div class="card-header">
                                <h4 class="card-title">Total Exchange Profit</h4>
                                <span style="color:black">{{$dateRange}}</span>
                            </div>
                            <div class="card-body">
                                <canvas id="bonusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function($) {
            "use strict";

            // Withdrawals chart
            const ctx2 = document.getElementById('withdrawalsChart').getContext('2d');
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Withdrawals', 'Deposits'],
                    datasets: [{
                        data: [{{$withdrawal ?: 0}}, {{$deposit ?: 0}}],
                        backgroundColor: ['rgb(192, 10, 39)', '#75B432'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            bodyFont: {
                                size: 16, // Increase the font size here
                            },
                            titleFont: {
                                size: 18, // Optional: Increase title font size
                            },
                        }
                    }
                }
            });

            // Profits chart
            const ctx3 = document.getElementById('profitsChart').getContext('2d');
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: ['Expenses', 'Bonuses'],
                    datasets: [{
                        data: [{{$expense ?: 0}}, {{$bonus ?: 0}}],
                        backgroundColor: ['#75B432', '#E0E0E0'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            bodyFont: {
                                size: 16, // Increase the font size here
                            },
                            titleFont: {
                                size: 18, // Optional: Increase title font size
                            },
                        }
                    }
                }
            });

            // Bonus chart
            const ctx4 = document.getElementById('bonusChart').getContext('2d');
            new Chart(ctx4, {
                type: 'pie',
                data: {
                    labels: ['Total Exchange Profit'],
                    datasets: [{
                        data: [{{$latestBalance ?: 0}}],
                        backgroundColor: ['#FFCE56'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            bodyFont: {
                                size: 16, // Increase the font size here
                            },
                            titleFont: {
                                size: 18, // Optional: Increase title font size
                            },
                        }
                    }
                }
            });
        })(jQuery);
    </script>

    <style>
        .equal-height {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-body {
            flex: 1 1 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100%;
            max-height: 200px;
        }
    </style>
@endsection
