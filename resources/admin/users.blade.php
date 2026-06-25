@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>User Management</h2>
            <p class="text-muted mb-0">{{ $users->total() }} total users registered</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
    </div>


    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Search name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach(['victim','volunteer','donor','organization','admin'] as $r)
                        <option value="{{ $r }}" {{ request('role') === $r ? 'selected':'' }}>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">✕</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Verified</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $user->profile_photo_url }}" class="rounded-circle" width="36" height="36" alt="">
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                        @if($user->organization_name)
                                        <div class="text-muted small">{{ $user->organization_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{!! $user->role_badge !!}</td>
                            <td class="text-muted small">{{ $user->city ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                @if($user->is_verified)
                                    <span class="badge bg-success"><i class="bi bi-patch-check"></i> Verified</span>
                                @elseif(in_array($user->role, ['volunteer','organization']))
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if(!$user->is_verified && in_array($user->role, ['volunteer','organization']))
                                    <form action="{{ route('admin.users.verify', $user) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-success btn-sm" title="Verify"><i class="bi bi-patch-check"></i></button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} btn-sm"
                                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi {{ $user->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection
