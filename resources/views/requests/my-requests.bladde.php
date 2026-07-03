@extends('layouts.app')
@section('title', 'My Relief Requests')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>📋 My Relief Requests</h1>
            <p>Track the status of your submitted relief requests</p>
        </div>
        <a href="{{ route('requests.create') }}" class="btn btn-warning text-dark">
            <i class="bi bi-plus-lg me-1"></i>Request Help
        </a>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Title</th>
                            <th>Type</th>
                            <th>People Count</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('requests.show', $req) }}" class="fw-600 text-dark text-decoration-none">
                                    {{ $req->title }}
                                </a>
                                @if($req->incident)
                                    <div class="text-muted" style="font-size:0.75rem">Linked: {{ Str::limit($req->incident->title, 40) }}</div>
                                @endif
                            </td>
                            <td>{{ $req->type_icon }} {{ ucfirst($req->type) }}</td>
                            <td>{{ $req->people_count }}</td>
                            <td>{!! $req->urgency_badge !!}</td>
                            <td>{!! $req->status_badge !!}</td>
                            <td>{{ $req->created_at->format('d M Y') }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('requests.show', $req) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state py-2">
                                    <i class="bi bi-inbox text-muted"></i>
                                    <div>You have not submitted any relief requests yet.</div>
                                    <a href="{{ route('requests.create') }}" class="btn btn-sm btn-warning text-dark mt-2">Request Assistance Now</a>
                                </div>
                            </td>
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
