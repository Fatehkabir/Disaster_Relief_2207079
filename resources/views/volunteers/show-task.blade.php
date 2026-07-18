@extends('layouts.app')
@section('title', $task->title)
@section('content')
<div class="page-header">
    <div class="container">
        <a href="{{ route('volunteers.tasks') }}" class="text-muted text-decoration-none" style="font-size:.85rem">← Back to Volunteer Tasks</a>
        <h1 class="mt-1">{{ $task->title }}</h1>
        <div class="d-flex gap-2 flex-wrap mt-1">
            {!! $task->status_badge !!}
            <span class="badge bg-light text-dark">{{ $task->category_label }}</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">📄 Task Details</div>
                <div class="card-body">
                    <p class="lead" style="font-size:1.05rem; white-space: pre-line;">{{ $task->description }}</p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Location</div>
                            <div>📍 {{ $task->location_name ?? $task->incident->location_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Volunteers Needed</div>
                            <div>👥 {{ $task->volunteers_assigned }} Assigned / {{ $task->volunteers_needed }} Needed</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Created By</div>
                            <div>👤 {{ $task->creator->name ?? 'Deleted User' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small fw-bold uppercase">Linked Incident</div>
                            <div>
                                🔗 <a href="{{ route('incidents.show', $task->incident) }}">{{ $task->incident->title }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">⚡ Application Action</div>
                <div class="card-body text-center py-4">
                    @if(auth()->user()->isVolunteer())
                        @if($isAssigned)
                            <div class="alert alert-success mb-3 small">
                                <i class="bi bi-check-circle-fill me-1"></i>You are assigned to this task.
                            </div>
                            <form action="{{ route('volunteers.withdraw', $task) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle me-1"></i>Withdraw Application
                                </button>
                            </form>
                        @else
                            @if($task->isFull())
                                <div class="alert alert-warning mb-0 small">
                                    This task has reached its volunteer limit.
                                </div>
                            @elseif($task->status !== 'open')
                                <div class="alert alert-secondary mb-0 small">
                                    This task is no longer accepting volunteers.
                                </div>
                            @else
                                <form action="{{ route('volunteers.apply', $task) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        <i class="bi bi-hand-index-thumb me-1"></i>Apply for this Task
                                    </button>
                                </form>
                            @endif
                        @endif
                    @else
                        <div class="alert alert-info mb-0 small">
                            Only volunteer accounts can apply for tasks.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">👥 Volunteers Assigned ({{ $task->volunteers->count() }})</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($task->volunteers as $vol)
                        <li class="list-group-item d-flex align-items-center py-2 px-3">
                            <span class="fw-bold me-2">{{ $vol->name }}</span>
                            <span class="text-muted small">({{ $vol->phone ?? 'No Phone' }})</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-3">No volunteers assigned yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
