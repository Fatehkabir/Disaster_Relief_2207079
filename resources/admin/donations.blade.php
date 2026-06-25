@extends('layouts.app')
@section('title', 'Manage Donations')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Donation Management</h2>
            <p class="text-muted mb-0">{{ $donations->total() }} total donations</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['pledged','collected','in_transit','delivered','distributed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach(['food','water','medicine','clothing','shelter_materials','hygiene','baby_supplies','tools_equipment','other'] as $c)
                        <option value="{{ $c }}" {{ request('category') === $c ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$c)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('admin.donations') }}" class="btn btn-outline-secondary">✕</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Donation</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Donor</th>
                            <th>Incident</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donation)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ Str::limit($donation->title, 35) }}</div>
                                @if($donation->pickup_location)
                                <div class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $donation->pickup_location }}</div>
                                @endif
                            </td>
                            <td><span class="me-1">{{ $donation->category_icon }}</span><small>{{ ucfirst(str_replace('_',' ',$donation->category)) }}</small></td>
                            <td class="fw-semibold">{{ number_format($donation->quantity) }} {{ $donation->unit }}</td>
                            <td>{!! $donation->status_badge !!}</td>
                            <td class="text-muted small">{{ $donation->donor->name }}</td>
                            <td class="text-muted small">{{ $donation->incident ? Str::limit($donation->incident->title, 25) : '—' }}</td>
                            <td class="text-muted small">{{ $donation->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                    <form action="{{ route('donations.update-status', $donation) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" style="width:110px" onchange="this.form.submit()">
                                            @foreach(['pledged','collected','in_transit','delivered','distributed'] as $s)
                                            <option value="{{ $s }}" {{ $donation->status === $s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No donations found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">{{ $donations->withQueryString()->links() }}</div>
</div>
@endsection
