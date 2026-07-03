@extends('layouts.app')
@section('title', 'My Pledged Donations')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>📦 My Pledged Donations</h1>
            <p>Track items you pledged to donate</p>
        </div>
        <a href="{{ route('donations.create') }}" class="btn btn-primary">
            <i class="bi bi-gift me-1"></i>Pledge Donation
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
                            <th class="ps-3">Donated Item</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Pickup Location</th>
                            <th>Status</th>
                            <th>Pledged At</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $don)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('donations.show', $don) }}" class="fw-600 text-dark text-decoration-none">
                                    {{ $don->title }}
                                </a>
                                @if($don->incident)
                                    <div class="text-muted" style="font-size:0.75rem">For Incident: {{ Str::limit($don->incident->title, 40) }}</div>
                                @endif
                            </td>
                            <td>{{ $don->category_icon }} {{ ucfirst(str_replace('_', ' ', $don->category)) }}</td>
                            <td class="fw-600 text-primary">{{ $don->quantity }} {{ $don->unit }}</td>
                            <td>📍 {{ Str::limit($don->pickup_location, 30) }}</td>
                            <td>{!! $don->status_badge !!}</td>
                            <td>{{ $don->created_at->format('d M Y') }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('donations.show', $don) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state py-2">
                                    <i class="bi bi-box-seam text-muted"></i>
                                    <div>You have not pledged any donations yet.</div>
                                    <a href="{{ route('donations.create') }}" class="btn btn-sm btn-primary mt-2">Pledge a Donation Now</a>
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
        {{ $donations->links() }}
    </div>
</div>
@endsection
