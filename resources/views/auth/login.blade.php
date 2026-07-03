<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ReliefBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,.08); padding: 2.5rem; width: 100%; max-width: 420px; }
        .auth-logo { text-align: center; margin-bottom: 1.75rem; }
        .auth-logo .icon { font-size: 2.5rem; }
        .auth-logo h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0 0; }
        .auth-logo p { color: #64748b; font-size: 0.9rem; margin: 0; }
        .form-label { font-weight: 600; font-size: 0.88rem; color: #374151; }
        .form-control { border-color: #d1d5db; border-radius: 7px; padding: 0.6rem 0.85rem; }
        .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
        .btn-primary { background: #2563eb; border: none; border-radius: 7px; font-weight: 600; padding: 0.65rem; }
        .btn-primary:hover { background: #1d4ed8; }
        .divider { text-align: center; color: #94a3b8; font-size: 0.85rem; margin: 1rem 0; }
        .test-accounts { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.85rem; font-size: 0.82rem; color: #64748b; }
        .test-accounts strong { color: #1e293b; display: block; margin-bottom: 0.4rem; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="icon">🆘</div>
        <h1>ReliefBD</h1>
        <p>Disaster Relief Platform</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-sm py-2 mb-3" style="font-size:0.88rem;border-radius:7px">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.88rem;border-radius:7px">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
    </form>

    <div class="divider">— or —</div>
    <div class="text-center mb-3">
        <span style="font-size:0.88rem;color:#64748b">Don't have an account?</span>
        <a href="{{ route('register') }}" style="font-size:0.88rem;font-weight:600;color:#2563eb">Register here</a>
    </div>

    <div class="test-accounts">
        <strong>🔑 Test Accounts (password: password)</strong>
        <div>Admin: admin@relief.com</div>
        <div>Victim: victim@relief.com</div>
        <div>Volunteer: volunteer@relief.com</div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
