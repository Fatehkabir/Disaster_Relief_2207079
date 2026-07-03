@extends('layouts.app')
@section('title', 'Create Volunteer Task')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('volunteers.tasks') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                <h2 class="fw-bold mb-0">🦺 Create Volunteer Task</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('volunteers.store-task') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" placeholder="e.g. Food distribution at Sylhet shelter" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Related Incident <span class="text-danger">*</span></label>
                                <select name="incident_id" class="form-select @error('incident_id') is-invalid @enderror" required>
                                    <option value="">Select incident...</option>
                                    @foreach($incidents as $id => $title)
                                    <option value="{{ $id }}" {{ old('incident_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('incident_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="">Select category...</option>
                                    @foreach(['search_rescue'=>'🔍 Search & Rescue','medical_aid'=>'🏥 Medical Aid','food_distribution'=>'🍲 Food Distribution','shelter_setup'=>'🏠 Shelter Setup','logistics'=>'🚛 Logistics','communication'=>'📡 Communication','psychological_support'=>'🧠 Psychological Support','data_collection'=>'📊 Data Collection','other'=>'📋 Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select" required>
                                    <option value="low">🟢 Low</option>
                                    <option value="medium" selected>🟡 Medium</option>
                                    <option value="high">🟠 High</option>
                                    <option value="critical">🔴 Critical</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Volunteers Needed <span class="text-danger">*</span></label>
                                <input type="number" name="volunteers_needed" class="form-control" value="{{ old('volunteers_needed', 5) }}" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Describe the task in detail: what needs to be done, tools needed, experience required..." required>{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Required Skills</label>
                                <input type="text" name="required_skills" class="form-control" value="{{ old('required_skills') }}" placeholder="e.g. First Aid, Driving">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" name="location_name" class="form-control" value="{{ old('location_name') }}" placeholder="Where will this task take place?">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Time</label>
                                <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">End Time</label>
                                <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') }}">
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-lg fw-bold px-5">Create Task</button>
                            <a href="{{ route('volunteers.tasks') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
