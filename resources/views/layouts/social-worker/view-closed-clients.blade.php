@extends('layouts.app')

@section('title', 'Applicant Status')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Applicant Status</h1>
        </div>

        <div class="section-body">
            <div class="input-group" style="max-width: 500px; margin-bottom: 20px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Search Client">
                <button class="btn btn-primary" style="margin-left:5px;" type="submit">Search</button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Applicants with Closed Tracking</h4>
                </div>
                <div class="card-body">
                    <!-- Wrap table inside a responsive container -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Control No.</th>
                                    <th>Name</th>
                                    <th>Suffix</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Date of Birth</th>
                                    <th>Nationality</th>
                                    <th>Contact Number</th>
                                    <th>Case Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="controlnumber">{{$client->control_number}}</td>
                                    <td class="fullname">{{ $client->first_name }} {{ $client->last_name }}</td>
                                    <td class="suffix">{{ $client->suffix }}</td>
                                    <td class="age">{{ $client->age }}</td>
                                    <td class="sex">{{ $client->sex }}</td>
                                    <td class="birthday">{{ $client->date_of_birth }}</td>
                                    <td class="nationality">{{ $client->nationality }}</td>
                                    <td class="contactnumber">{{ $client->contact_number }}</td>
                                    <td class="case-status" style="padding: 5px; text-align: center;">
                                        <span style="
                background-color: {{ $client->tracking == 'Approve' ? 'green' : 'transparent' }};
                color: white;
                padding: 2px 4px;
                border-radius: 4px;">
                                            {{ $client->tracking == 'Approve' ? 'Closed' : 'Not Tracking' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm view-applicant-btn" style="width: 50px;" data-client-id="{{ $client->id }}"
                                            data-control-number="{{ $client->control_number }}"
                                            data-first-name="{{ $client->first_name }}"
                                            data-last-name="{{ $client->last_name }}"
                                            data-suffix="{{ $client->suffix }}"
                                            data-age="{{ $client->age }}"
                                            data-sex="{{ $client->sex }}"
                                            data-birthday="{{ $client->date_of_birth }}"
                                            data-nationality="{{ $client->nationality }}"
                                            data-contact-number="{{ $client->contact_number }}"
                                            data-case-status="{{ $client->tracking == 'Approve' ? 'Closed' : 'Not Tracking' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>



                        </table>
                    </div> <!-- End table-responsive -->
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" data-backdrop="false" id="viewApplicantModal" tabindex="-1" role="dialog" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicantModalLabel">Applicant Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Control No:</strong> <span id="modalControlNumber"></span></p>
                    <p><strong>Name:</strong> <span id="modalFullName"></span></p>
                    <p><strong>Suffix:</strong> <span id="modalSuffix"></span></p>
                    <p><strong>Age:</strong> <span id="modalAge"></span></p>
                    <p><strong>Sex:</strong> <span id="modalSex"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="modalBirthday"></span></p>
                    <p><strong>Nationality:</strong> <span id="modalNationality"></span></p>
                    <p><strong>Contact Number:</strong> <span id="modalContactNumber"></span></p>
                    <p><strong>Case Status:</strong> <span id="modalCaseStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="generatePdfButton">
                        <i class="fas fa-file-pdf"></i> Generate PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generatePdf(clientId) {
            window.location.href = '/generate-pdf/' + clientId;
        }

        document.querySelectorAll('.view-applicant-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the client data from the button's data attributes
                const clientId = this.dataset.clientId;
                const controlNumber = this.dataset.controlNumber;
                const firstName = this.dataset.firstName;
                const lastName = this.dataset.lastName;
                const suffix = this.dataset.suffix;
                const age = this.dataset.age;
                const sex = this.dataset.sex;
                const birthday = this.dataset.birthday;
                const nationality = this.dataset.nationality;
                const contactNumber = this.dataset.contactNumber;
                const caseStatus = this.dataset.caseStatus;

                // Update the modal content with the client data
                document.getElementById('modalControlNumber').textContent = controlNumber;
                document.getElementById('modalFullName').textContent = `${firstName} ${lastName}`;
                document.getElementById('modalSuffix').textContent = suffix;
                document.getElementById('modalAge').textContent = age;
                document.getElementById('modalSex').textContent = sex;
                document.getElementById('modalBirthday').textContent = birthday;
                document.getElementById('modalNationality').textContent = nationality;
                document.getElementById('modalContactNumber').textContent = contactNumber;
                document.getElementById('modalCaseStatus').textContent = caseStatus;


                $('#viewApplicantModal').modal('show');
                const generatePdfButton = document.getElementById('generatePdfButton');
                generatePdfButton.onclick = function() {
                    generatePdf(clientId);
                };
            });
        });
    </script>
    <div class="modal fade" data-backdrop="false" id="viewApplicantModal{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="viewApplicantModalLabel{{ $client->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicantModalLabel{{ $client->id }}">Applicant Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Control No:</strong> {{ $client->control_number }}</p>
                    <p><strong>Name:</strong> {{ $client->first_name }} {{ $client->last_name }}</p>
                    <p><strong>Suffix:</strong> {{ $client->suffix }}</p>
                    <p><strong>Age:</strong> {{ $client->age }}</p>
                    <p><strong>Sex:</strong> {{ $client->sex }}</p>
                    <p><strong>Date of Birth:</strong> {{ $client->date_of_birth }}</p>
                    <p><strong>Nationality:</strong> {{ $client->nationality }}</p>
                    <p><strong>Contact Number:</strong> {{ $client->contact_number }}</p>
                    <p><strong>Case Status:</strong> {{ $client->tracking == 'Approve' ? 'Closed' : 'Not Tracking' }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#searchResults tr');

            tableRows.forEach(row => {
                const controlNum = row.querySelector('.controlnumber').textContent.toLowerCase();
                const fullname = row.querySelector('.fullname').textContent.toLowerCase();
                const suffix = row.querySelector('.suffix').textContent.toLowerCase();
                const age = row.querySelector('.age').textContent.toLowerCase();
                const sex = row.querySelector('.sex').textContent.toLowerCase();
                const birthday = row.querySelector('.birthday').textContent.toLowerCase();
                const nationality = row.querySelector('.nationality').textContent.toLowerCase();
                const contactnumber = row.querySelector('.contactnumber').textContent.toLowerCase();
                const casestatus = row.querySelector('.case-status').textContent.toLowerCase();

                if (controlNum.includes(searchTerm) || fullname.includes(searchTerm) || suffix.includes(searchTerm) || age.includes(searchTerm) ||
                    sex.includes(searchTerm) || birthday.includes(searchTerm) || nationality.includes(searchTerm) || contactnumber.includes(searchTerm) ||
                    casestatus.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</div>
@endsection