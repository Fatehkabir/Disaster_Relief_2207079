@extends('layouts.app')
@section('title', 'Manage Incidents')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>⚠️ Manage Incidents</h1>
            <p>Verify reported incidents and adjust active status</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Incident Title</th>
                            <th>Reporter</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Change Status</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $inc)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('incidents.show', $inc) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $inc->title }}
                                </a>
                                <div class="text-muted small">📍 {{ $inc->location_name }}</div>
                            </td>
                            <td>👤 {{ $inc->reporter->name ?? 'Deleted User' }}</td>
                            <td>{!! $inc->severity_badge !!}</td>
                            <td>{!! $inc->status_badge !!}</td>
                            <td>
                                <form action="{{ route('admin.incidents.status', $inc) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $inc->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="verified" {{ $inc->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="active" {{ $inc->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="resolved" {{ $inc->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </form>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('incidents.show', $inc) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No incidents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $incidents->links() }}
    </div>
</div>
@endsection
