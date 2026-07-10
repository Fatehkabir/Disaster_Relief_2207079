<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Incident;
use App\Models\ReliefRequest;
use App\Models\User;
use App\Models\VolunteerTask;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'active_incidents'  => Incident::active()->count(),
            'pending_requests'  => ReliefRequest::pending()->count(),
            'total_volunteers'  => User::where('role', 'volunteer')->where('is_active', true)->count(),
            'total_donations'   => Donation::where('status', '!=', 'pledged')->count(),
        ];

        $roleData = match ($user->role) {
            'admin'     => $this->adminData(),
            'victim'    => $this->victimData($user),
            'volunteer' => $this->volunteerData($user),
            default     => [],
        };

        $recentIncidents = Incident::active()->with('reporter')->latest()->take(5)->get();

        $lastViewedIncident = null;
        if (session()->has('last_viewed_incident')) {
            $lastViewedIncident = Incident::find(session('last_viewed_incident'));
        }

        return view('dashboard.index', compact('user', 'stats', 'roleData', 'recentIncidents', 'lastViewedIncident'));
    }

    private function adminData(): array
    {
        return [
            'pending_incidents'  => Incident::pending()->count(),
            'pending_requests'   => ReliefRequest::pending()->count(),
            'pending_donations'  => Donation::where('status', 'pledged')->count(),
            'total_users'        => User::count(),
            'recent_requests'    => ReliefRequest::with('user')->latest()->take(5)->get(),
            'recent_donations'   => Donation::with('donor')->latest()->take(5)->get(),
        ];
    }

    private function victimData(User $user): array
    {
        return [
            'my_requests'     => $user->reliefRequests()->with('incident')->latest()->take(5)->get(),
            'my_donations'    => $user->donations()->with('incident')->latest()->take(5)->get(),
            'total_requests'  => $user->reliefRequests()->count(),
            'total_donations' => $user->donations()->count(),
            'pending_count'   => $user->reliefRequests()->pending()->count(),
        ];
    }

    private function volunteerData(User $user): array
    {
        return [
            'my_tasks'        => $user->volunteerTasks()->with('incident')->latest()->take(5)->get(),
            'available_tasks' => VolunteerTask::where('status', 'open')->with('incident')->latest()->take(5)->get(),
            'applied_count'   => $user->volunteerTasks()->count(),
        ];
    }
}
