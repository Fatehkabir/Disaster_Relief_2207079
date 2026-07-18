@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>🛡️ Admin Administration Panel</h1>
            <p>Overview of system metrics, verification, and resources</p>
        </div>
    </div>
</div>

<div class="container">
    {{-- Administrative Stats Grid --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-danger text-white border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small font-weight-bold opacity-75">Pending Incidents</h6>
                    <h2 class="font-weight-bold mb-0">{{ $stats['pending_incidents'] }}</h2>
                    <a href="{{ route('admin.incidents') }}?status=pending" class="text-white small text-decoration-none mt-2 d-inline-block">Verify incidents →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small font-weight-bold opacity-75">Pending Requests</h6>
                    <h2 class="font-weight-bold mb-0">{{ $stats['pending_requests'] }}</h2>
                    <a href="{{ route('admin.requests') }}?status=pending" class="text-dark small text-decoration-none mt-2 d-inline-block">Review requests →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small font-weight-bold opacity-75">Pledged Donations</h6>
                    <h2 class="font-weight-bold mb-0">{{ $stats['pending_donations'] }}</h2>
                    <a href="{{ route('admin.donations') }}?status=pledged" class="text-white small text-decoration-none mt-2 d-inline-block">Manage collection →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white border-0">
                <div class="card-body">
                    <h6 class="text-uppercase small font-weight-bold opacity-75">Open Volunteer Tasks</h6>
                    <h2 class="font-weight-bold mb-0">{{ $stats['open_tasks'] }}</h2>
                    <a href="{{ route('admin.tasks') }}?status=open" class="text-white small text-decoration-none mt-2 d-inline-block">Coordinations →</a>
                </div>
            </div>
        </div>
    </div>

    {{-- System Quick Actions --}}
    <div class="card mb-4">
        <div class="card-header">⚡ Administration Management Quick Links</div>
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-outline-success w-100 py-2">
                        <i class="bi bi-plus-circle me-1"></i> Create Volunteer Task
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-dark w-100 py-2">
                        <i class="bi bi-people me-1"></i> Manage System Users
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.incidents') }}" class="btn btn-outline-danger w-100 py-2">
                        <i class="bi bi-exclamation-triangle me-1"></i> Incidents Directory
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Pending Incidents Section --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>⚠️ Unverified Incident Reports</span>
                    <a href="{{ route('admin.incidents') }}?status=pending" class="btn btn-sm btn-outline-danger">Review</a>
                </div>
                <div class="card-body p-0">
                    @forelse($pendingIncidents as $inc)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $inc->title }}</div>
                            <div class="text-muted small">📍 {{ $inc->location_name }} · By {{ $inc->reporter->name ?? 'Deleted User' }}</div>
                        </div>
                        <a href="{{ route('incidents.show', $inc) }}" class="btn btn-sm btn-outline-secondary">Check</a>
                    </div>
                    @empty
                    <div class="empty-state py-3"><i class="bi bi-check-circle text-success fs-4 mb-1"></i>No pending incidents</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Urgent requests --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>⚡ Urgent Relief Requests</span>
                    <a href="{{ route('admin.requests') }}?urgency=critical" class="btn btn-sm btn-outline-warning">Review</a>
                </div>
                <div class="card-body p-0">
                    @forelse($urgentRequests as $req)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $req->title }}</div>
                            <div class="text-muted small">📍 {{ $req->location_name }} · People: {{ $req->people_count }}</div>
                        </div>
                        <div class="d-flex gap-2">
                            {!! $req->urgency_badge !!}
                            <a href="{{ route('requests.show', $req) }}" class="btn btn-sm btn-outline-secondary">Check</a>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state py-3"><i class="bi bi-check-circle text-success fs-4 mb-1"></i>No urgent pending requests</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
