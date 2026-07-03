@extends('layouts.app')
@section('title', 'Request Relief')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>🙋 Submit Relief Request</h1>
        <p>Request food, water, medicine, shelter, or rescue assistance.</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Request Details</div>
                <div class="card-body">
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf

                        @if(request('incident_id'))
                            <input type="hidden" name="incident_id" value="{{ request('incident_id') }}">
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Request Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Need Dry Food and Drinking Water for 5 People" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Relief Type *</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Select type...</option>
                                    @foreach(['food'=>'🍲 Food','water'=>'💧 Water','medicine'=>'💊 Medicine','shelter'=>'🏠 Shelter','clothing'=>'👕 Clothing','rescue'=>'🚑 Rescue','other'=>'📦 Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Urgency Level *</label>
                                <select name="urgency" class="form-select" required>
                                    <option value="">Select urgency...</option>
                                    <option value="low" {{ old('urgency') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium" {{ old('urgency') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high" {{ old('urgency') === 'high' ? 'selected' : '' }}>🟠 High</option>
                                    <option value="critical" {{ old('urgency') === 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Exact Location *</label>
                                <input type="text" name="location_name" class="form-control" value="{{ old('location_name') }}" placeholder="e.g. Ward 4, Sylhet Sadar" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. of People *</label>
                                <input type="number" name="people_count" class="form-control" value="{{ old('people_count', 1) }}" min="1" max="10000" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Phone Number</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', auth()->user()->phone) }}" placeholder="01XXXXXXXXX">
                        </div>

                        @if(!request('incident_id') && count($incidents) > 0)
                        <div class="mb-3">
                            <label class="form-label">Link to Incident (Optional)</label>
                            <select name="incident_id" class="form-select">
                                <option value="">Not linked to a specific incident</option>
                                @foreach($incidents as $id => $title)
                                <option value="{{ $id }}" {{ old('incident_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Describe Your Needs *</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Mention details about your situation, specific requirements, or directions to find you..." required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 10 characters</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="bi bi-hand-index me-2"></i>Submit Request
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
