@extends('layouts.app')
@section('title', 'Edit Incident')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('incidents.show', $incident) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                <h2 class="fw-bold mb-0">✏️ Edit Incident</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('incidents.update', $incident) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Incident Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $incident->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Disaster Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    @foreach(['flood'=>'🌊 Flood','earthquake'=>'🏚️ Earthquake','cyclone'=>'🌀 Cyclone','fire'=>'🔥 Fire','landslide'=>'⛰️ Landslide','drought'=>'☀️ Drought','tsunami'=>'🌊 Tsunami','industrial_accident'=>'🏭 Industrial Accident','disease_outbreak'=>'🦠 Disease Outbreak','other'=>'⚠️ Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('type', $incident->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Severity Level <span class="text-danger">*</span></label>
                                <select name="severity" class="form-select @error('severity') is-invalid @enderror" required>
                                    <option value="low"      {{ old('severity', $incident->severity) === 'low'      ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium"   {{ old('severity', $incident->severity) === 'medium'   ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high"     {{ old('severity', $incident->severity) === 'high'     ? 'selected' : '' }}>🟠 High</option>
                                    <option value="critical" {{ old('severity', $incident->severity) === 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                                </select>
                                @error('severity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @if(auth()->user()->isAdmin())
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    @foreach(['reported','verified','active','contained','resolved','closed'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $incident->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $incident->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Location Name <span class="text-danger">*</span></label>
                                <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror"
                                       value="{{ old('location_name', $incident->location_name) }}" required>
                                @error('location_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">People Affected</label>
                                <input type="number" name="affected_people" class="form-control" value="{{ old('affected_people', $incident->affected_people) }}" min="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Casualties</label>
                                <input type="number" name="casualties" class="form-control" value="{{ old('casualties', $incident->casualties) }}" min="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Missing Persons</label>
                                <input type="number" name="missing_persons" class="form-control" value="{{ old('missing_persons', $incident->missing_persons) }}" min="0">
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-danger btn-lg fw-bold px-5">Save Changes</button>
                            <a href="{{ route('incidents.show', $incident) }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
