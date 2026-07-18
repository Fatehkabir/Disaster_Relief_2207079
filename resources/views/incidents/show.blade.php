@extends('layouts.app')
@section('title', $incident->title)
@section('content')
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('incidents.index') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to Incidents</a>
        </div>
        <h1 class="mt-1">{{ $incident->type_icon }} {{ $incident->title }}</h1>
        <div class="d-flex gap-2 flex-wrap mt-1">
            {!! $incident->severity_badge !!}
            {!! $incident->status_badge !!}
            <span class="badge bg-light text-dark">{{ ucfirst($incident->type) }}</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">📄 Incident Details</div>
                <div class="card-body">
                    <p>{{ $incident->description }}</p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted" style="font-size:.78rem;text-transform:uppercase;font-weight:600">Location</div>
                            <div>📍 {{ $incident->location_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted" style="font-size:.78rem;text-transform:uppercase;font-weight:600">Affected People</div>
                            <div>👥 {{ number_format($incident->affected_people) }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted" style="font-size:.78rem;text-transform:uppercase;font-weight:600">Reported By</div>
                            <div>{{ $incident->reporter->name ?? 'Deleted User' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted" style="font-size:.78rem;text-transform:uppercase;font-weight:600">Reported</div>
                            <div>{{ $incident->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        @if($incident->needs_volunteers)
                        <span class="badge bg-success py-2 px-3">🤝 Volunteers Needed</span>
                        @endif
                        @if($incident->needs_donations)
                        <span class="badge bg-primary py-2 px-3">📦 Donations Needed</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Volunteer Tasks --}}
            @if($incident->volunteerTasks->count() > 0)
            <div class="card mb-3">
                <div class="card-header">🤝 Volunteer Tasks ({{ $incident->volunteerTasks->count() }})</div>
                <div class="card-body p-0">
                    @foreach($incident->volunteerTasks as $task)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-600" style="font-size:.9rem">{{ $task->title }}</div>
                            <div class="text-muted" style="font-size:.78rem">{{ $task->category_label }} · {{ $task->volunteers_assigned }}/{{ $task->volunteers_needed }} volunteers</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            {!! $task->status_badge !!}
                            <a href="{{ route('volunteers.task', $task) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Relief Requests --}}
            @if($incident->reliefRequests->count() > 0)
            <div class="card">
                <div class="card-header">📋 Relief Requests ({{ $incident->reliefRequests->count() }})</div>
                <div class="card-body p-0">
                    @foreach($incident->reliefRequests->take(5) as $req)
                    <div class="d-flex align-items-center px-3 py-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-600" style="font-size:.9rem">{{ $req->title }}</div>
                            <div class="text-muted" style="font-size:.78rem">By {{ $req->user->name ?? 'Deleted User' }} · {{ $req->people_count }} people</div>
                        </div>
                        {!! $req->urgency_badge !!}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            {{-- Quick Actions --}}
            @if(auth()->user()->isVictim())
            <div class="card mb-3">
                <div class="card-header">⚡ Quick Actions</div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('requests.create') }}?incident_id={{ $incident->id }}" class="btn btn-warning">
                        <i class="bi bi-hand-index me-2"></i>Submit Relief Request
                    </a>
                    <a href="{{ route('donations.create') }}?incident_id={{ $incident->id }}" class="btn btn-primary">
                        <i class="bi bi-gift me-2"></i>Pledge Donation
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->isVolunteer() && $incident->volunteerTasks->where('status','open')->count() > 0)
            <div class="card mb-3">
                <div class="card-header">⚡ Quick Actions</div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('volunteers.tasks') }}" class="btn btn-success">
                        <i class="bi bi-list-task me-2"></i>Browse Tasks for This Incident
                    </a>
                </div>
            </div>
            @endif

            {{-- Live Weather Card --}}
            @if($weather)
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">🌤️ Live Weather at {{ $incident->location_name }}</div>
                <div class="card-body d-flex align-items-center gap-3">
                    <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png"
                         alt="{{ $weather['description'] }}" width="60" height="60">
                    <div>
                        <div class="fs-4 fw-bold">{{ round($weather['temp']) }}°C</div>
                        <div class="text-muted text-capitalize">{{ $weather['description'] }}</div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Status info --}}
            <div class="card">
                <div class="card-header">ℹ️ Status Info</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        {!! $incident->status_badge !!}
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Severity</span>
                        {!! $incident->severity_badge !!}
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Volunteer Tasks</span>
                        <span>{{ $incident->volunteerTasks->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Relief Requests</span>
                        <span>{{ $incident->reliefRequests->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
