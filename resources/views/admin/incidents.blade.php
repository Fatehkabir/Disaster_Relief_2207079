@extends('layouts.app')
@section('title', 'Manage Incidents')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Incident Management</h2>
            <p class="text-muted mb-0">{{ $incidents->total() }} total incidents</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('incidents.create') }}" class="btn btn-danger btn-sm fw-bold">+ Report Incident</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['reported','verified','active','contained','resolved','closed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="severity" class="form-select">
                        <option value="">All Severities</option>
                        @foreach(['low','medium','high','critical'] as $s)
                        <option value="{{ $s }}" {{ request('severity') === $s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-danger w-100">Filter</button>
                    <a href="{{ route('admin.incidents') }}" class="btn btn-outline-secondary">✕</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Incident</th>
                            <th>Type</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Affected</th>
                            <th>Reporter</th>
                            <th>Reported</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                        <tr class="{{ $incident->severity === 'critical' ? 'table-danger' : '' }}">
                            <td>
                                <a href="{{ route('incidents.show', $incident) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ Str::limit($incident->title, 40) }}
                                </a>
                                <div class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $incident->location_name }}</div>
                            </td>
                            <td><span style="font-size:1.2rem">{{ $incident->type_icon }}</span> <small>{{ ucfirst(str_replace('_',' ',$incident->type)) }}</small></td>
                            <td>{!! $incident->severity_badge !!}</td>
                            <td>{!! $incident->status_badge !!}</td>
                            <td class="fw-semibold">{{ number_format($incident->affected_people) }}</td>
                            <td class="text-muted small">{{ $incident->reporter->name }}</td>
                            <td class="text-muted small">{{ $incident->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($incident->status === 'reported')
                                    <form action="{{ route('admin.incidents.verify', $incident) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="verified">
                                        <button class="btn btn-sm btn-success" title="Verify"><i class="bi bi-patch-check"></i></button>
                                    </form>
                                    @endif
                                    <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No incidents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">{{ $incidents->withQueryString()->links() }}</div>
</div>
@endsection
