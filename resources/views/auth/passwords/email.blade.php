@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">
                    {{ __('Reset Password') }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="form-reset-password">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback d-block text-center mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                    <div class="card-footer ">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .form-reset-password .form-group {
        margin-bottom: 1rem;
    }

    .form-reset-password .form-label {
        display: block;
        margin-bottom: .5rem;
    }

    .form-reset-password .form-control {
        max-width: 76%;
    }

    .form-reset-password .btn {
        max-width: 100%;
    }


    .form-reset-password .btn {
        width: 100%;
        max-width: 400px;
    }

    .card-footer {
        margin-left: 50px;
    }

    .form-group {
        margin-left: 70px;
    }
</style>