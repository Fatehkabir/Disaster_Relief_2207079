<x-guest-layout>
    <h4 class="mb-4 fw-bold text-center">Create an account</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-500">Full Name</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-500">Email address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label fw-500">I am a…</label>
            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                <option value="victim" {{ old('role') === 'victim' ? 'selected' : '' }}>Victim / Affected Person</option>
                <option value="volunteer" {{ old('role') === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-500">Password</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-500">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-danger">Register</button>
        </div>

        <p class="text-center text-muted mb-0 small">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </p>
    </form>
</x-guest-layout>
