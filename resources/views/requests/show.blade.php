@extends('layouts.app')
@section('title', 'Relief Request #' . $reliefRequest->id)
@section('content')
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.requests') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to Requests Manager</a>
            @else
                <a href="{{ route('requests.my') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to My Requests</a>
            @endif
        </div>
        <h1 class="mt-1">{{ $reliefRequest->type_icon }} {{ $reliefRequest->title }}</h1>
        <div class="d-flex gap-2 flex-wrap mt-1">
            {!! $reliefRequest->urgency_badge !!}
            {!! $reliefRequest->status_badge !!}
            <span class="badge bg-light text-dark">Type: {{ ucfirst($reliefRequest->type) }}</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">📄 Request Details</div>
                <div class="card-body">
                    <p class="lead" style="font-size:1.05rem; white-space: pre-line;">{{ $reliefRequest->description }}</p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Location</div>
                            <div>📍 {{ $reliefRequest->location_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">People Needing Help</div>
                            <div>👥 {{ $reliefRequest->people_count }} people</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Contact Phone</div>
                            <div>📞 {{ $reliefRequest->contact_phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Requested By</div>
                            <div>👤 {{ $reliefRequest->user->name }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small fw-bold uppercase">Incident Association</div>
                            <div>
                                @if($reliefRequest->incident)
                                    🔗 <a href="{{ route('incidents.show', $reliefRequest->incident) }}">{{ $reliefRequest->incident->title }}</a>
                                @else
                                    <span class="text-muted">Not linked to a specific incident</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
         
            @if(auth()->user()->isAdmin())
            <div class="card mb-3">
                <div class="card-header">⚡ Admin Actions</div>
                <div class="card-body">
                    <form action="{{ route('admin.requests.status', $reliefRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                                <option value="pending" {{ $reliefRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="acknowledged" {{ $reliefRequest->status === 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                                <option value="fulfilled" {{ $reliefRequest->status === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                <option value="cancelled" {{ $reliefRequest->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">ℹ️ Information</div>
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Submitted</span>
                        <span>{{ $reliefRequest->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last Updated</span>
                        <span>{{ $reliefRequest->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
