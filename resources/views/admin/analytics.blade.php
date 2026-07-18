@extends('layouts.app')
@section('title', 'Analytics')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-graph-up me-2 text-success"></i>Platform Analytics</h2>
            <p class="text-muted mb-0">Performance metrics and impact data</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
    </div>

    {{-- Key Metrics --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-center p-4" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7)">
                <div class="h2 fw-bold text-success mb-0">
                    {{ $responseTime ? round($responseTime, 1) . 'h' : 'N/A' }}
                </div>
                <div class="text-muted fw-semibold">Avg Response Time</div>
                <div class="text-muted small">From request submission to fulfilment</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-4" style="background:linear-gradient(135deg,#eff6ff,#dbeafe)">
                <div class="h2 fw-bold text-primary mb-0">{{ $topVolunteers->sum('completed_tasks') }}</div>
                <div class="text-muted fw-semibold">Total Tasks Completed</div>
                <div class="text-muted small">By all volunteers combined</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-4" style="background:linear-gradient(135deg,#fef9c3,#fef08a)">
                <div class="h2 fw-bold text-warning mb-0">{{ $requestsByDistrict->count() }}</div>
                <div class="text-muted fw-semibold">Districts Covered</div>
                <div class="text-muted small">Locations with relief requests</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Top Volunteers --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold"><i class="bi bi-trophy me-2 text-warning"></i>Top Volunteers</div>
                <div class="card-body p-0">
                    @forelse($topVolunteers as $i => $vol)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="fw-bold text-muted me-3" style="width:24px">{{ $i+1 }}</div>
                        <img src="{{ $vol->profile_photo_url }}" class="rounded-circle me-2" width="36" height="36" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $vol->name }}</div>
                            <div class="text-muted small">{{ $vol->city ?? 'Unknown location' }}</div>
                        </div>
                        <span class="badge bg-success rounded-pill">{{ $vol->completed_tasks }} tasks</span>
                    </div>
                    @empty
                    <p class="text-center py-4 text-muted">No data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Top Donors --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold"><i class="bi bi-trophy me-2 text-primary"></i>Top Donors</div>
                <div class="card-body p-0">
                    @forelse($topDonors as $i => $donor)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="fw-bold text-muted me-3" style="width:24px">{{ $i+1 }}</div>
                        <img src="{{ $donor->profile_photo_url }}" class="rounded-circle me-2" width="36" height="36" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $donor->name }}</div>
                            <div class="text-muted small">{{ $donor->city ?? 'Unknown location' }}</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $donor->donations_count }} donations</span>
                    </div>
                    @empty
                    <p class="text-center py-4 text-muted">No data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Requests by District --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-bold"><i class="bi bi-geo-alt me-2 text-danger"></i>Relief Requests by Location (Top 10)</div>
                <div class="card-body">
                    @foreach($requestsByDistrict as $district)
                    @php $pct = $requestsByDistrict->max('count') > 0 ? ($district->count / $requestsByDistrict->max('count') * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">{{ $district->location_name }}</span>
                            <span class="text-muted small">{{ $district->count }} requests</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
