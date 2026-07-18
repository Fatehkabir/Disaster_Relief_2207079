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
