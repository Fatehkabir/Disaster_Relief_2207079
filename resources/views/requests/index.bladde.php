@extends('layouts.app')
@section('title', 'Relief Requests')
@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="section-title mb-0">Relief Requests</h2>
            <p class="section-subtitle mb-0">Assistance needed by affected individuals</p>
        </div>
        @auth
        <a href="{{ route('requests.create') }}" class="btn btn-warning fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Submit Request
        </a>
        @endauth
    </div>

    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Search by title or location..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(['food','water','medicine','shelter','clothing','rescue','medical_assistance','psychological_support','baby_supplies','elderly_care','disability_assistance','other'] as $t)
                        <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="urgency" class="form-select">
                        <option value="">All Urgencies</option>
                        @foreach(['low','medium','high','critical'] as $u)
                        <option value="{{ $u }}" {{ request('urgency') === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['pending','acknowledged','in_progress','fulfilled','closed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-warning w-100">Filter</button>
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">✕</a>
                </div>
            </form>
        </div>
    </div>

    @if($requests->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem">🙌</div>
        <h4 class="fw-bold mt-3">No requests found</h4>
        <p class="text-muted">All requests are fulfilled or no matches found.</p>
    </div>
    @else
    <div class="row g-4">
        @foreach($requests as $request)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 {{ in_array($request->urgency, ['critical','high']) ? 'severity-'.$request->urgency : '' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        {!! $request->urgency_badge !!}
                        {!! $request->status_badge !!}
                    </div>
                    <span class="badge bg-light text-dark mb-2">{{ ucfirst(str_replace('_',' ',$request->type)) }}</span>
                    <h6 class="fw-bold">{{ $request->title }}</h6>
                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt"></i> {{ $request->location_name }}</p>
                    <p class="small text-muted mb-2">{{ Str::limit($request->description, 80) }}</p>
                    <div class="d-flex gap-3 text-muted small mb-2">
                        <span><i class="bi bi-people"></i> {{ $request->people_count }} {{ Str::plural('person', $request->people_count) }}</span>
                        <span><i class="bi bi-clock"></i> {{ $request->created_at->diffForHumans() }}</span>
                    </div>
                    @if($request->vulnerability_flags)
                    <p class="small mb-0">{{ $request->vulnerability_flags }}</p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('requests.show', $request) }}" class="btn btn-warning btn-sm w-100">View & Respond</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $requests->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
