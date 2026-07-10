<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('donor', 'incident')->latest();

        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('status'))   $query->where('status', $request->status);

        $donations = $query->paginate(15);
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        if (!Auth::user()->isVictim()) {
            return redirect()->route('donations.index')->with('error', 'Only victims can pledge donations.');
        }
        $incidents = Incident::active()->pluck('title', 'id');
        return view('donations.create', compact('incidents'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isVictim()) {
            return redirect()->route('donations.index')->with('error', 'Only victims can pledge donations.');
        }

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string|min:5',
            'category'        => 'required|in:food,water,medicine,clothing,shelter_materials,hygiene,other',
            'quantity'        => 'required|integer|min:1',
            'unit'            => 'required|string|max:50',
            'pickup_location' => 'nullable|string|max:255',
            'incident_id'     => 'nullable|exists:incidents,id',
        ]);

        $donation = Donation::create([
            ...$validated,
            'donor_id' => Auth::id(),
            'status'   => 'pledged',
        ])->fresh();

        return redirect()->route('donations.show', $donation)
                         ->with('success', 'Donation pledged successfully! Thank you for your generosity.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['donor', 'incident']);
        return view('donations.show', compact('donation'));
    }

    public function myDonations()
    {
        if (!Auth::user()->isVictim()) {
            return redirect()->route('dashboard')->with('error', 'This page is for victims only.');
        }
        $donations = Auth::user()->donations()->with('incident')->latest()->paginate(10);
        return view('donations.my-donations', compact('donations'));
    }
}
