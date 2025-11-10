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

        // Get organization for this user
        $organization = \App\Models\Organization::where('user_id', $user->id)->first();
        
        if (!$organization) {
            $opportunities = collect([]);
        } else {
            $opportunities = Opportunity::where('organization_id', $organization->id)
                ->latest()
                ->get();
        }

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

        // Get or create organization record for this user
        $organization = \App\Models\Organization::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'contact_email' => $user->email]
        );

        Opportunity::create([
            'organization_id' => $organization->id,
            'title'           => $validated['title'],
            'description'     => $validated['description'],
            'deadline'        => $validated['deadline'],
            'available_slots' => $validated['seats'],
        ]);

        return redirect()->back()->with('success', 'Opportunity created successfully!');
    }

    // Youth view: list all verified opportunities
    public function list()
    {
        // Get opportunities from verified organizations
        $opportunities = Opportunity::with(['organization', 'organization.user'])
            ->whereHas('organization', function ($q) {
                $q->where('verified', true);
            })
            ->latest()
            ->get();

        return view('youth.opportunities', compact('opportunities'));
    }

    // View single opportunity
    public function show($id)
    {
        $opportunity = Opportunity::with(['organization', 'organization.user'])->findOrFail($id);
        return view('show', compact('opportunity'));
    }
}
