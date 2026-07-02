@extends('layouts.app')
@section('title', 'Manage Tasks')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>🤝 Manage Volunteer Tasks</h1>
            <p>Create and update volunteer tasks for verified disasters</p>
        </div>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>Create Task
        </a>
    </div>
</div>

<div class="container">
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-9">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success btn-sm w-100">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Task Details</th>
                            <th>Incident</th>
                            <th>Volunteers</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('volunteers.task', $task) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $task->title }}
                                </a>
                                <div class="text-muted small">{{ $task->category_label }} · 📍 {{ $task->location_name ?? 'See Incident' }}</div>
                            </td>
                            <td>
                                <a href="{{ route('incidents.show', $task->incident) }}" class="small">
                                    {{ Str::limit($task->incident->title, 40) }}
                                </a>
                            </td>
                            <td>👥 {{ $task->volunteers_assigned }} / {{ $task->volunteers_needed }}</td>
                            <td>{!! $task->status_badge !!}</td>
                            <td>
                                <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="open" {{ $task->status === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('volunteers.task', $task) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No volunteer tasks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $tasks->links() }}
    </div>
</div>
@endsection
