@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="text-center mb-4">
                <div style="font-size:3rem">🙌</div>
                <h2 class="fw-bold">Join the Relief Network</h2>
                <p class="text-muted">Select your role and start making a difference</p>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf

                       
                        <div class="mb-4">
                            <label class="form-label fw-bold">I am a: <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                @foreach([
                                    ['value'=>'victim','icon'=>'🆘','label'=>'Victim / Affected Person','desc'=>'Need assistance'],
                                    ['value'=>'volunteer','icon'=>'🦺','label'=>'Volunteer','desc'=>'Want to help'],
                                ] as $role)
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="role" id="role_{{ $role['value'] }}"
                                           value="{{ $role['value'] }}" {{ old('role') === $role['value'] ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-secondary w-100 text-start p-3" for="role_{{ $role['value'] }}">
                                        <span class="me-2">{{ $role['icon'] }}</span>
                                        <strong>{{ $role['label'] }}</strong>
                                        <br><small class="text-muted ms-4 ps-1">{{ $role['desc'] }}</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Your full name" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+880 1XXXXXXXXX">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="you@example.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimum 8 characters" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City / District</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="e.g. Dhaka">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Street address">
                            </div>
                        </div>

                      
                        <div id="volunteerFields" class="mt-3" style="display:none">
                            <hr>
                            <h6 class="fw-bold text-success"><i class="bi bi-person-badge me-1"></i>Volunteer Information</h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Skills & Expertise</label>
                                <input type="text" name="skills" class="form-control" value="{{ old('skills') }}"
                                       placeholder="e.g. First Aid, Driving, Cooking, Medical, Construction">
                                <div class="form-text">Comma-separated list of your skills</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Availability</label>
                                <input type="text" name="availability" class="form-control" value="{{ old('availability') }}"
                                       placeholder="e.g. Weekends, Evenings, Full-time">
                            </div>
                        </div>



                        <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold mt-4">
                            <i class="bi bi-person-check me-2"></i>Create Account
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted">Already registered? <a href="{{ route('login') }}" class="text-danger fw-bold">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const roleRadios = document.querySelectorAll('input[name="role"]');
roleRadios.forEach(r => r.addEventListener('change', function() {
    document.getElementById('volunteerFields').style.display = this.value === 'volunteer' ? 'block' : 'none';
}));

const oldRole = '{{ old("role") }}';
if (oldRole === 'volunteer') document.getElementById('volunteerFields').style.display = 'block';
</script>
@endsection
