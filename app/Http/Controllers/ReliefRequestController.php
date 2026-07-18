<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\ReliefRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReliefRequestController extends Controller
{
    public function create(Request $request)
    {
        $incidents = Incident::active()->pluck('title', 'id');
        return view('requests.create', compact('incidents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|min:10',
            'type'          => 'required|in:food,water,medicine,shelter,clothing,rescue,other',
            'urgency'       => 'required|in:low,medium,high,critical',
            'people_count'  => 'required|integer|min:1|max:10000',
            'location_name' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'incident_id'   => 'nullable|exists:incidents,id',
        ]);

        $reliefRequest = ReliefRequest::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status'  => 'pending',
        ])->fresh();

        return redirect()->route('requests.show', $reliefRequest)
                         ->with('success', 'Relief request submitted! We will contact you as soon as possible.');
    }

    public function show(ReliefRequest $reliefRequest)
    {
        $reliefRequest->load(['user', 'incident']);
        return view('requests.show', compact('reliefRequest'));
    }

    public function myRequests()
    {
        $requests = Auth::user()->reliefRequests()->with('incident')->latest()->paginate(10);
        return view('requests.my-requests', compact('requests'));
    }
}
