<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DisasterRelief') — Emergency Relief Platform</title>

    <!-- Bootstrap Icons (icon fonts only) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('styles')
    @stack('styles')
</head>
<body>



{{-- Navbar --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            🆘 Disaster<span>Relief</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            @auth
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}" href="{{ route('incidents.index') }}">
                        <i class="bi bi-exclamation-triangle me-1"></i>Incidents
                    </a>
                </li>

                @if(auth()->user()->isVictim())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('requests.*') ? 'active' : '' }}" href="{{ route('requests.my') }}">
                            <i class="bi bi-card-list me-1"></i>My Requests
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('donations.my') ? 'active' : '' }}" href="{{ route('donations.my') }}">
                            <i class="bi bi-box-seam me-1"></i>My Donations
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isVolunteer())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('volunteers.tasks') ? 'active' : '' }}" href="{{ route('volunteers.tasks') }}">
                            <i class="bi bi-list-task me-1"></i>Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('volunteers.my-tasks') ? 'active' : '' }}" href="{{ route('volunteers.my-tasks') }}">
                            <i class="bi bi-clipboard-check me-1"></i>My Tasks
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-shield-check me-1"></i>Admin Panel
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2">
                    <span class="role-badge role-{{ auth()->user()->role }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </li>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle fw-600" href="#" role="button" data-bs-toggle="dropdown" style="font-size:0.88rem">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-shield-fill me-2"></i>Admin Panel
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
            @endauth

            @guest
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-primary fw-bold" href="{{ route('register') }}">Join Now</a>
                </li>
            </ul>
            @endguest
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if(session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if(isset($errors) && $errors->any())
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<main class="py-4">
    @yield('content')
    {{ $slot ?? '' }}
</main>

{{-- Footer --}}
<footer class="py-5 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-white fw-bold mb-3">🆘 DisasterRelief</h5>
                <p class="small">Connecting victims, volunteers, donors, and organizations during emergencies. Together we rebuild lives.</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3">Platform</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('incidents.index') }}">Incidents</a></li>
                    <li><a href="{{ route('volunteers.tasks') }}">Volunteer Tasks</a></li>
                    <li><a href="{{ route('donations.index') }}">Donations</a></li>
                </ul>
            </div>
            <div class="col-md-5">
                <h6 class="text-white fw-bold mb-3">Emergency Contacts</h6>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2"></i> Emergency Hotline: <strong class="text-white">999</strong></p>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2"></i> Fire Service: <strong class="text-white">199</strong></p>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2"></i> Ambulance: <strong class="text-white">199</strong></p>
                <p class="small"><i class="bi bi-envelope-fill me-2"></i> support@disasterrelief.bd</p>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center small">
            <p class="mb-0">&copy; {{ date('Y') }} DisasterRelief Platform. Built to save lives. 🇧🇩</p>
        </div>
    </div>
</footer>

<script>
// Navbar toggle
document.addEventListener('DOMContentLoaded', function() {
    var toggler = document.querySelector('.navbar-toggler');
    var collapse = document.querySelector('.navbar-collapse');
    if (toggler && collapse) {
        toggler.addEventListener('click', function() {
            collapse.classList.toggle('show');
        });
    }
    // Dropdowns
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var menu = this.parentElement.querySelector('.dropdown-menu');
            if (menu) menu.classList.toggle('show');
        });
    });
    // Close dropdowns on outside click
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(function(m) { m.classList.remove('show'); });
    });
    // Dismiss alerts
    document.querySelectorAll('.btn-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var alert = this.closest('.alert');
            if (alert) alert.remove();
        });
    });
});
</script>
@yield('scripts')
@stack('scripts')
</body>
</html>
