@extends('layouts.app')
@section('title', 'Volunteer Directory')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-0">Volunteer Directory</h2>
            <p class="section-subtitle mb-0">{{ $volunteers->total() }} registered volunteers</p>
        </div>
    </div>
    <div class="row g-4">
        @forelse($volunteers as $vol)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center p-3">
                <img src="{{ $vol->profile_photo_url }}" class="rounded-circle mx-auto mb-3" width="72" height="72" alt="">
                <h6 class="fw-bold mb-0">{{ $vol->name }}</h6>
                <p class="text-muted small mb-2">{{ $vol->city ?? 'Location not set' }}</p>
                @if($vol->skills)
                <div class="d-flex flex-wrap justify-content-center gap-1 mb-2">
                    @foreach($vol->skills_array as $skill)
                    <span class="badge bg-light text-dark" style="font-size:.7rem">{{ $skill }}</span>
                    @endforeach
                </div>
                @endif
                @if($vol->availability)
                <p class="text-muted small mb-2"><i class="bi bi-clock me-1"></i>{{ $vol->availability }}</p>
                @endif
                @if($vol->is_verified)
                <span class="badge bg-success"><i class="bi bi-patch-check"></i> Verified</span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem">🙌</div>
            <h5 class="mt-3">No volunteers found</h5>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $volunteers->withQueryString()->links() }}</div>
</div>
@endsection
