@extends('layouts.app')
@section('title', 'Donations')
@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="section-title mb-0">Donation Tracker</h2>
            <p class="section-subtitle mb-0">Items and supplies pledged for relief</p>
        </div>
        @auth
        <a href="{{ route('donations.create') }}" class="btn btn-primary fw-bold"><i class="bi bi-plus-circle me-2"></i>Pledge Donation</a>
        @endauth
    </div>
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="🔍 Search donations..." value="{{ request('search') }}"></div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach(['food','water','medicine','clothing','shelter_materials','hygiene','baby_supplies','tools_equipment','furniture','electronics','other'] as $c)
                        <option value="{{ $c }}" {{ request('category') === $c ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$c)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['pledged','collected','in_transit','delivered','distributed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">✕</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row g-4">
        @forelse($donations as $donation)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span style="font-size:2rem">{{ $donation->category_icon }}</span>
                        {!! $donation->status_badge !!}
                    </div>
                    <h6 class="fw-bold">{{ $donation->title }}</h6>
                    <p class="text-muted small mb-2">{{ Str::limit($donation->description, 80) }}</p>
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>📦 {{ number_format($donation->quantity) }} {{ $donation->unit }}</span>
                        <span>{{ ucfirst(str_replace('_',' ',$donation->category)) }}</span>
                    </div>
                    <div class="text-muted small">
                        By {{ $donation->donor->name }} · {{ $donation->created_at->diffForHumans() }}
                    </div>
                    @if($donation->condition)<div class="text-muted small">Condition: {{ ucfirst($donation->condition) }}</div>@endif
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('donations.show', $donation) }}" class="btn btn-primary btn-sm w-100">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem">📦</div>
            <h5 class="mt-3">No donations found</h5>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $donations->withQueryString()->links() }}</div>
</div>
@endsection
