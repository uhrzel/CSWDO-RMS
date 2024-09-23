@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-10 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            Clients -
                            <div class="dropdown d-inline">
                                <a
                                    class="font-weight-600 dropdown-toggle"
                                    data-toggle="dropdown"
                                    href="#"
                                    id="orders-month">Select Barangay</a>
                                <ul class="dropdown-menu dropdown-menu-sm" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($barangays as $barangay)
                                    <li><a href="#" class="dropdown-item" onclick="showIncomeBrackets('{{ $barangay }}')">{{ $barangay }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Income Bracket Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card" style="height: 300px;">
                            <div class="card-header">
                                <h4>Income Bracket</h4>
                                <span id="barangay-name" class="text-muted"></span>
                            </div>
                            <div class="card-body" style="overflow: hidden;">
                                <canvas id="incomeChart" style="max-height: 200px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Most Requested Services Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card" id="services-section" style="height: 300px;">
                            <div class="card-header">
                                <h4>Most Requested Services</h4>
                                <span id="barangay-name-services" class="text-muted"></span>
                            </div>
                            <div class="card-body" style="overflow: hidden;">
                                <canvas id="servicesChart" style="max-height: 200px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Gender Distribution Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card" id="gender-section" style="height: 300px;">
                            <div class="card-header">
                                <h4>Gender Distribution</h4>
                                <span id="barangay-name-gender" class="text-muted"></span>
                            </div>
                            <div class="card-body" style="overflow: hidden;">
                                <canvas id="genderChart" style="max-height: 200px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Age Group Services Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card" id="age-group-section" style="height: 300px;">
                            <div class="card-header">
                                <h4>Requested Services by Age Group</h4>
                                <span id="barangay-name-age" class="text-muted"></span>
                            </div>
                            <div class="card-body" style="overflow: hidden;">
                                <canvas id="ageGroupChart" style="max-height: 200px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    const incomeData = {
        '100 PHP - 500 PHP': 0,
        '500 PHP - 1000 PHP': 0,
        '1000 PHP - 2000 PHP': 0,
        '2000 PHP - 5000 PHP': 0,
        '5000 PHP - 6000 PHP': 0,
        '6000 PHP - 7000 PHP': 0,
        '7000 PHP - 8000 PHP': 0,
        '8000 PHP - 9000 PHP': 0,
        '9000 PHP - 10,000 PHP': 0,
        '10,000 PHP - 20,000 PHP': 0,
        'Above 20,000 PHP': 0,
    };

    let incomeChart, servicesChart, genderChart, ageGroupChart;

    function showIncomeBrackets(barangay) {
        // Fetch income brackets
        $.ajax({
            url: '/income-brackets',
            type: 'GET',
            data: {
                barangay: barangay
            },
            success: function(data) {
                Object.keys(incomeData).forEach(key => incomeData[key] = 0);

                data.clients.forEach(client => {
                    if (incomeData.hasOwnProperty(client.monthly_income)) {
                        incomeData[client.monthly_income]++;
                    }
                });

                $('#barangay-name').text(barangay);
                updateIncomeChart();
            },
            error: function() {
                alert('Error fetching income data');
            }
        });

        // Fetch most requested services
        $.ajax({
            url: '/most-requested-services',
            type: 'GET',
            data: {
                barangay: barangay
            },
            success: function(services) {
                const serviceCounts = {};
                services.forEach(service => {
                    serviceCounts[service.service] = service.count;
                });

                $('#barangay-name-services').text(barangay);
                updateServicesChart(serviceCounts);
            },
            error: function() {
                alert('Error fetching services data');
            }
        });

        // Fetch gender distribution
        $.ajax({
            url: '/gender-distribution',
            type: 'GET',
            data: {
                barangay: barangay
            },
            success: function(genderData) {
                $('#barangay-name-gender').text(barangay);
                updateGenderChart(genderData);
            },
            error: function() {
                alert('Error fetching gender data');
            }
        });

        // Fetch age group services
        $.ajax({
            url: '/age-group-services',
            type: 'GET',
            data: {
                barangay: barangay
            },
            success: function(ageData) {
                $('#barangay-name-age').text(barangay);
                updateAgeGroupChart(ageData);
            },
            error: function() {
                alert('Error fetching age group data');
            }
        });
    }

    function updateIncomeChart() {
        const ctx = document.getElementById('incomeChart').getContext('2d');
        const labels = Object.keys(incomeData);
        const data = Object.values(incomeData);

        if (incomeChart) {
            incomeChart.destroy();
        }

        incomeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Income Brackets',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateServicesChart(serviceCounts) {
        const ctx = document.getElementById('servicesChart').getContext('2d');
        const labels = Object.keys(serviceCounts);
        const data = Object.values(serviceCounts);

        if (servicesChart) {
            servicesChart.destroy();
        }

        servicesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Most Requested Services',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Most Requested Services'
                    }
                }
            }
        });

        $('#services-section').show();
    }

    function updateGenderChart(genderData) {
        const ctx = document.getElementById('genderChart').getContext('2d');
        const labels = ['Male', 'Female', 'Others'];
        const data = [
            genderData.male || 0,
            genderData.female || 0,
            genderData.others || 0
        ];

        if (genderChart) {
            genderChart.destroy();
        }

        genderChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gender Distribution',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Gender Distribution'
                    }
                }
            }
        });

        $('#gender-section').show();
    }

    function updateAgeGroupChart(ageData) {
        const ctx = document.getElementById('ageGroupChart').getContext('2d');
        const labels = Object.keys(ageData);
        const data = Object.values(ageData);

        if (ageGroupChart) {
            ageGroupChart.destroy();
        }

        ageGroupChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Requested Services by Age Group',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $('#age-group-section').show();
    }
</script>
@endpush

@endsection