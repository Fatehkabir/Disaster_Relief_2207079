@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>👤 My Profile Settings</h1>
        <p>View and update your personal information, contact info, and profile image</p>
    </div>
</div>

<div class="container">
    <div class="row">
        {{-- Profile card overview --}}
        <div class="col-md-4 mb-4">
            <div class="card text-center py-4">
                <div class="card-body">
                    <div class="mb-3 position-relative d-inline-block">
                        <img src="{{ $user->avatar_url }}" alt="Profile Photo" class="rounded-circle border img-thumbnail" style="width: 130px; height: 130px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 translate-middle-y">
                            {!! $user->role_badge !!}
                        </span>
                    </div>
                    <h4 class="fw-bold mt-2 mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    <div class="text-start bg-light rounded p-3 small">
                        <div class="mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</div>
                        <div class="mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'Not set' }}</div>
                        <div><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile settings form --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">🔧 Edit Profile Information</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 01XXXXXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Change Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control">
                                <div class="form-text">Choose an image file (JPEG, PNG, JPG, GIF) up to 2MB.</div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 1rem">🔒 Change Password (leave blank to keep current)</h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Save Changes
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
