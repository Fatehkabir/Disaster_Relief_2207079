@extends('layouts.app')
@section('title', 'Create Volunteer Task')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>🤝 Create Volunteer Task</h1>
        <p>Publish a mobilization request for verified active incidents</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Information</div>
                <div class="card-body">
                    <form action="{{ route('admin.tasks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Task Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Distribution of relief materials at Main Camp" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Linked Incident *</label>
                                <select name="incident_id" class="form-select" required>
                                    <option value="">Select verified incident...</option>
                                    @foreach($incidents as $id => $title)
                                    <option value="{{ $id }}" {{ old('incident_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Task Category *</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select category...</option>
                                    <option value="search_rescue" {{ old('category') === 'search_rescue' ? 'selected' : '' }}>🔍 Search & Rescue</option>
                                    <option value="medical_aid" {{ old('category') === 'medical_aid' ? 'selected' : '' }}>🏥 Medical Aid</option>
                                    <option value="food_distribution" {{ old('category') === 'food_distribution' ? 'selected' : '' }}>🍲 Food Distribution</option>
                                    <option value="shelter_setup" {{ old('category') === 'shelter_setup' ? 'selected' : '' }}>🏕️ Shelter Setup</option>
                                    <option value="logistics" {{ old('category') === 'logistics' ? 'selected' : '' }}>🚛 Logistics</option>
                                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>🤝 Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Location (Optional, defaults to Incident location)</label>
                                <input type="text" name="location_name" class="form-control" value="{{ old('location_name') }}" placeholder="e.g. Sylhet Sadar College Camp">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Volunteers Needed *</label>
                                <input type="number" name="volunteers_needed" class="form-control" value="{{ old('volunteers_needed', 5) }}" min="1" max="500" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Task Description *</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Mention work details, duration, requirements, who to contact, etc..." required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 10 characters</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success text-white">
                                <i class="bi bi-plus-circle me-1"></i>Publish Task
                            </button>
                            <a href="{{ route('admin.tasks') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
