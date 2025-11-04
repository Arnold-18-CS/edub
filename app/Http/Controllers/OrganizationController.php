<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;
use App\Models\Application;

class OrganizationController extends Controller
{
    /**
     * Show the organization's dashboard with their posted opportunities.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'Organization') {
            abort(403, 'Unauthorized');
        }

        $opportunities = Opportunity::where('organization_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->get();

        return view('organization.dashboard', compact('opportunities'));
    }

    /**
     * Show all applicants for a specific opportunity.
     */
    public function viewApplicants($id)
    {
        $user = Auth::user();

        if ($user->role !== 'Organization') {
            abort(403, 'Unauthorized');
        }

        $opportunity = Opportunity::where('organization_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $applications = Application::with('user')
            ->where('opportunity_id', $opportunity->id)
            ->get();

        return view('organization.applicants', compact('opportunity', 'applications'));
    }

    /**
     * Update an application status (e.g., Accept, Reject).
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Accepted,Rejected',
        ]);

        $application = Application::findOrFail($id);

        $opportunity = $application->opportunity;

        if ($opportunity->organization_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Application status updated.');
    }
}
