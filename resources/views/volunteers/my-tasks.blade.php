@extends('layouts.app')
@section('title', 'My Tasks')
@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1>📋 My Volunteer Tasks</h1>
            <p>Volunteer tasks you have applied for</p>
        </div>
        <a href="{{ route('volunteers.tasks') }}" class="btn btn-success">
            <i class="bi bi-search me-1"></i>Browse Open Tasks
        </a>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Task Title</th>
                            <th>Category</th>
                            <th>Incident</th>
                            <th>Location</th>
                            <th>Task Status</th>
                            <th class="pe-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assign)
                        @php $task = $assign->task; @endphp
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('volunteers.task', $task) }}" class="fw-600 text-dark text-decoration-none">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td>{{ $task->category_label }}</td>
                            <td>
                                <a href="{{ route('incidents.show', $task->incident) }}" class="text-decoration-none">
                                    {{ Str::limit($task->incident->title, 40) }}
                                </a>
                            </td>
                            <td>📍 {{ $task->location_name ?? $task->incident->location_name }}</td>
                            <td>{!! $task->status_badge !!}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('volunteers.task', $task) }}" class="btn btn-sm btn-outline-primary">View details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state py-2">
                                    <i class="bi bi-clipboard text-muted"></i>
                                    <div>You have not applied for any volunteer tasks yet.</div>
                                    <a href="{{ route('volunteers.tasks') }}" class="btn btn-sm btn-success mt-2">Find Tasks to Help</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
