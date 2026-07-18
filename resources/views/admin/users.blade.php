@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>👥 Manage Users</h1>
        <p>Activate or deactivate user accounts</p>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>{!! $user->role_badge !!}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Deactivated</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="pe-3 text-end">
                                @if(!$user->isAdmin())
                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->is_active)
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Deactivate</button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success text-white">Activate</button>
                                        @endif
                                    </form>
                                @else
                                    <span class="text-muted small">Cannot edit admin</span>
                                @endif
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
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
