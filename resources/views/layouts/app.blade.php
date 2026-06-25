<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DisasterRelief') — Emergency Relief Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:   #dc2626;
            --primary-dark: #991b1b;
            --secondary: #1e40af;
            --accent:    #d97706;
            --success:   #16a34a;
            --surface:   #f8fafc;
            --border:    #e2e8f0;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: var(--surface); color: #1e293b; }

        .navbar-brand { font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px; }
        .navbar-brand span { color: #fbbf24; }
        .navbar { background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%); box-shadow: 0 2px 20px rgba(220,38,38,.3); }
        .navbar .nav-link { color: rgba(255,255,255,.85) !important; font-weight: 500; transition: color .2s; }
        .navbar .nav-link:hover, .navbar .nav-link.active { color: #fbbf24 !important; }
        .navbar .dropdown-menu { border: none; box-shadow: 0 10px 40px rgba(0,0,0,.15); border-radius: 12px; }

      
        .alert-ribbon { background: var(--primary); color: #fff; text-align: center; padding: 8px; font-size: .85rem; font-weight: 600; }

        .card { border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 1px 8px rgba(0,0,0,.06); transition: transform .2s, box-shadow .2s; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
        .card-header { border-radius: 14px 14px 0 0 !important; font-weight: 700; }

     
        .stat-card { border-radius: 16px; padding: 1.5rem; color: #fff; position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: rgba(255,255,255,.1); border-radius: 50%; }
        .stat-card .stat-icon { font-size: 2.5rem; opacity: .8; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 800; }
        .stat-card .stat-label { font-size: .8rem; opacity: .85; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; }

    
        .badge { font-weight: 600; padding: .35em .7em; border-radius: 6px; }


        .severity-critical { border-left: 4px solid #dc2626 !important; }
        .severity-high      { border-left: 4px solid #ea580c !important; }
        .severity-medium    { border-left: 4px solid #d97706 !important; }
        .severity-low       { border-left: 4px solid #16a34a !important; }

   
        .btn-danger { background: var(--primary); border-color: var(--primary); font-weight: 600; }
        .btn-danger:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-primary { font-weight: 600; }

 
        .section-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; }
        .section-subtitle { color: #64748b; }

        .hero { background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 50%, #b91c1c 100%); min-height: 80vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

        .timeline { position: relative; padding-left: 2rem; }
        .timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: var(--border); }
        .timeline-item { position: relative; margin-bottom: 1.5rem; }
        .timeline-item::before { content: ''; position: absolute; left: -1.65rem; top: 6px; width: 12px; height: 12px; border-radius: 50%; background: var(--primary); border: 2px solid #fff; box-shadow: 0 0 0 2px var(--primary); }


        #relief-map { height: 600px; border-radius: 14px; }

  
        .progress { border-radius: 50px; height: 8px; }
        .progress-bar { border-radius: 50px; }

    
        footer { background: #0f172a; color: #94a3b8; }
        footer a { color: #94a3b8; text-decoration: none; }
        footer a:hover { color: #fff; }

     
        @media (max-width: 768px) {
            .stat-card { margin-bottom: 1rem; }
            .hero { min-height: 60vh; }
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- Emergency Alert Ribbon (show if critical incidents exist) --}}
@php $criticalCount = \App\Models\Incident::where('severity','critical')->active()->count(); @endphp
@if($criticalCount > 0)
<div class="alert-ribbon">
    🚨 {{ $criticalCount }} CRITICAL EMERGENCY {{ Str::plural('INCIDENT', $criticalCount) }} ACTIVE —
    <a href="{{ route('incidents.index', ['severity' => 'critical']) }}" class="text-white fw-bold">VIEW NOW →</a>
</div>
@endif

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ route('home') }}">
            🆘 Disaster<span>Relief</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}" href="{{ route('incidents.index') }}">
                        <i class="bi bi-exclamation-triangle"></i> Incidents
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}" href="{{ route('map') }}">
                        <i class="bi bi-map"></i> Live Map
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('volunteers.*') ? 'active' : '' }}" href="{{ route('volunteers.tasks') }}">
                        <i class="bi bi-people"></i> Volunteer Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('donations.*') ? 'active' : '' }}" href="{{ route('donations.index') }}">
                        <i class="bi bi-box-seam"></i> Donations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('resources.*') ? 'active' : '' }}" href="{{ route('resources.index') }}">
                        <i class="bi bi-archive"></i> Resources
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feedback.impact') }}">
                        <i class="bi bi-graph-up"></i> Impact
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-warning btn-sm fw-bold" href="{{ route('register') }}">Join Now</a>
                    </li>
                @endguest
                @auth
                    {{-- Notifications --}}
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative" href="#">
                            <i class="bi bi-bell fs-5"></i>
                            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                            @if($unread > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                {{ $unread }}
                            </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->profile_photo_url }}" class="rounded-circle" width="32" height="32" alt="">
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header text-muted">
                                {!! auth()->user()->role_badge !!}
                                {{ auth()->user()->role === 'organization' ? auth()->user()->organization_name : '' }}
                            </h6></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>

                            @if(auth()->user()->isVictim())
                            <li><a class="dropdown-item" href="{{ route('requests.my') }}"><i class="bi bi-list-check me-2"></i>My Requests</a></li>
                            @endif

                            @if(auth()->user()->isVolunteer())
                            <li><a class="dropdown-item" href="{{ route('volunteers.my-tasks') }}"><i class="bi bi-clipboard-check me-2"></i>My Tasks</a></li>
                            @endif

                            @if(auth()->user()->isDonor())
                            <li><a class="dropdown-item" href="{{ route('donations.my') }}"><i class="bi bi-box-seam me-2"></i>My Donations</a></li>
                            @endif

                            @if(auth()->user()->isAdmin())
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-fill me-2"></i>Admin Panel</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if(session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if($errors->any())
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

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-white fw-bold mb-3">🆘 DisasterRelief</h5>
                <p class="small">Connecting victims, volunteers, donors, and organizations during emergencies. Together we rebuild lives.</p>
            </div>
            <div class="col-md-2">
                <h6 class="text-white fw-bold mb-3">Platform</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('incidents.index') }}">Incidents</a></li>
                    <li><a href="{{ route('map') }}">Live Map</a></li>
                    <li><a href="{{ route('volunteers.tasks') }}">Volunteer Tasks</a></li>
                    <li><a href="{{ route('donations.index') }}">Donations</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6 class="text-white fw-bold mb-3">Resources</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('resources.index') }}">Available Resources</a></li>
                    <li><a href="{{ route('feedback.impact') }}">Impact Report</a></li>
                    <li><a href="{{ route('feedback.index') }}">Feedback</a></li>
                    <li><a href="{{ route('volunteers.directory') }}">Volunteer Directory</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3">Emergency Contacts</h6>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2 text-danger"></i> Emergency Hotline: <strong class="text-white">999</strong></p>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2 text-warning"></i> Fire Service: <strong class="text-white">199</strong></p>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2 text-info"></i> Ambulance: <strong class="text-white">199</strong></p>
                <p class="small"><i class="bi bi-envelope-fill me-2"></i> support@disasterrelief.bd</p>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center small">
            <p class="mb-0">&copy; {{ date('Y') }} DisasterRelief Platform. Built to save lives. 🇧🇩</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>
