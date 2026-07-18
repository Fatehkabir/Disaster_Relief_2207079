<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::with('reporter')->latest();

        if ($request->filled('type'))     $query->where('type', $request->type);
        if ($request->filled('severity')) $query->where('severity', $request->severity);
        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('search'))   $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('location_name', 'like', '%' . $request->search . '%');
        });

        $incidents = $query->paginate(12);
        return view('incidents.index', compact('incidents'));
    }

    public function create(Request $request)
    {
        $preferredLocation = $request->cookie('preferred_location');
        return view('incidents.create', compact('preferredLocation'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string|min:10',
            'type'            => 'required|in:flood,earthquake,cyclone,fire,landslide,drought,other',
            'severity'        => 'required|in:low,medium,high,critical',
            'location_name'   => 'required|string|max:255',
            'affected_people' => 'nullable|integer|min:0',
            'needs_volunteers'=> 'boolean',
            'needs_donations' => 'boolean',
        ]);

        $incident = Incident::create([
            ...$validated,
            'reported_by'     => Auth::id(),
            'status'          => 'pending',
            'needs_volunteers'=> $request->boolean('needs_volunteers'),
            'needs_donations' => $request->boolean('needs_donations'),
        ])->fresh();

        return redirect()->route('incidents.show', $incident)
                         ->with('success', 'Incident reported successfully! An admin will verify it shortly.')
                         ->withCookie(cookie('preferred_location', $validated['location_name'], 60*24*30));
    }

    public function show(Incident $incident, WeatherService $weather)
    {
        $incident->load(['reporter', 'volunteerTasks', 'reliefRequests.user', 'donations.donor']);
        session(['last_viewed_incident' => $incident->id]);
        $weather = $weather->getWeatherForCity($incident->location_name);
        return view('incidents.show', compact('incident', 'weather'));
    }
}
