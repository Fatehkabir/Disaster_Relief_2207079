@extends('layouts.app')
@section('title', 'Manage Donations')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>📦 Manage Donations</h1>
        <p>Approve pledges, register collections, and track distribution</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Donation Item</th>
                            <th>Donor</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $don)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('donations.show', $don) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $don->title }}
                                </a>
                                <div class="text-muted small">
                                    {{ $don->category_icon }} {{ ucfirst(str_replace('_', ' ', $don->category)) }} · 📍 Pickup: {{ $don->pickup_location }}
                                </div>
                            </td>
                            <td>👤 {{ $don->donor->name ?? 'Deleted User' }}</td>
                            <td class="fw-bold text-primary">{{ $don->quantity }} {{ $don->unit }}</td>
                            <td>{!! $don->status_badge !!}</td>
                            <td>
                                <form action="{{ route('admin.donations.status', $don) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pledged" {{ $don->status === 'pledged' ? 'selected' : '' }}>Pledged</option>
                                        <option value="collected" {{ $don->status === 'collected' ? 'selected' : '' }}>Collected</option>
                                        <option value="delivered" {{ $don->status === 'delivered' ? 'selected' : '' }}>Delivered ✓</option>
                                    </select>
                                </form>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('donations.show', $don) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No donations found.</td>
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
