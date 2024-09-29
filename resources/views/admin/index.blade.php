@extends('layouts.app')

@section('title', 'Social Worker Accounts')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Social Worker Accounts</h1>
        </div>
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
        @endif
        <div class="section-body">
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name or Email">
                            <div class="input-group-append">
                                <button class="btn btn-primary" style="margin-left:5px;" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="searchResults">
                        @foreach ($socialWorkers as $worker)
                        <tr>
                            <td class="name">{{ $worker->firstname . ' ' . $worker->lastname }}</td>

                            <td class="email">{{ $worker->email }}</td>
                            <!--   <td class="email">{{ $worker->password }}</td> -->
                            <td>
                                <button class="btn btn-primary" onclick="openEditModal({{ $worker->id }}, '{{ $worker->name }}', '{{ $worker->email }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>

                            <td>
                                <form action="{{ route('admin.delete', $worker->id) }}" method="POST" class="d-inline" id="delete-form-{{ $worker->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $worker->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            // Real-time search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('#searchResults tr');

                tableRows.forEach(row => {
                    const name = row.querySelector('.name').textContent.toLowerCase();
                    const email = row.querySelector('.email').textContent.toLowerCase();

                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    </section>
</div>

@endsection


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Social Worker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, name, email) {
        // Set form action URL
        document.getElementById('editForm').action = `/admin/update/${id}`;

        // Set form field values
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;

        // Show modal
        $('#editModal').modal('show');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(workerId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${workerId}`).submit();
            }
        });
    }
</script>