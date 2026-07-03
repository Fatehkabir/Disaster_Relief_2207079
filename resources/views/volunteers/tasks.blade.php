@extends('layouts.app')
@section('title', 'Volunteer Tasks')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>🤝 Volunteer Tasks</h1>
            <p>Help local communities by applying for tasks</p>
        </div>
        <a href="{{ route('volunteers.my-tasks') }}" class="btn btn-outline-success">
            <i class="bi bi-clipboard-check me-1"></i>My Applied Tasks
        </a>
    </div>
</div>

<div class="container">
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-4">
            <select name="category" class="form-select form-select-sm">
                <option value="">All Categories</option>
                <option value="search_rescue" {{ request('category') === 'search_rescue' ? 'selected' : '' }}>🔍 Search & Rescue</option>
                <option value="medical_aid" {{ request('category') === 'medical_aid' ? 'selected' : '' }}>🏥 Medical Aid</option>
                <option value="food_distribution" {{ request('category') === 'food_distribution' ? 'selected' : '' }}>🍲 Food Distribution</option>
                <option value="shelter_setup" {{ request('category') === 'shelter_setup' ? 'selected' : '' }}>🏕️ Shelter Setup</option>
                <option value="logistics" {{ request('category') === 'logistics' ? 'selected' : '' }}>🚛 Logistics</option>
                <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>🤝 Other</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="open" {{ request('status', 'open') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-success btn-sm w-100">Filter</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse($tasks as $task)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">{{ $task->category_label }}</span>
                    {!! $task->status_badge !!}
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold" style="font-size:1.05rem">{{ $task->title }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($task->description, 100) }}</p>
                    <div class="small mb-3">
                        <div>📍 <strong>Location:</strong> {{ $task->location_name ?? $task->incident->location_name }}</div>
                        <div class="mt-1">👥 <strong>Assigned:</strong> {{ $task->volunteers_assigned }} / {{ $task->volunteers_needed }}</div>
                    </div>
                    <a href="{{ route('volunteers.task', $task) }}" class="btn btn-sm btn-success w-100">View Details & Apply</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state card">
                <i class="bi bi-check-all text-success"></i>
                <div>No volunteer tasks found matching your filters.</div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $tasks->withQueryString()->links() }}
    </div>
</div>
@endsection
