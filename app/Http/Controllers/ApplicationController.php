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

        // Prevent duplicate application
        $exists = Application::where('opportunity_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You already applied for this opportunity.');
        }

        Application::create([
            'opportunity_id' => $id,
            'user_id' => $user->id,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    // Organization views applicants for their opportunities
    public function applicants()
    {
        $user = Auth::user();
        $applications = Application::with(['opportunity', 'user'])
            ->whereHas('opportunity', function ($q) use ($user) {
                $q->where('organization_id', $user->id);
            })
            ->get();

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
        $applications = Application::with('opportunity')->where('user_id', $user->id)->get();
        return view('youth.applications', compact('applications'));
    }
}
