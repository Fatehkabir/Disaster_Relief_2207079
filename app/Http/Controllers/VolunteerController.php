<?php

namespace App\Http\Controllers;

use App\Models\VolunteerTask;
use App\Models\VolunteerTaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function tasks(Request $request)
    {
        $query = VolunteerTask::with('incident', 'creator');

        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('status'))   $query->where('status', $request->status);
        else                              $query->where('status', 'open');

        $tasks = $query->latest()->paginate(12);
        return view('volunteers.tasks', compact('tasks'));
    }

    public function showTask(VolunteerTask $task)
    {
        $task->load(['incident', 'creator', 'volunteers']);
        $isAssigned = Auth::check() && $task->volunteers->contains(Auth::id());
        return view('volunteers.show-task', compact('task', 'isAssigned'));
    }

    public function applyTask(VolunteerTask $task)
    {
        if (!Auth::user()->isVolunteer()) {
            return back()->with('error', 'Only volunteers can apply for tasks.');
        }
        if ($task->isFull()) {
            return back()->with('error', 'This task is already full.');
        }
        if (VolunteerTaskAssignment::where('volunteer_task_id', $task->id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already applied for this task.');
        }

        VolunteerTaskAssignment::create([
            'volunteer_task_id' => $task->id,
            'user_id'           => Auth::id(),
            'status'            => 'assigned',
        ]);
        $task->increment('volunteers_assigned');

        return back()->with('success', 'You have successfully applied! The coordinator will contact you.');
    }

    public function withdrawTask(VolunteerTask $task)
    {
        $assignment = VolunteerTaskAssignment::where('volunteer_task_id', $task->id)
                                             ->where('user_id', Auth::id())
                                             ->firstOrFail();
        $assignment->delete();
        $task->decrement('volunteers_assigned');

        return back()->with('success', 'You have withdrawn from this task.');
    }

    public function myTasks()
    {
        $assignments = VolunteerTaskAssignment::where('user_id', Auth::id())
                                              ->with('task.incident')
                                              ->latest()
                                              ->paginate(10);
        return view('volunteers.my-tasks', compact('assignments'));
    }
}
