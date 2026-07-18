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
    {{-- Incidents List --}}
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
                        · By {{ $incident->reporter->name ?? 'Deleted User' }}
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
