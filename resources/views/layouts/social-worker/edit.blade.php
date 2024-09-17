@extends('layouts.app')

@section('title', 'Edit Data')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data</h1>
        </div>
        <form action="{{ route('social-worker.update', $social-worker->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Access Data</label>
                <input type="text" name="role" id="role" class="form-control" value="{{ $social-worker->role }}">
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>
</div>
</section>
</div>
@endsection