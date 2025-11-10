<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $organizations = User::where('role', 'Organization')->get();
        $youth = User::where('role', 'Youth')->get();
        return view('admin.dashboard', compact('organizations', 'youth'));
    }

    // Verify an organization
    public function verifyOrg($id)
    {
        $organization = User::findOrFail($id);
        
        // Ensure it's actually an organization
        if ($organization->role !== 'Organization') {
            return redirect()->back()->with('error', 'Only organizations can be verified.');
        }
        
        $organization->verified = true;
        $organization->save();

        return redirect()->back()->with('success', 'Organization verified successfully!');
    }

    // Revoke verification
    public function revokeOrg($id)
    {
        $organization = User::findOrFail($id);
        
        // Ensure it's actually an organization
        if ($organization->role !== 'Organization') {
            return redirect()->back()->with('error', 'Only organizations can have verification revoked.');
        }
        
        $organization->verified = false;
        $organization->save();

        return redirect()->back()->with('success', 'Verification revoked.');
    }
}
