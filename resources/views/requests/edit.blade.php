@extends('layouts.app')
@section('title', 'Edit Relief Request')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('requests.show', $reliefRequest) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                <h2 class="fw-bold mb-0">✏️ Edit Relief Request</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('requests.update', $reliefRequest) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $reliefRequest->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    @foreach(['food'=>'🍲 Food','water'=>'💧 Water','medicine'=>'💊 Medicine','shelter'=>'🏠 Shelter','clothing'=>'👕 Clothing','rescue'=>'🚁 Rescue','medical_assistance'=>'🏥 Medical Assistance','psychological_support'=>'🧠 Psychological Support','baby_supplies'=>'👶 Baby Supplies','elderly_care'=>'👴 Elderly Care','disability_assistance'=>'♿ Disability Assistance','other'=>'📦 Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('type', $reliefRequest->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Urgency <span class="text-danger">*</span></label>
                                <select name="urgency" class="form-select" required>
                                    @foreach(['low'=>'🟢 Low','medium'=>'🟡 Medium','high'=>'🟠 High','critical'=>'🔴 Critical'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('urgency', $reliefRequest->urgency) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(auth()->user()->isAdmin() || auth()->user()->isOrganization())
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    @foreach(['pending','acknowledged','in_progress','fulfilled','closed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $reliefRequest->status) === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <input type="hidden" name="status" value="{{ $reliefRequest->status }}">
                            @endif
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Number of People <span class="text-danger">*</span></label>
                                <input type="number" name="people_count" class="form-control @error('people_count') is-invalid @enderror"
                                       value="{{ old('people_count', $reliefRequest->people_count) }}" min="1" required>
                                @error('people_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror"
                                       value="{{ old('location_name', $reliefRequest->location_name) }}" required>
                                @error('location_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $reliefRequest->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Special Notes</label>
                                <textarea name="special_notes" rows="2" class="form-control">{{ old('special_notes', $reliefRequest->special_notes) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Needed By</label>
                                <input type="datetime-local" name="needed_by" class="form-control"
                                       value="{{ old('needed_by', $reliefRequest->needed_by?->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold px-5">Save Changes</button>
                            <a href="{{ route('requests.show', $reliefRequest) }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
