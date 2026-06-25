@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-0"><i class="bi bi-shield-fill text-danger me-2"></i>Admin Control Panel</h2>
                <p class="text-muted mb-0">Full platform oversight and coordination</p>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#dc2626,#991b1b)">
                    <div class="stat-icon">🚨</div>
                    <div class="stat-value">{{ $stats['active_incidents'] }}</div>
                    <div class="stat-label">Active Incidents</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#d97706,#92400e)">
                    <div class="stat-icon">📋</div>
                    <div class="stat-value">{{ $stats['pending_requests'] }}</div>
                    <div class="stat-label">Pending Requests</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#16a34a,#14532d)">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value">{{ $stats['fulfilled_requests'] }}</div>
                    <div class="stat-label">Fulfilled</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#2563eb,#1e3a8a)">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value">{{ number_format($stats['total_affected']) }}</div>
                    <div class="stat-label">People Affected</div>
                </div>
            </div>
        </div>


        @if($stats['pending_verification'] > 0 || $stats['unverified_users'] > 0 || $stats['urgent_requests'] > 0)
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <h6 class="fw-bold mb-2">⚠️ Requires Immediate Attention</h6>
            <div class="d-flex flex-wrap gap-3">
                @if($stats['pending_verification'] > 0)
                <a href="{{ route('admin.incidents', ['status' => 'reported']) }}" class="btn btn-danger btn-sm">
                    🚨 {{ $stats['pending_verification'] }} Incidents Awaiting Verification
                </a>
                @endif
                @if($stats['unverified_users'] > 0)
                <a href="{{ route('admin.users', ['verified' => 'no']) }}" class="btn btn-warning btn-sm">
                    👤 {{ $stats['unverified_users'] }} Unverified Organizations
                </a>
                @endif
                @if($stats['urgent_requests'] > 0)
                <a href="{{ route('requests.index', ['urgency' => 'critical', 'status' => 'pending']) }}" class="btn btn-danger btn-sm">
                    🆘 {{ $stats['urgent_requests'] }} Critical Requests Pending
                </a>
                @endif
            </div>
        </div>
        @endif

        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-lg-8">

                {{-- Monthly Trends Chart --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bar-chart me-2 text-primary"></i>Monthly Activity (Last 6 Months)</span>
                        <a href="{{ route('admin.analytics') }}" class="btn btn-sm btn-outline-primary">Full Analytics</a>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="100"></canvas>
                    </div>
                </div>


                @if($criticalIncidents->count() > 0)
                <div class="card mb-4 border-danger">
                    <div class="card-header fw-bold bg-danger text-white">
                        🔴 Critical Active Incidents ({{ $criticalIncidents->count() }})
                    </div>
                    <div class="card-body p-0">
                        @foreach($criticalIncidents as $inc)
                        <div class="d-flex align-items-center px-3 py-3 border-bottom">
                            <div class="flex-grow-1">
                                <a href="{{ route('incidents.show', $inc) }}" class="fw-semibold text-decoration-none text-dark">{{ $inc->title }}</a>
                                <div class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $inc->location_name }} · {{ number_format($inc->affected_people) }} affected · {{ $inc->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="d-flex gap-2 ms-2">
                                <a href="{{ route('incidents.show', $inc) }}" class="btn btn-danger btn-sm">Review</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

       
                @if($pendingIncidents->count() > 0)
                <div class="card mb-4">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-clock me-2 text-warning"></i>Incidents Awaiting Verification</span>
                        <a href="{{ route('admin.incidents', ['status' => 'reported']) }}" class="btn btn-sm btn-outline-warning">View All</a>
                    </div>
                    <div class="card-body p-0">
                        @foreach($pendingIncidents as $inc)
                        <div class="d-flex align-items-center px-3 py-3 border-bottom">
                            <div class="me-3" style="font-size:1.5rem">{{ $inc->type_icon }}</div>
                            <div class="flex-grow-1">
                                <a href="{{ route('incidents.show', $inc) }}" class="fw-semibold text-decoration-none text-dark">{{ $inc->title }}</a>
                                <div class="text-muted small">By {{ $inc->reporter->name }} · {{ $inc->location_name }} · {{ $inc->created_at->diffForHumans() }}</div>
                            </div>
                            {!! $inc->severity_badge !!}
                            <a href="{{ route('incidents.show', $inc) }}" class="btn btn-sm btn-outline-primary ms-2">Verify</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header fw-bold"><i class="bi bi-pie-chart me-2"></i>Requests by Type</div>
                            <div class="card-body">
                                @foreach($requestTypes->take(6) as $rt)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small">{{ ucfirst(str_replace('_',' ',$rt->type)) }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="width:80px">
                                            <div class="progress-bar bg-warning" style="width:{{ $requestTypes->max('count') > 0 ? ($rt->count/$requestTypes->max('count')*100) : 0 }}%"></div>
                                        </div>
                                        <span class="badge bg-warning text-dark">{{ $rt->count }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header fw-bold"><i class="bi bi-pie-chart me-2"></i>Incidents by Type</div>
                            <div class="card-body">
                                @foreach($incidentTypes->take(6) as $it)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small">{{ ucfirst(str_replace('_',' ',$it->type)) }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="width:80px">
                                            <div class="progress-bar bg-danger" style="width:{{ $incidentTypes->max('count') > 0 ? ($it->count/$incidentTypes->max('count')*100) : 0 }}%"></div>
                                        </div>
                                        <span class="badge bg-danger">{{ $it->count }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-4">

                <div class="card mb-4">
                    <div class="card-header fw-bold"><i class="bi bi-grid me-2"></i>Platform Summary</div>
                    <div class="card-body p-0">
                        @foreach([
                            ['label'=>'Total Users','value'=>$stats['total_users'],'icon'=>'bi-people','color'=>'primary'],
                            ['label'=>'Volunteers','value'=>$stats['volunteers'],'icon'=>'bi-person-check','color'=>'success'],
                            ['label'=>'Donors','value'=>$stats['donors'],'icon'=>'bi-box-seam','color'=>'info'],
                            ['label'=>'Organizations','value'=>$stats['organizations'],'icon'=>'bi-building','color'=>'purple'],
                            ['label'=>'Total Incidents','value'=>$stats['total_incidents'],'icon'=>'bi-exclamation-triangle','color'=>'danger'],
                            ['label'=>'Volunteer Tasks','value'=>$stats['total_tasks'],'icon'=>'bi-clipboard-check','color'=>'success'],
                            ['label'=>'Total Donations','value'=>$stats['total_donations'],'icon'=>'bi-gift','color'=>'primary'],
                            ['label'=>'Distributed','value'=>$stats['distributed_donations'],'icon'=>'bi-check-circle','color'=>'success'],
                        ] as $item)
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <i class="bi {{ $item['icon'] }} text-{{ $item['color'] }} me-3"></i>
                            <span class="flex-grow-1 text-muted small">{{ $item['label'] }}</span>
                            <strong>{{ number_format($item['value']) }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>

       
                <div class="card mb-4">
                    <div class="card-header fw-bold"><i class="bi bi-lightning me-2 text-warning"></i>Admin Actions</div>
                    <div class="card-body d-grid gap-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-people me-2"></i>Manage Users</a>
                        <a href="{{ route('admin.incidents') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-exclamation-triangle me-2"></i>Manage Incidents</a>
                        <a href="{{ route('admin.donations') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-seam me-2"></i>Manage Donations</a>
                        <a href="{{ route('admin.analytics') }}" class="btn btn-outline-success btn-sm"><i class="bi bi-graph-up me-2"></i>Analytics</a>
                        <a href="{{ route('incidents.create') }}" class="btn btn-danger btn-sm"><i class="bi bi-plus-circle me-2"></i>Report Incident</a>
                        <a href="{{ route('volunteers.create-task') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-circle me-2"></i>Create Task</a>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header fw-bold"><i class="bi bi-person-plus me-2"></i>Recent Registrations</div>
                    <div class="card-body p-0">
                        @foreach($recentUsers as $u)
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <img src="{{ $u->profile_photo_url }}" class="rounded-circle me-2" width="30" height="30" alt="">
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $u->name }}</div>
                                <div style="font-size:.7rem" class="text-muted">{{ $u->created_at->diffForHumans() }}</div>
                            </div>
                            {!! $u->role_badge !!}
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.users') }}" class="small text-primary">View all users →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const monthlyData = @json($monthlyData);
const labels    = monthlyData.map(d => d.month);
const incidents = monthlyData.map(d => d.incidents);
const requests  = monthlyData.map(d => d.requests);
const donations = monthlyData.map(d => d.donations);

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            { label: 'Incidents', data: incidents, backgroundColor: 'rgba(220,38,38,.8)',  borderRadius: 4 },
            { label: 'Requests',  data: requests,  backgroundColor: 'rgba(217,119,6,.8)',  borderRadius: 4 },
            { label: 'Donations', data: donations, backgroundColor: 'rgba(37,99,235,.8)',  borderRadius: 4 },
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection
