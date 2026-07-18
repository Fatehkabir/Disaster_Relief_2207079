<x-guest-layout>
    <h4 class="mb-3 fw-bold text-center">Forgot Password</h4>
    <p class="text-muted small text-center mb-4">Enter your email and we'll send you a password reset link.</p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-500">Email address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-danger">Email Password Reset Link</button>
        </div>

        <p class="text-center mb-0 small">
            <a href="{{ route('login') }}">← Back to login</a>
        </p>
    </form>
</x-guest-layout>
