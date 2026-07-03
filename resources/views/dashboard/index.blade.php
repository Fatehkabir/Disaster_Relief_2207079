@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>
            @if(auth()->user()->isAdmin()) 🛡️ Admin Dashboard
            @elseif(auth()->user()->isVictim()) 🙋 My Dashboard
            @else 🤝 Volunteer Dashboard
            @endif
        </h1>
        <p>Welcome back, <strong>{{ auth()->user()->name }}</strong></p>
    </div>
</div>

<div class="container">
  
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-danger">{{ $stats['active_incidents'] }}</div>
                <div class="stat-label">Active Incidents</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-warning">{{ $stats['pending_requests'] }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-success">{{ $stats['total_volunteers'] }}</div>
                <div class="stat-label">Volunteers</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-primary">{{ $stats['total_donations'] }}</div>
                <div class="stat-label">Donations Made</div>
            </div>
        </div>
    </div>


    @if(auth()->user()->isAdmin())
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.incidents') }}?status=pending" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #f59e0b">
                    <div class="stat-value text-warning">{{ $roleData['pending_incidents'] }}</div>
                    <div class="stat-label">Pending Incidents</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.requests') }}?status=pending" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #ef4444">
                    <div class="stat-value text-danger">{{ $roleData['pending_requests'] }}</div>
                    <div class="stat-label">Pending Requests</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.donations') }}?status=pledged" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                    <div class="stat-value text-primary">{{ $roleData['pending_donations'] }}</div>
                    <div class="stat-label">Pledged Donations</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #8b5cf6">
                    <div class="stat-value" style="color:#8b5cf6">{{ $roleData['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>⚠️ Pending Relief Requests</span>
                    <a href="{{ route('admin.requests') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['recent_requests'] as $req)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-600" style="font-size:.9rem">{{ $req->title }}</div>
                            <div class="text-muted" style="font-size:.78rem">By {{ $req->user->name }} · {{ $req->type }} · {{ ucfirst($req->urgency) }} urgency</div>
                        </div>
                        {!! $req->urgency_badge !!}
                    </div>
                    @empty
                    <div class="empty-state py-3"><i class="bi bi-check-circle text-success"></i>No pending requests</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>📦 Recent Donations</span>
                    <a href="{{ route('admin.donations') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['recent_donations'] as $don)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-600" style="font-size:.9rem">{{ $don->title }}</div>
                            <div class="text-muted" style="font-size:.78rem">By {{ $don->donor->name }} · {{ $don->quantity }} {{ $don->unit }}</div>
                        </div>
                        {!! $don->status_badge !!}
                    </div>
                    @empty
                    <div class="empty-state py-3"><i class="bi bi-box"></i>No donations yet</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    @elseif(auth()->user()->isVictim())
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                <div class="stat-value text-primary">{{ $roleData['total_requests'] }}</div>
                <div class="stat-label">My Requests</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #f59e0b">
                <div class="stat-value text-warning">{{ $roleData['pending_count'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #10b981">
                <div class="stat-value text-success">{{ $roleData['total_donations'] }}</div>
                <div class="stat-label">My Donations</div>
            </div>
        </div>
    </div>

  
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('incidents.create') }}" class="btn btn-outline-danger w-100 py-3">
                <i class="bi bi-exclamation-triangle d-block fs-4 mb-1"></i>
                Report an Incident
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('requests.create') }}" class="btn btn-outline-warning w-100 py-3">
                <i class="bi bi-hand-index d-block fs-4 mb-1"></i>
                Submit Relief Request
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('donations.create') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="bi bi-gift d-block fs-4 mb-1"></i>
                Pledge a Donation
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>📋 My Recent Requests</span>
                    <a href="{{ route('requests.my') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['my_requests'] as $req)
                    <a href="{{ route('requests.show', $req) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-600 text-dark" style="font-size:.9rem">{{ $req->title }}</div>
                                <div class="text-muted" style="font-size:.78rem">{{ ucfirst($req->type) }} · {{ $req->location_name }}</div>
                            </div>
                            {!! $req->status_badge !!}
                        </div>
                    </a>
                    @empty
                    <div class="empty-state py-3">
                        <i class="bi bi-inbox"></i>
                        <div>No requests yet. <a href="{{ route('requests.create') }}">Submit one</a></div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>📦 My Recent Donations</span>
                    <a href="{{ route('donations.my') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['my_donations'] as $don)
                    <a href="{{ route('donations.show', $don) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-600 text-dark" style="font-size:.9rem">{{ $don->title }}</div>
                                <div class="text-muted" style="font-size:.78rem">{{ $don->quantity }} {{ $don->unit }} · {{ ucfirst($don->category) }}</div>
                            </div>
                            {!! $don->status_badge !!}
                        </div>
                    </a>
                    @empty
                    <div class="empty-state py-3">
                        <i class="bi bi-box-seam"></i>
                        <div>No donations yet. <a href="{{ route('donations.create') }}">Pledge one</a></div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    @else
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-card text-center" style="border-left:4px solid #10b981">
                <div class="stat-value text-success">{{ $roleData['applied_count'] }}</div>
                <div class="stat-label">Tasks Applied</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                <div class="stat-value text-primary">{{ $roleData['available_tasks']->count() }}</div>
                <div class="stat-label">Open Tasks</div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('volunteers.tasks') }}" class="btn btn-primary">
            <i class="bi bi-search me-2"></i>Browse Open Tasks
        </a>
        <a href="{{ route('volunteers.my-tasks') }}" class="btn btn-outline-secondary ms-2">
            <i class="bi bi-clipboard-check me-2"></i>My Tasks
        </a>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>📋 My Applied Tasks</span>
                    <a href="{{ route('volunteers.my-tasks') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['my_tasks'] as $task)
                    <a href="{{ route('volunteers.task', $task) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-600 text-dark" style="font-size:.9rem">{{ $task->title }}</div>
                                <div class="text-muted" style="font-size:.78rem">{{ $task->incident->location_name ?? 'N/A' }}</div>
                            </div>
                            {!! $task->status_badge !!}
                        </div>
                    </a>
                    @empty
                    <div class="empty-state py-3">
                        <i class="bi bi-clipboard"></i>
                        <div>No tasks yet. <a href="{{ route('volunteers.tasks') }}">Browse tasks</a></div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">🟢 Available Tasks</div>
                <div class="card-body p-0">
                    @forelse($roleData['available_tasks'] as $task)
                    <a href="{{ route('volunteers.task', $task) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <div class="flex-grow-1">
                                <div class="fw-600 text-dark" style="font-size:.9rem">{{ $task->title }}</div>
                                <div class="text-muted" style="font-size:.78rem">{{ $task->location_name ?? $task->incident->location_name }} · {{ $task->spots_left }} spots left</div>
                            </div>
                            {!! $task->status_badge !!}
                        </div>
                    </a>
                    @empty
                    <div class="empty-state py-3"><i class="bi bi-check-all text-success"></i>No open tasks</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>⚠️ Active Incidents</span>
            <a href="{{ route('incidents.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
            @forelse($recentIncidents as $inc)
            <a href="{{ route('incidents.show', $inc) }}" class="text-decoration-none">
                <div class="d-flex align-items-center px-3 py-2 border-bottom severity-{{ $inc->severity }}">
                    <div class="me-3 fs-5">{{ $inc->type_icon }}</div>
                    <div class="flex-grow-1">
                        <div class="fw-600 text-dark" style="font-size:.9rem">{{ $inc->title }}</div>
                        <div class="text-muted" style="font-size:.78rem">📍 {{ $inc->location_name }} · {{ number_format($inc->affected_people) }} affected</div>
                    </div>
                    {!! $inc->severity_badge !!}
                </div>
            </a>
            @empty
            <div class="empty-state py-3"><i class="bi bi-check-circle text-success"></i>No active incidents</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
