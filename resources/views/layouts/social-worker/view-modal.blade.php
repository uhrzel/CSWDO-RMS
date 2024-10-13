<style>
    .order-tracker {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .order-step {
        text-align: center;
        flex: 1;
    }

    .order-step i {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .progress-bar {
        height: 5px;
        background-color: #6777ef;
    }

    .modal-body {
        overflow-y: auto;
        /* Enable vertical scrolling */
        max-height: 70vh;
        /* Set a maximum height */
        padding: 20px;

    }
</style>
@php
$problemIdentificationStatus = 'Incomplete';
@endphp
@foreach($clients as $client)

@php
// Count the number of tasks marked as 'Done'
$totalTasks = 4;
$completedTasks = 0;

if ($client->problem_identification == 'Done') $completedTasks++;
if ($client->data_gather == 'Done') $completedTasks++;
if ($client->assessment == 'Done') $completedTasks++;
if ($client->eval == 'Done') $completedTasks++;

// Calculate the progress percentage
$progressPercentage = ($completedTasks / $totalTasks) * 100;
$progressColor = $completedTasks == $totalTasks ? 'bg-success' : 'bg-dark';
@endphp

<div class="modal fade" data-backdrop="false" id="viewClientModal{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="viewClientModalLabel{{ $client->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClientModalLabel{{ $client->id }}">Applicant Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>View Applicant History</h5>
                <section class="section">
                    <div class="section-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="progress mb-3">
                                    <div class="progress-bar {{ $progressColor }}" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="order-tracker">
                                    <div class="order-step">
                                        <i class="fas fa-search 
                            @if($client->problem_identification == 'Done') text-success
                            @elseif($client->problem_identification == 'Processing') text-warning
                            @elseif($client->problem_identification == 'Incomplete') text-danger
                            @endif"></i>
                                        <p>Problem Identification</p>
                                    </div>

                                    <div class="order-step">
                                        <i class="fas fa-database 
                            @if($client->data_gather == 'Done') text-success
                            @elseif($client->data_gather == 'Processing') text-warning
                            @elseif($client->data_gather == 'Incomplete') text-danger
                            @endif"></i>
                                        <p>Data Gathering</p>
                                    </div>

                                    <div class="order-step">
                                        <i class="fas fa-chart-line 
                            @if($client->assessment == 'Done') text-success
                            @elseif($client->assessment == 'Processing') text-warning
                            @elseif($client->assessment == 'Incomplete') text-danger
                            @endif"></i>
                                        <p>Assessment</p>
                                    </div>

                                    <div class="order-step">
                                        <i class="fas fa-check-circle 
                            @if($client->eval == 'Done') text-success
                            @elseif($client->eval == 'Processing') text-warning
                            @elseif($client->eval == 'Incomplete') text-danger
                            @endif"></i>
                                        <p>Evaluation And Resolution</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <div class="client-info">
                    <h6 class="text-muted mb-3">Applicant Details</h6>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Control No:</strong> {{ $client->control_number }}</div>
                        <div class="col-md-6"><strong>First Name:</strong> {{ $client->first_name }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Last Name:</strong> {{ $client->last_name }}</div>
                        <div class="col-md-6"><strong>Middle Name:</strong> {{ $client->middle }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Suffix:</strong> {{ $client->suffix }}</div>
                        <div class="col-md-6"><strong>Age:</strong> {{ $client->age }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Sex:</strong> {{ $client->sex }}</div>
                        <div class="col-md-6"><strong>Date of Birth:</strong> {{ $client->date_of_birth }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Place of Birth:</strong> {{ $client->pob }}</div>
                        <div class="col-md-6"><strong>Educational Attainment:</strong> {{ $client->educational_attainment }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Civil Status:</strong> {{ $client->civil_status }}</div>
                        <div class="col-md-6"><strong>Religion:</strong> {{ $client->religion }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Nationality:</strong> {{ $client->nationality }}</div>
                        <div class="col-md-6"><strong>Occupation:</strong> {{ $client->occupation }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Monthly Income:</strong> {{ $client->monthly_income }}</div>
                        <div class="col-md-6"><strong>Contact Number:</strong> {{ $client->contact_number }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Building Number:</strong> {{ $client->building_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Street Name:</strong> {{ $client->street_name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Barangay:</strong> {{ $client->barangay ?? 'N/A' }}
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Household Information</h6>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>House Structure:</strong> {{ $client->house_structure }}</div>
                        <div class="col-md-6"><strong>Number of Rooms:</strong> {{ $client->number_of_rooms }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Appliances:</strong> {{ $client->appliances }}</div>
                        <div class="col-md-6"><strong>Monthly Expenses:</strong> @php
                            $expenses = json_decode($client->monthly_expenses, true); // Decode JSON data into an associative array
                            @endphp

                            @if(is_array($expenses))
                            @foreach($expenses as $key => $value)
                            @if($value) <!-- Check if value is not empty -->
                            <div>{{ $key }} - {{ $value }}</div>
                            @endif
                            @endforeach
                            @else
                            <div>No expenses data available.</div>
                            @endif
                        </div>
                    </div>


                    <hr>

                    <h4 class="mb-3">Services</h4>

                    <div class="form-group">
                        <?php

                        $clientServices = is_array($client->services) ? $client->services : json_decode($client->services, true);
                        $clientServices = is_array($clientServices) ? $clientServices : [];


                        $serviceCategories = [
                            'Burial Assistance' => [
                                'Burial',
                                'Financial',
                                'Funeral',
                                'Crisis Intervention Unit = Valid ID',
                                'Barangay Clearance.',
                                'Medical Certificate.',
                                'Incident Report.',
                                'Funeral Contract.',
                                'Death Certificate.'
                            ],
                            'Solo Parent Services' => [
                                'Solo Parent = Agency Referral',
                                'Residency Cert.',
                                'Medical Cert.',
                                'Billing Proof',
                                'Birth Cert.',
                                'ID Copy',
                                'Senior Citizen ID (60+)'
                            ],
                            'Pre-marriage Counseling' => [
                                'Pre-marriage Counseling = Valid ID',
                                'Birth Certificate',
                                'CENOMAR',
                                'Barangay Clearance',
                                'Passport-sized Photos'
                            ],
                            'After-Care Services' => [
                                'After-Care Services = Valid ID',
                                'Birth Certificate.',
                                'Residence Certificate.',
                                'SCSR',
                                'Medical Records',
                            ],
                            'Poverty Alleviation Program' => [
                                'Poverty Alleviation Program = Valid ID',
                                'Residence Certificate',
                                'Income Certificate',
                                'Application Form'
                            ],
                            'Crisis Intervention Unit' => [
                                'Valid ID',
                                'Residence Certificate Or Barangay Clearance',
                                'Clinical Abstract Medical Certificate',
                                'Police Report Or Incident Report',
                                'Funeral Contract And Registered Death Certificate. (if Applicable)'
                            ]
                        ];


                        foreach ($serviceCategories as $category => $services) {
                            $filteredServices = array_intersect($services, $clientServices);


                            if (!empty($filteredServices)) {
                                echo "<h5><label>{$category}</label></h5>";
                                echo "<div class='checkbox-group'>";


                                echo "<p><strong>Requirements:</strong></p>";


                                foreach ($services as $service) {

                                    $isChecked = in_array($service, $clientServices) ? 'checked' : '';
                                    echo "<div class='form-check'>";
                                    echo "<input type='checkbox' class='form-check-input' name='services[]' value='{$service}' {$isChecked} onclick='return false;'>"; // prevent checkbox change
                                    echo "<label class='form-check-label'>{$service}</label>";
                                    echo "</div>";
                                }

                                echo "</div><br>";
                            }
                        }
                        ?>
                    </div>



                    <hr>
                    <h6 class="text-muted mb-3">Additional Information</h6>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Services and Requirements:</strong> {{ $client->services_and_requirements }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Circumstances of Referral:</strong> {{ $client->circumstances_of_referral }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Family Background:</strong> {{ $client->family_background }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Health History:</strong> {{ $client->health_history }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Economic Situation:</strong> {{ $client->economic_situation }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Recommendation:</strong> {{ $client->recommendation }}</div>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Interview and Approval Details</h6>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Interviewee:</strong> {{ $client->interviewee }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Interview By:</strong> {{ $client->interviewed_by }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Reviewing:</strong> {{ $client->reviewing }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12"><strong>Approved by:</strong> {{ $client->approving }}</div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="generatePdf({{ $client->id }})">
                    <i class="fas fa-file-pdf"></i> Generate PDF
                </button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach