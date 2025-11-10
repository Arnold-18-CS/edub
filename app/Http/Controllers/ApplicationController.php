<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Youth applies for an opportunity
    public function apply($id, Request $request)
    {
        $user = Auth::user();
        $opportunity = Opportunity::findOrFail($id);

        // Get or create youth profile
        $youthProfile = \App\Models\YouthProfile::firstOrCreate(['user_id' => $user->id]);

        // Prevent duplicate application
        $exists = Application::where('opportunity_id', $id)
            ->where('youth_profile_id', $youthProfile->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You already applied for this opportunity.');
        }

        Application::create([
            'opportunity_id' => $id,
            'youth_profile_id' => $youthProfile->id,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    // Organization views applicants for their opportunities
    public function applicants()
    {
        $user = Auth::user();
        $organization = \App\Models\Organization::where('user_id', $user->id)->first();
        
        if (!$organization) {
            $applications = collect([]);
        } else {
            $applications = Application::with(['opportunity', 'youthProfile.user'])
                ->whereHas('opportunity', function ($q) use ($organization) {
                    $q->where('organization_id', $organization->id);
                })
                ->get();
        }

        return view('organization.applicants', compact('applications'));
    }

    // Organization updates application status
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Application status updated!');
    }

    // Youth view: their applications
    public function myApplications()
    {
        $user = Auth::user();
        $youthProfile = \App\Models\YouthProfile::where('user_id', $user->id)->first();
        
        if (!$youthProfile) {
            $applications = collect([]);
        } else {
            $applications = Application::with(['opportunity', 'opportunity.organization', 'opportunity.organization.user'])
                ->where('youth_profile_id', $youthProfile->id)
                ->get();
        }
        
        return view('youth.applications', compact('applications'));
    }
}
