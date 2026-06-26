@extends('layouts.app')
@section('title', 'Pledge Donation')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h2 class="fw-bold mb-0">📦 Pledge a Donation</h2>
                    <p class="text-muted mb-0">List items or supplies you can contribute to relief efforts</p>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Donation Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" placeholder="e.g. 50 kg rice and lentils" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="">Select category...</option>
                                    @foreach(['food'=>'🍲 Food','water'=>'💧 Water','medicine'=>'💊 Medicine','clothing'=>'👕 Clothing','shelter_materials'=>'🏠 Shelter Materials','hygiene'=>'🧼 Hygiene Products','baby_supplies'=>'👶 Baby Supplies','tools_equipment'=>'🔧 Tools & Equipment','furniture'=>'🛋️ Furniture','electronics'=>'📱 Electronics','other'=>'📦 Other'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('category') === $val ? 'selected':'' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}" min="1" required>
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
                                <select name="unit" class="form-select">
                                    @foreach(['pieces','kg','liters','boxes','bags','sets','bundles','packets'] as $u)
                                    <option value="{{ $u }}" {{ old('unit') === $u ? 'selected':'' }}>{{ ucfirst($u) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Condition</label>
                                <select name="condition" class="form-select">
                                    <option value="new">New</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="poor">Poor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Link to Incident (optional)</label>
                                <select name="incident_id" class="form-select">
                                    <option value="">General donation</option>
                                    @foreach($incidents as $id => $title)
                                    <option value="{{ $id }}" {{ old('incident_id') == $id ? 'selected':'' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Describe what you're donating..." required>{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Pickup Location</label>
                                <input type="text" name="pickup_location" class="form-control" value="{{ old('pickup_location') }}" placeholder="Where can this be collected?">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Available From</label>
                                <input type="datetime-local" name="available_from" class="form-control" value="{{ old('available_from') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expires / Unavailable After</label>
                                <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes" rows="2" class="form-control" placeholder="Any special handling instructions?">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Photos (optional)</label>
                                <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold px-5">Pledge Donation</button>
                            <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
