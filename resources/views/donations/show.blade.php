@extends('layouts.app')
@section('title', $donation->title)
@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <div class="flex-grow-1">
            <div class="d-flex gap-2 mb-1">
                <span style="font-size:1.5rem">{{ $donation->category_icon }}</span>
                {!! $donation->status_badge !!}
            </div>
            <h3 class="fw-bold mb-0">{{ $donation->title }}</h3>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Donation Details</h5>
                    <p>{{ $donation->description }}</p>
                    @if($donation->notes)<div class="alert alert-light"><strong>Notes:</strong> {{ $donation->notes }}</div>@endif
                    @if($donation->photos && count($donation->photos) > 0)
                    <div class="row g-2 mt-2">
                        @foreach($donation->photos as $p)
                        <div class="col-6"><img src="{{ asset('storage/'.$p) }}" class="img-fluid rounded-3" alt=""></div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @auth
            @if(auth()->user()->isAdmin())
            <div class="card">
                <div class="card-header fw-bold">Update Donation Status</div>
                <div class="card-body">
                    <form action="{{ route('donations.update-status', $donation) }}" method="POST" class="d-flex gap-2">
                        @csrf @method('PATCH')
                        <select name="status" class="form-select">
                            @foreach(['pledged','collected','in_transit','delivered','distributed'] as $s)
                            <option value="{{ $s }}" {{ $donation->status === $s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary fw-semibold px-4">Update</button>
                    </form>
                </div>
            </div>
            @endif
            @endauth
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header fw-bold">Info</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted small">Quantity</dt>
                        <dd class="col-7 fw-bold">{{ number_format($donation->quantity) }} {{ $donation->unit }}</dd>
                        <dt class="col-5 text-muted small">Condition</dt>
                        <dd class="col-7">{{ ucfirst($donation->condition ?? 'Not specified') }}</dd>
                        <dt class="col-5 text-muted small">Category</dt>
                        <dd class="col-7">{{ ucfirst(str_replace('_',' ',$donation->category)) }}</dd>
                        <dt class="col-5 text-muted small">Donor</dt>
                        <dd class="col-7">{{ $donation->donor->name }}</dd>
                        @if($donation->pickup_location)
                        <dt class="col-5 text-muted small">Pickup</dt>
                        <dd class="col-7">{{ $donation->pickup_location }}</dd>
                        @endif
                        @if($donation->available_from)
                        <dt class="col-5 text-muted small">Available From</dt>
                        <dd class="col-7">{{ $donation->available_from->format('d M Y') }}</dd>
                        @endif
                        @if($donation->incident)
                        <dt class="col-5 text-muted small">For Incident</dt>
                        <dd class="col-7"><a href="{{ route('incidents.show', $donation->incident) }}" class="text-danger small">{{ Str::limit($donation->incident->title, 25) }}</a></dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
