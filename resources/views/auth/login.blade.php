@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div style="font-size:3rem">🆘</div>
                <h2 class="fw-bold">Welcome Back</h2>
                <p class="text-muted">Login to continue coordinating relief efforts</p>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   placeholder="••••••••" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-danger fw-bold">Register here</a></p>
            </div>

            {{-- Demo Accounts --}}
            <div class="card border-warning mt-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold text-warning"><i class="bi bi-info-circle me-1"></i>Demo Accounts</h6>
                    <div class="small">
                        <div class="mb-1"><strong>Admin:</strong> admin@relief.com / password</div>
                        <div class="mb-1"><strong>Volunteer:</strong> volunteer@relief.com / password</div>
                        <div class="mb-1"><strong>Donor:</strong> donor@relief.com / password</div>
                        <div><strong>Victim:</strong> victim@relief.com / password</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
