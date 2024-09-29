@extends('layouts.app')

@section('title', 'Login Accounts')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Login Accounts</h1>
        </div>

        <div class="section-body">
            @if($users->count() > 0)
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
                            <th>Contact</th>
                            <th>Login Date</th> <!-- Added Login Date Column -->
                        </tr>
                    </thead>
                    <tbody id="searchResults">
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ $user->last_login ? $user->last_login->format('F j, Y g:i A') : 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No user is logged in.</p>
            @endif
        </div>

        <script>
            // Real-time search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('#searchResults tr');

                tableRows.forEach(row => {
                    const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase(); // Name
                    const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Email

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