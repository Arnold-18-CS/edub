<?php

namespace App\Http\Controllers;

use App\Models\YouthProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YouthProfileController extends Controller
{
    /**
     * Show the logged-in youth’s profile.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'Youth') {
            abort(403, 'Unauthorized access');
        }

        // Get or create a blank profile for this user
        $profile = YouthProfile::firstOrCreate(['user_id' => $user->id]);

        return view('youth.profile', compact('user', 'profile'));
    }

    /**
     * Show form to edit profile.
     */
    public function edit()
    {
        $user = Auth::user();

        if ($user->role !== 'Youth') {
            abort(403, 'Unauthorized access');
        }

        $profile = YouthProfile::firstOrCreate(['user_id' => $user->id]);

        return view('youth.edit-profile', compact('user', 'profile'));
    }

    /**
     * Update the youth’s profile info.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'Youth') {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'education_level' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'skills' => 'nullable|string',
            'availability' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
        ]);

        $profile = YouthProfile::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('youth.profile')->with('success', 'Profile updated successfully!');
    }
}
