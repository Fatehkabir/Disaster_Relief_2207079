@extends('layouts.app')
@section('title', 'Pledge Donation')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>📦 Pledge a Donation</h1>
        <p>Your support makes a big difference to disaster-affected victims.</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Donation Details</div>
                <div class="card-body">
                    <form action="{{ route('donations.store') }}" method="POST">
                        @csrf

                        @if(request('incident_id'))
                            <input type="hidden" name="incident_id" value="{{ request('incident_id') }}">
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Donation Item/Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. 50 Packs of Dry Biscuits and Water Bottels" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select category...</option>
                                    @foreach(['food'=>'🍲 Food','water'=>'💧 Water','medicine'=>'💊 Medicine','clothing'=>'👕 Clothing','shelter_materials'=>'🏠 Shelter Materials','hygiene'=>'🧼 Hygiene','other'=>'📦 Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label">Quantity *</label>
                                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Unit *</label>
                                        <input type="text" name="unit" class="form-control" value="{{ old('unit', 'pieces') }}" placeholder="e.g. kg, boxes, pcs" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup/Drop-off Location *</label>
                            <input type="text" name="pickup_location" class="form-control" value="{{ old('pickup_location') }}" placeholder="Your address or preferred location to hand over relief items" required>
                        </div>

                        @if(!request('incident_id') && count($incidents) > 0)
                        <div class="mb-3">
                            <label class="form-label">Support a Specific Incident (Optional)</label>
                            <select name="incident_id" class="form-select">
                                <option value="">General Relief (not linked to specific incident)</option>
                                @foreach($incidents as $id => $title)
                                <option value="{{ $id }}" {{ old('incident_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Additional Description *</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Mention item conditions, packing info, or any instructions..." required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 5 characters</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-gift me-2"></i>Pledge Donation
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
