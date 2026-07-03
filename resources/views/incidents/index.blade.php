@extends('layouts.app')
@section('title', 'Incidents')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>⚠️ Incidents</h1>
            <p>All reported disaster incidents</p>
        </div>
        @if(auth()->user()->isVictim())
        <a href="{{ route('incidents.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-lg me-1"></i>Report Incident
        </a>
        @endif
    </div>
</div>

<div class="container">
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-3">
            <select name="type" class="form-select form-select-sm">
                <option value="">All Types</option>
                @foreach(['flood','earthquake','cyclone','fire','landslide','drought','other'] as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="severity" class="form-select form-select-sm">
                <option value="">All Severity</option>
                @foreach(['low','medium','high','critical'] as $s)
                <option value="{{ $s }}" {{ request('severity') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                @foreach(['pending','verified','active','resolved'] as $st)
                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary btn-sm w-100">Filter</button>
        </div>
    </form>

    @forelse($incidents as $incident)
    <div class="card mb-3 severity-{{ $incident->severity }}">
        <div class="card-body py-3">
            <div class="d-flex align-items-start">
                <div class="me-3 fs-3">{{ $incident->type_icon }}</div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <a href="{{ route('incidents.show', $incident) }}" class="fw-700 text-dark text-decoration-none" style="font-size:1rem">{{ $incident->title }}</a>
                        {!! $incident->severity_badge !!}
                        {!! $incident->status_badge !!}
                    </div>
                    <div class="text-muted" style="font-size:.85rem">
                        📍 {{ $incident->location_name }}
                        · 👥 {{ number_format($incident->affected_people) }} affected
                        · 📅 {{ $incident->created_at->diffForHumans() }}
                        · By {{ $incident->reporter->name }}
                    </div>
                    <div class="mt-1 text-muted" style="font-size:.83rem">{{ Str::limit($incident->description, 120) }}</div>
                </div>
                <div class="ms-3 text-end">
                    <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-outline-primary">View →</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state card">
        <i class="bi bi-check-circle-fill text-success"></i>
        <div>No incidents found matching your filters.</div>
    </div>
    @endforelse

    {{ $incidents->withQueryString()->links() }}
</div>
@endsection
