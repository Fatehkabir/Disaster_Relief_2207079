<x-guest-layout>
    <h4 class="mb-3 fw-bold text-center">Confirm Password</h4>
    <p class="text-muted small text-center mb-4">This is a secure area of the application. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label fw-500">Password</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
    </form>
</x-guest-layout>
