@extends('layouts.app')
@section('title', 'Manage Relief Requests')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>📋 Manage Relief Requests</h1>
        <p>Acknowledge or fulfill requests submitted by victims</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Request Details</th>
                            <th>Victim</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Change Status</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('requests.show', $req) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $req->title }}
                                </a>
                                <div class="text-muted small">
                                    {{ $req->type_icon }} {{ ucfirst($req->type) }} · People: {{ $req->people_count }} · 📍 {{ $req->location_name }}
                                </div>
                            </td>
                            <td>👤 {{ $req->user->name ?? 'Deleted User' }}</td>
                            <td>{!! $req->urgency_badge !!}</td>
                            <td>{!! $req->status_badge !!}</td>
                            <td>
                                <form action="{{ route('admin.requests.status', ['reliefRequest' => $req->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="acknowledged" {{ $req->status === 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                                        <option value="fulfilled" {{ $req->status === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                        <option value="cancelled" {{ $req->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('requests.show', $req) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $requests->links() }}
    </div>
</div>
@endsection
