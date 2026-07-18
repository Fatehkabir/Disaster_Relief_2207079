@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>
            @if(auth()->user()->isAdmin()) 🛡️ Admin Dashboard
            @elseif(auth()->user()->isVictim()) 🙋 My Dashboard
            @else 🤝 Volunteer Dashboard
            @endif
        </h1>
        <p>Welcome back, <strong>{{ auth()->user()->name }}</strong></p>
    </div>
</div>

<div class="container">
    {{-- Global Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-danger">{{ $stats['active_incidents'] }}</div>
                <div class="stat-label">Active Incidents</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-warning">{{ $stats['pending_requests'] }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-success">{{ $stats['total_volunteers'] }}</div>
                <div class="stat-label">Volunteers</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="stat-value text-primary">{{ $stats['total_donations'] }}</div>
                <div class="stat-label">Donations Made</div>
            </div>
        </div>
    </div>

    {{-- ADMIN PANEL STATS --}}
    @if(auth()->user()->isAdmin())
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.incidents') }}?status=pending" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #f59e0b">
                    <div class="stat-value text-warning">{{ $roleData['pending_incidents'] }}</div>
                    <div class="stat-label">Pending Incidents</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.requests') }}?status=pending" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #ef4444">
                    <div class="stat-value text-danger">{{ $roleData['pending_requests'] }}</div>
                    <div class="stat-label">Pending Requests</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.donations') }}?status=pledged" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                    <div class="stat-value text-primary">{{ $roleData['pending_donations'] }}</div>
                    <div class="stat-label">Pledged Donations</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="stat-card text-center" style="border-left:4px solid #8b5cf6">
                    <div class="stat-value" style="color:#8b5cf6">{{ $roleData['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </a>
        </div>
    </div>

    {{-- VICTIM PANEL STATS --}}
    @elseif(auth()->user()->isVictim())
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                <div class="stat-value text-primary">{{ $roleData['total_requests'] }}</div>
                <div class="stat-label">My Requests</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #f59e0b">
                <div class="stat-value text-warning">{{ $roleData['pending_count'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center" style="border-left:4px solid #10b981">
                <div class="stat-value text-success">{{ $roleData['total_donations'] }}</div>
                <div class="stat-label">My Donations</div>
            </div>
        </div>
    </div>

    {{-- VOLUNTEER PANEL STATS --}}
    @else
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-card text-center" style="border-left:4px solid #10b981">
                <div class="stat-value text-success">{{ $roleData['applied_count'] }}</div>
                <div class="stat-label">Tasks Applied</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat-card text-center" style="border-left:4px solid #3b82f6">
                <div class="stat-value text-primary">{{ $roleData['available_tasks']->count() }}</div>
                <div class="stat-label">Open Tasks</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
