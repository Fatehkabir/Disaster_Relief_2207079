@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container py-4">

    
    <div class="d-flex align-items-center gap-3 mb-4">
        <img src="{{ $user->profile_photo_url }}" class="rounded-circle" width="56" height="56" alt="">
        <div>
            <h4 class="fw-bold mb-0">Welcome back, {{ $user->name }}! 👋</h4>
            <div class="d-flex gap-2 align-items-center mt-1">
                {!! $user->role_badge !!}
                @if($user->is_verified) <span class="badge bg-success"><i class="bi bi-patch-check"></i> Verified</span> @endif
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-white border text-center p-3">
                <div class="fs-3">🚨</div>
                <div class="fw-bold fs-4 text-danger">{{ number_format($stats['active_incidents']) }}</div>
                <div class="small text-muted fw-semibold">Active Incidents</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-white border text-center p-3">
                <div class="fs-3">📋</div>
                <div class="fw-bold fs-4 text-warning">{{ number_format($stats['pending_requests']) }}</div>
                <div class="small text-muted fw-semibold">Pending Requests</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-white border text-center p-3">
                <div class="fs-3">🙌</div>
                <div class="fw-bold fs-4 text-success">{{ number_format($stats['total_volunteers']) }}</div>
                <div class="small text-muted fw-semibold">Active Volunteers</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-white border text-center p-3">
                <div class="fs-3">👥</div>
                <div class="fw-bold fs-4 text-primary">{{ number_format($stats['people_affected']) }}</div>
                <div class="small text-muted fw-semibold">People Affected</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">

           
            @if($user->isAdmin())
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-shield-fill me-2"></i>Admin Overview
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-4 text-center">
                            <div class="h3 fw-bold text-danger">{{ $roleData['unverified_incidents'] }}</div>
                            <div class="small text-muted">Incidents Awaiting Verification</div>
                            <a href="{{ route('admin.incidents') }}" class="btn btn-danger btn-sm mt-2">Review</a>
                        </div>
                        <div class="col-4 text-center">
                            <div class="h3 fw-bold text-warning">{{ $roleData['unverified_users'] }}</div>
                            <div class="small text-muted">Unverified Users</div>
                            <a href="{{ route('admin.users') }}" class="btn btn-warning btn-sm mt-2">Review</a>
                        </div>
                        <div class="col-4 text-center">
                            <div class="h3 fw-bold text-success">{{ $stats['fulfilled_requests'] }}</div>
                            <div class="small text-muted">Requests Fulfilled</div>
                            <a href="{{ route('admin.donations') }}" class="btn btn-success btn-sm mt-2">Donations</a>
                        </div>
                    </div>
                    @if($roleData['critical_incidents']->count())
                    <div class="alert alert-danger mb-0">
                        <strong>🚨 Critical Incidents:</strong>
                        @foreach($roleData['critical_incidents'] as $ci)
                        <a href="{{ route('incidents.show', $ci) }}" class="badge bg-danger text-decoration-none me-1">{{ $ci->title }}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif

      
            @if($user->isVictim())
            <div class="card mb-4">
                <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-list-check me-2"></i>My Relief Requests</span>
                    <a href="{{ route('requests.create') }}" class="btn btn-sm btn-outline-dark">+ New Request</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['my_requests'] as $req)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="flex-grow-1">
                            <a href="{{ route('requests.show', $req) }}" class="fw-semibold text-decoration-none text-dark">{{ $req->title }}</a>
                            <div class="small text-muted">{{ ucfirst($req->type) }} • {{ $req->people_count }} people • {{ $req->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="ms-2">{!! $req->status_badge !!}</div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2"></i>
                        <p class="mt-2 mb-0">No requests yet. <a href="{{ route('requests.create') }}">Submit one now</a></p>
                    </div>
                    @endforelse
                </div>
                @if($roleData['my_requests']->count())
                <div class="card-footer text-center bg-white">
                    <a href="{{ route('requests.my') }}" class="text-muted small">View all requests →</a>
                </div>
                @endif
            </div>
            @endif

            
            @if($user->isVolunteer())
            <div class="card mb-4">
                <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clipboard-check me-2"></i>Available Tasks</span>
                    <a href="{{ route('volunteers.tasks') }}" class="btn btn-sm btn-outline-dark">Browse All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['available_tasks'] as $task)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="flex-grow-1">
                            <a href="{{ route('volunteers.task', $task) }}" class="fw-semibold text-decoration-none text-dark">{{ $task->title }}</a>
                            <div class="small text-muted">{{ ucfirst(str_replace('_', ' ', $task->category)) }} • {{ $task->spots_left }} spots left</div>
                        </div>
                        {!! $task->priority_badge !!}
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">No open tasks right now.</div>
                    @endforelse
                </div>
            </div>
            @endif

          
            @if(isset($roleData['my_donations']))
            <div class="card mb-4">
                <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-seam me-2"></i>My Donations</span>
                    <a href="{{ route('donations.create') }}" class="btn btn-sm btn-outline-dark">+ Pledge Donation</a>
                </div>
                <div class="card-body p-0">
                    @forelse($roleData['my_donations'] as $don)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="me-3 fs-5">{{ $don->category_icon }}</div>
                        <div class="flex-grow-1">
                            <a href="{{ route('donations.show', $don) }}" class="fw-semibold text-decoration-none text-dark">{{ $don->title }}</a>
                            <div class="small text-muted">{{ $don->quantity }} {{ $don->unit }} • {{ $don->created_at->diffForHumans() }}</div>
                        </div>
                        {!! $don->status_badge !!}
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-box-seam fs-2"></i>
                        <p class="mt-2 mb-0">No donations yet. <a href="{{ route('donations.create') }}">Pledge now</a></p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            
            <div class="card">
                <div class="card-header bg-light text-dark d-flex justify-content-between">
                    <span><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Recent Active Incidents</span>
                    <a href="{{ route('incidents.index') }}" class="small text-danger text-decoration-none">View all</a>
                </div>
                <div class="card-body p-0">
                    @foreach($recentIncidents as $incident)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom severity-{{ $incident->severity }}">
                        <div class="me-3 fs-4">{{ $incident->type_icon }}</div>
                        <div class="flex-grow-1">
                            <a href="{{ route('incidents.show', $incident) }}" class="fw-semibold text-decoration-none text-dark">{{ $incident->title }}</a>
                            <div class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $incident->location_name }} · {{ $incident->created_at->diffForHumans() }}</div>
                        </div>
                        {!! $incident->severity_badge !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            
            <div class="card mb-4">
                <div class="card-header bg-light text-dark fw-bold"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</div>
                <div class="card-body d-grid gap-2">
                    @if($user->isVictim() || $user->isAdmin())
                    <a href="{{ route('requests.create') }}" class="btn btn-warning fw-semibold text-dark">
                        <i class="bi bi-hand-thumbs-up me-2"></i>Request Assistance
                    </a>
                    @endif
                    <a href="{{ route('incidents.create') }}" class="btn btn-danger fw-semibold">
                        <i class="bi bi-megaphone me-2"></i>Report Incident
                    </a>
                    @if($user->isVolunteer() || $user->isAdmin())
                    <a href="{{ route('volunteers.tasks') }}" class="btn btn-success fw-semibold">
                        <i class="bi bi-clipboard-check me-2"></i>Find Volunteer Tasks
                    </a>
                    @endif
                    @if(!$user->isAdmin())
                    <a href="{{ route('donations.create') }}" class="btn btn-primary fw-semibold">
                        <i class="bi bi-box-seam me-2"></i>Pledge Donation
                    </a>
                    @endif
                    <a href="{{ route('feedback.create') }}" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-chat-square-text me-2"></i>Submit Feedback
                    </a>
                </div>
            </div>

         
            <div class="card">
                <div class="card-header bg-light text-danger fw-bold">
                    <i class="bi bi-exclamation-circle me-2"></i>Urgent Requests
                </div>
                <div class="card-body p-0">
                    @forelse($urgentRequests as $req)
                    <div class="px-3 py-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('requests.show', $req) }}" class="fw-semibold text-decoration-none text-dark small">{{ Str::limit($req->title, 40) }}</a>
                            {!! $req->urgency_badge !!}
                        </div>
                        <div class="text-muted" style="font-size:.75rem">
                            <i class="bi bi-geo-alt"></i> {{ $req->location_name }}
                            · {{ $req->people_count }} {{ Str::plural('person', $req->people_count) }}
                        </div>
                        @if($req->vulnerability_flags)
                        <div class="text-muted" style="font-size:.7rem">{{ $req->vulnerability_flags }}</div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted small">No urgent requests at this time.</div>
                    @endforelse
                </div>
                <div class="card-footer text-center bg-white">
                    <a href="{{ route('requests.index') }}" class="small text-danger text-decoration-none">View all requests →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
