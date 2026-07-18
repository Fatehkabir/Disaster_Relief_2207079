@extends('layouts.app')
@section('title', 'Donation #' . $donation->id)
@section('content')
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.donations') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to Donations Manager</a>
            @else
                <a href="{{ route('donations.my') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to My Donations</a>
            @endif
        </div>
        <h1 class="mt-1">{{ $donation->category_icon }} {{ $donation->title }}</h1>
        <div class="d-flex gap-2 flex-wrap mt-1">
            {!! $donation->status_badge !!}
            <span class="badge bg-light text-dark">Category: {{ ucfirst(str_replace('_', ' ', $donation->category)) }}</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">📄 Donation Details</div>
                <div class="card-body">
                    <p class="lead" style="font-size:1.05rem; white-space: pre-line;">{{ $donation->description }}</p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Quantity</div>
                            <div class="fs-5 fw-600 text-primary">{{ $donation->quantity }} {{ $donation->unit }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Pickup Location</div>
                            <div>📍 {{ $donation->pickup_location ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Pledged By</div>
                            <div>👤 {{ $donation->donor->name ?? 'Deleted User' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Date Pledged</div>
                            <div>📅 {{ $donation->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small fw-bold uppercase">Linked Incident</div>
                            <div>
                                @if($donation->incident)
                                    🔗 <a href="{{ route('incidents.show', $donation->incident) }}">{{ $donation->incident->title }}</a>
                                @else
                                    <span class="text-muted">General Donation (not linked to specific incident)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Admin Actions --}}
            @if(auth()->user()->isAdmin())
            <div class="card mb-3">
                <div class="card-header">⚡ Admin Actions</div>
                <div class="card-body">
                    <form action="{{ route('admin.donations.status', $donation) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                                <option value="pledged" {{ $donation->status === 'pledged' ? 'selected' : '' }}>Pledged</option>
                                <option value="collected" {{ $donation->status === 'collected' ? 'selected' : '' }}>Collected</option>
                                <option value="delivered" {{ $donation->status === 'delivered' ? 'selected' : '' }}>Delivered ✓</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">ℹ️ Donation Status Info</div>
                <div class="card-body text-center py-3">
                    <div class="fs-4 mb-2">{{ $donation->category_icon }}</div>
                    <div>Currently listed as <strong>{{ ucfirst($donation->status) }}</strong></div>
                    <div class="text-muted small mt-2">Thank you for supporting community relief.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
