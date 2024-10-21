@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            Applicant -
                            <div class="dropdown d-inline">
                                <a
                                    class="font-weight-600 dropdown-toggle"
                                    data-toggle="dropdown"
                                    href="#"
                                    id="orders-month">Select Barangay</a>
                                <ul class="dropdown-menu dropdown-menu-sm" style="max-height: 200px; overflow-y: auto;">
                                    <li>
                                        <a href="#" class="dropdown-item" onclick="showIncomeBrackets('Overall')">Overall</a>
                                    </li>
                                    @foreach($barangays as $barangay)
                                    <li><a href="#" class="dropdown-item" onclick="showIncomeBrackets('{{ $barangay }}')">{{ $barangay }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $totalClients }}</div>
                                <div class="card-stats-item-label">Total Applicants</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $ongoingClients }}</div>
                                <div class="card-stats-item-label">Ongoing Applicants</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$closedClients}}</div>
                                <div class="card-stats-item-label">Completed Applicants</div>
                            </div>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Applicants</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalClients }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Family Members</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalFamilyMembers }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Social Workers</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalSocialWorkers }}
                        </div>
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


        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Clients per Month Predection</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyAverageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Services per Barangay Prediction</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="barangayServiceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Average Income</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="averageIncomeChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Prediction Average Income</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="PredictionAverageIncomeChart" width="400" height="200"></canvas>
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
        // Determine if we should fetch overall data or specific barangay data
        let fetchAll = (barangay === 'Overall');

        // Fetch income brackets
        $.ajax({
            url: '/income-brackets',
            type: 'GET',
            data: {
                barangay: fetchAll ? 'all' : barangay // Adjust backend to handle 'all'
            },
            success: function(data) {
                console.log('Income Brackets Data:', data);
                // Reset income data
                Object.keys(incomeData).forEach(key => incomeData[key] = 0);

                // Process received data
                data.clients.forEach(client => {
                    if (incomeData.hasOwnProperty(client.monthly_income)) {
                        incomeData[client.monthly_income]++;
                    }
                });

                $('#barangay-name').text(fetchAll ? 'All Barangays' : barangay);
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
                barangay: fetchAll ? 'all' : barangay // Adjust backend to handle 'all'
            },
            success: function(services) {

                const serviceCounts = {};
                services.forEach(service => {
                    serviceCounts[service.service] = service.count;
                });

                $('#barangay-name-services').text(fetchAll ? 'All Barangays' : barangay);
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
                barangay: fetchAll ? 'all' : barangay // Adjust backend to handle 'all'
            },
            success: function(genderData) {
                $('#barangay-name-gender').text(fetchAll ? 'All Barangays' : barangay);
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
                barangay: fetchAll ? 'all' : barangay // Adjust backend to handle 'all'
            },
            success: function(ageData) {
                $('#barangay-name-age').text(fetchAll ? 'All Barangays' : barangay);
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


    const monthlyAverages = @json($monthly_average); // Monthly averages from last year (as an array)
    const predictedClients = @json($predictedClients); // Predicted clients for next year
    const monthlyAverage = @json($monthly_average); // Monthly average for the previous year
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Create chart
    const ctx = document.getElementById('monthlyAverageChart').getContext('2d');


    const monthlyAverageChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months, // Set months here
            datasets: [{
                    label: 'Average Clients per Month Last Year',
                    data: Array(12).fill(monthlyAverage), // Spread monthly average across 12 months
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.1
                },
                {
                    label: 'Predicted Clients for Next Year',
                    data: Array(12).fill(predictedClients), // Spread predicted value across 12 months
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1
                },
                /* {
                label: 'Monthly Average',
                data: Array(12).fill(monthlyAverage), // Spread monthly average across 12 months
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderDash: [5, 5], // Dotted line for distinction
                fill: false
                } */
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category',
                    labels: months
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Clients'
                    }
                }
            }
        }
    });

    const barangays = @json($barangays);
    const barangayServiceCounts = @json($barangayServiceCounts);
    const servicePredictions = @json($servicePredictions);

    // Check if there are barangays to process
    if (barangays.length > 0) {
        const firstBarangay = barangays[0];
        const services = Object.keys(barangayServiceCounts[firstBarangay]);

        // Format service labels
        function formatLabel(service) {
            return service
                .replace(/_/g, ' ')
                .replace(/\b\w/g, char => char.toUpperCase());
        }

        // Prepare datasets for the service counts
        const datasets = services.map(service => ({
            label: formatLabel(service), // Format service label
            data: barangays.map(barangay => barangayServiceCounts[barangay][service]),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }));

        // Prepare datasets for service predictions
        const predictionDatasets = services.map(service => ({
            label: `${formatLabel(service)} Predictions`,
            data: barangays.map(barangay => {
                const predictions = servicePredictions[barangay][service];
                if (typeof predictions === 'object' && predictions !== null) {
                    return Object.values(predictions).reduce((sum, count) => sum + count, 0);
                } else {
                    console.warn(`Predictions for ${barangay} and ${service} is not an object or is null:`, predictions);
                    return 0;
                }
            }),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            type: 'line', // Change type for prediction lines
        }));

        // Render the chart for service counts
        const ctxServices = document.getElementById('barangayServiceChart').getContext('2d');
        const barangayServiceChart = new Chart(ctxServices, {
            type: 'bar', // Main chart type
            data: {
                labels: barangays,
                datasets: [...datasets, ...predictionDatasets],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                    },
                },
            },
        });

        // Prepare data for average income and predictions
        const averageIncomeData = JSON.parse(@json($averageIncomeData));
        const predictedAverageIncomeData = JSON.parse(@json($predictedAverageIncomeData));

        // Log the data for debugging
        console.log('Average Income Data:', averageIncomeData);
        console.log('Predicted Average Income Data:', predictedAverageIncomeData);

        // Get all unique barangay names from both datasets
        const allBarangays = new Set([
            ...Object.keys(averageIncomeData),
            ...Object.keys(predictedAverageIncomeData)
        ]);

        // Prepare income values for average income
        const incomeValues = [...allBarangays].map(barangay =>
            averageIncomeData[barangay] !== undefined ? averageIncomeData[barangay] : null // Default to null
        );

        // Prepare predicted income values
        const predectiveIncomeValues = [...allBarangays].map(barangay => {
            if (predictedAverageIncomeData[barangay]) {
                const incomes = Object.values(predictedAverageIncomeData[barangay]); // Get income values
                const averageIncome = incomes.reduce((sum, value) => sum + value, 0) / incomes.length; // Calculate average
                return averageIncome; // Return the average income
            }
            return null; // Default to null if barangay not found
        });

        // Create the income dataset
        const incomeDataset = {
            label: 'Average Income',
            data: incomeValues, // Use the income values for the dataset
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
        };

        const predictiveDataSet = {
            label: 'Predicted Income Per Barangay',
            data: predectiveIncomeValues, // Use the income values for the dataset
            backgroundColor: 'rgba(255, 159, 64, 0.2)', // Different color for distinction
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
        };

        // Render the average income chart
        const ctxIncome = document.getElementById('averageIncomeChart').getContext('2d');
        const averageIncomeChart = new Chart(ctxIncome, {
            type: 'line',
            data: {
                labels: [...allBarangays],
                datasets: [incomeDataset],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Income',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Barangays',
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            },
        });

        // Render the predicted income chart
        const ctxIncomepredection = document.getElementById('PredictionAverageIncomeChart').getContext('2d');
        const averageIncomeChartprediction = new Chart(ctxIncomepredection, {
            type: 'line',
            data: {
                labels: [...allBarangays],
                datasets: [predictiveDataSet],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Income',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Barangays',
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            },
        });


    } else {
        console.error('No barangays found');
    }
</script>
@endpush

@endsection