<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — ReliefBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 0; }
        .auth-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,.08); padding: 2.5rem; width: 100%; max-width: 460px; }
        .auth-logo { text-align: center; margin-bottom: 1.75rem; }
        .auth-logo .icon { font-size: 2.5rem; }
        .auth-logo h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0 0; }
        .auth-logo p { color: #64748b; font-size: 0.9rem; margin: 0; }
        .form-label { font-weight: 600; font-size: 0.88rem; color: #374151; }
        .form-control, .form-select { border-color: #d1d5db; border-radius: 7px; padding: 0.6rem 0.85rem; }
        .form-control:focus, .form-select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
        .btn-primary { background: #2563eb; border: none; border-radius: 7px; font-weight: 600; padding: 0.65rem; }
        .btn-primary:hover { background: #1d4ed8; }
        .role-option { border: 2px solid #e2e8f0; border-radius: 8px; padding: 0.75rem 1rem; cursor: pointer; transition: all .15s; }
        .role-option:hover { border-color: #93c5fd; background: #eff6ff; }
        input[name=role]:checked + .role-option { border-color: #2563eb; background: #eff6ff; }
        .role-option .role-title { font-weight: 600; font-size: 0.9rem; color: #1e293b; }
        .role-option .role-desc { font-size: 0.78rem; color: #64748b; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="icon">🆘</div>
        <h1>Create Account</h1>
        <p>Join the ReliefBD platform</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.88rem;border-radius:7px">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your full name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number <span class="text-muted fw-normal">(optional)</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
        </div>

        <div class="mb-4">
            <label class="form-label d-block mb-2">I am registering as a...</label>
            <div class="row g-2">
                <div class="col-6">
                    <label class="d-block">
                        <input type="radio" name="role" value="victim" class="d-none" {{ old('role', 'victim') === 'victim' ? 'checked' : '' }}>
                        <div class="role-option">
                            <div class="role-title">🟡 Victim</div>
                            <div class="role-desc">I need relief assistance</div>
                        </div>
                    </label>
                </div>
                <div class="col-6">
                    <label class="d-block">
                        <input type="radio" name="role" value="volunteer" class="d-none" {{ old('role') === 'volunteer' ? 'checked' : '' }}>
                        <div class="role-option">
                            <div class="role-title">🟢 Volunteer</div>
                            <div class="role-desc">I want to help others</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>

        <div class="text-center mt-3">
            <span style="font-size:0.88rem;color:#64748b">Already have an account?</span>
            <a href="{{ route('login') }}" style="font-size:0.88rem;font-weight:600;color:#2563eb"> Login</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
