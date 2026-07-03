@extends('layouts.app')
@section('title', 'Browse Donations')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>📦 Donations Directory</h1>
            <p>Browse all pledged and collected donations</p>
        </div>
        @if(auth()->user()->isVictim())
        <a href="{{ route('donations.create') }}" class="btn btn-primary">
            <i class="bi bi-gift me-1"></i>Pledge Donation
        </a>
        @endif
    </div>
</div>

<div class="container">
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-4">
            <select name="category" class="form-select form-select-sm">
                <option value="">All Categories</option>
                @foreach(['food','water','medicine','clothing','shelter_materials','hygiene','other'] as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                @foreach(['pledged','collected','delivered'] as $st)
                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-sm w-100">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Item Details</th>
                            <th>Donor</th>
                            <th>Quantity</th>
                            <th>Pickup Location</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $don)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('donations.show', $don) }}" class="fw-700 text-dark text-decoration-none">
                                    {{ $don->title }}
                                </a>
                                <div class="text-muted style-subtext" style="font-size: 0.78rem">
                                    {{ $don->category_icon }} {{ ucfirst(str_replace('_', ' ', $don->category)) }}
                                    @if($don->incident)
                                        · Link: {{ Str::limit($don->incident->title, 35) }}
                                    @endif
                                </div>
                            </td>
                            <td>👤 {{ $don->donor->name }}</td>
                            <td class="fw-600 text-primary">{{ $don->quantity }} {{ $don->unit }}</td>
                            <td>📍 {{ $don->pickup_location ?? 'N/A' }}</td>
                            <td>{!! $don->status_badge !!}</td>
                            <td>{{ $don->created_at->format('d M Y') }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('donations.show', $don) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state py-2">
                                    <i class="bi bi-box-seam"></i>
                                    <div>No donations found.</div>
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
        {{ $donations->withQueryString()->links() }}
    </div>
</div>
@endsection
