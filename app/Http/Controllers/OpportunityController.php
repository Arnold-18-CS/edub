<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    // Organization view: all opportunities created by them
    public function index()
    {
        $user = Auth::user();

        // Defensive check — only organizations should be here
        if ($user->role !== 'Organization') {
            abort(403, 'Unauthorized');
        }

        $opportunities = Opportunity::where('organization_id', $user->id)
            ->latest()
            ->get();

        return view('organization.dashboard', compact('opportunities'));
    }

    // Create opportunity (Organization only)
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'Organization') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'deadline'    => 'required|date',
            'seats'       => 'required|integer|min:1',
        ]);

        Opportunity::create([
            'organization_id' => $user->id,
            'title'           => $validated['title'],
            'description'     => $validated['description'],
            'deadline'        => $validated['deadline'],
            'seats'           => $validated['seats'],
        ]);

        return redirect()->back()->with('success', 'Opportunity created successfully!');
    }

    // Youth view: list all verified opportunities
    public function list()
    {
        $opportunities = Opportunity::with('organization')
            ->whereHas('organization', function ($q) {
                $q->where('verified', true); // Only show verified organizations
            })
            ->latest()
            ->get();

        return view('youth.opportunities', compact('opportunities'));
    }

    // View single opportunity
    public function show($id)
    {
        $opportunity = Opportunity::with('organization')->findOrFail($id);
        return view('opportunities.show', compact('opportunity'));
    }
}
