@extends('layouts.app')
@section('title', 'Report Incident')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>⚠️ Report an Incident</h1>
        <p>Submit a disaster report. An admin will verify it shortly.</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Incident Details</div>
                <div class="card-body">
                    <form action="{{ route('incidents.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Incident Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Major Flood in Sylhet District" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Disaster Type *</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Select type...</option>
                                    @foreach(['flood'=>'🌊 Flood','earthquake'=>'🏚️ Earthquake','cyclone'=>'🌀 Cyclone','fire'=>'🔥 Fire','landslide'=>'⛰️ Landslide','drought'=>'☀️ Drought','other'=>'⚠️ Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Severity *</label>
                                <select name="severity" class="form-select" required>
                                    <option value="">Select severity...</option>
                                    <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>🟠 High</option>
                                    <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Location *</label>
                                <input type="text" name="location_name" class="form-control" value="{{ old('location_name') }}" placeholder="e.g. Sylhet Sadar, Sylhet" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">People Affected</label>
                                <input type="number" name="affected_people" class="form-control" value="{{ old('affected_people', 0) }}" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Describe what happened, current conditions, and what kind of help is needed..." required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 10 characters</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Help Needed</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="needs_volunteers" value="1" id="needsVol" {{ old('needs_volunteers') ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="needsVol">🤝 Volunteers needed</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="needs_donations" value="1" id="needsDon" {{ old('needs_donations') ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="needsDon">📦 Donations needed</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>Submit Report
                            </button>
                            <a href="{{ route('incidents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
