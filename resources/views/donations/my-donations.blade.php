@extends('layouts.app')
@section('title', 'My Donations')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">My Donations</h2>
        <a href="{{ route('donations.create') }}" class="btn btn-primary fw-bold"><i class="bi bi-plus-circle me-2"></i>Pledge Donation</a>
    </div>
    @forelse($donations as $donation)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="me-3" style="font-size:2rem">{{ $donation->category_icon }}</span>
                <div class="flex-grow-1">
                    <div class="d-flex gap-2 mb-1">{!! $donation->status_badge !!}</div>
                    <h6 class="fw-bold mb-1"><a href="{{ route('donations.show', $donation) }}" class="text-decoration-none text-dark">{{ $donation->title }}</a></h6>
                    <div class="text-muted small">{{ number_format($donation->quantity) }} {{ $donation->unit }} · {{ ucfirst(str_replace('_',' ',$donation->category)) }} · {{ $donation->created_at->diffForHumans() }}</div>
                </div>
                <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary ms-3">View</a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div style="font-size:4rem">📦</div>
        <h5 class="mt-3">No donations yet</h5>
        <p class="text-muted"><a href="{{ route('donations.create') }}">Pledge your first donation</a> to help relief efforts.</p>
    </div>
    @endforelse
    {{ $donations->links() }}
</div>
@endsection
