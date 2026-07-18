<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Incident;
use App\Models\ReliefRequest;
use App\Models\User;
use App\Models\VolunteerTask;
use Illuminate\Http\Request;
class AdminController extends Controller
{

    // ── Dashboard ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_users'       => User::count(),
            'victims'           => User::where('role', 'victim')->count(),
            'volunteers'        => User::where('role', 'volunteer')->count(),
            'total_incidents'   => Incident::count(),
            'pending_incidents' => Incident::pending()->count(),
            'active_incidents'  => Incident::active()->count(),
            'total_requests'    => ReliefRequest::count(),
            'pending_requests'  => ReliefRequest::pending()->count(),
            'fulfilled_requests'=> ReliefRequest::fulfilled()->count(),
            'total_donations'   => Donation::count(),
            'pending_donations' => Donation::where('status', 'pledged')->count(),
            'total_tasks'       => VolunteerTask::count(),
            'open_tasks'        => VolunteerTask::where('status', 'open')->count(),
        ];

        $pendingIncidents = Incident::pending()->with('reporter')->latest()->take(5)->get();
        $urgentRequests   = ReliefRequest::urgent()->pending()->with('user')->latest()->take(5)->get();
        $recentDonations  = Donation::with('donor')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingIncidents', 'urgentRequests', 'recentDonations'));
    }

    // ── Users ─────────────────────────────────────────────────────────────────
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('role'))   $query->where('role', $request->role);
        if ($request->filled('search')) $query->where('name', 'like', '%'.$request->search.'%')
                                              ->orWhere('email', 'like', '%'.$request->search.'%');
        $users = $query->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot toggle admin users.');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "{$user->name} has been {$status}.");
    }

    // ── Incidents ─────────────────────────────────────────────────────────────
    public function incidents(Request $request)
    {
        $query = Incident::with('reporter')->latest();
        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('severity')) $query->where('severity', $request->severity);
        $incidents = $query->paginate(20);
        return view('admin.incidents', compact('incidents'));
    }

    public function updateIncidentStatus(Request $request, Incident $incident)
    {
        $request->validate(['status' => 'required|in:pending,verified,active,resolved']);
        $incident->update(['status' => $request->status]);
        return back()->with('success', 'Incident status updated to: ' . ucfirst($request->status));
    }

    // ── Requests ──────────────────────────────────────────────────────────────
    public function requests(Request $request)
    {
        $query = ReliefRequest::with('user', 'incident')->latest();
        if ($request->filled('status'))  $query->where('status', $request->status);
        if ($request->filled('urgency')) $query->where('urgency', $request->urgency);
        $requests = $query->paginate(20);
        return view('admin.requests', compact('requests'));
    }

    public function updateRequestStatus(Request $request, ReliefRequest $reliefRequest)
    {
        $request->validate(['status' => 'required|in:pending,acknowledged,fulfilled,cancelled']);
        $reliefRequest->update(['status' => $request->status]);
        return back()->with('success', 'Request status updated to: ' . ucfirst($request->status));
    }

    // ── Donations ─────────────────────────────────────────────────────────────
    public function donations(Request $request)
    {
        $query = Donation::with('donor', 'incident')->latest();
        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('category')) $query->where('category', $request->category);
        $donations = $query->paginate(20);
        return view('admin.donations', compact('donations'));
    }

    public function updateDonationStatus(Request $request, Donation $donation)
    {
        $request->validate(['status' => 'required|in:pledged,collected,delivered']);
        $donation->update(['status' => $request->status]);
        return back()->with('success', 'Donation status updated to: ' . ucfirst($request->status));
    }

    // ── Volunteer Tasks ───────────────────────────────────────────────────────
    public function tasks(Request $request)
    {
        $query = VolunteerTask::with('incident', 'creator')->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        $tasks = $query->paginate(20);
        return view('admin.tasks', compact('tasks'));
    }

    public function createTask()
    {
        $incidents = Incident::active()->pluck('title', 'id');
        return view('admin.create-task', compact('incidents'));
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'incident_id'       => 'required|exists:incidents,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string|min:10',
            'category'          => 'required|in:search_rescue,medical_aid,food_distribution,shelter_setup,logistics,other',
            'volunteers_needed' => 'required|integer|min:1|max:500',
            'location_name'     => 'nullable|string|max:255',
        ]);

        VolunteerTask::create([
            ...$validated,
            'created_by' => auth()->id(),
            'status'     => 'open',
        ]);

        return redirect()->route('admin.tasks')->with('success', 'Volunteer task created successfully!');
    }

    public function updateTaskStatus(Request $request, VolunteerTask $task)
    {
        $request->validate(['status' => 'required|in:open,in_progress,completed']);
        $task->update(['status' => $request->status]);
        return back()->with('success', 'Task status updated to: ' . ucfirst(str_replace('_', ' ', $request->status)));
    }
}
