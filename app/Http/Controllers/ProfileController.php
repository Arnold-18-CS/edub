<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Load a different profile page based on role
        if ($user->role === 'Organization') {
            // Load organization relationship for organization profile
            $user->load('organization');
            return view('organization.profile', compact('user'));
        } elseif ($user->role === 'Youth') {
            return view('youth.profile', compact('user'));
        }

        // Default (Admin or other roles)
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Example: allow extra custom fields per role
        if ($user->role === 'Youth') {
            // Update youth profile instead of user record
            $youthProfile = \App\Models\YouthProfile::where('user_id', $user->id)->first();
            if ($youthProfile) {
                $youthProfile->update([
                    'bio' => $request->input('bio'),
                    'skills' => $request->input('skills'),
                ]);
            }
        } elseif ($user->role === 'Organization') {
            // Update organization record instead of user record
            $organization = \App\Models\Organization::where('user_id', $user->id)->first();
            if ($organization) {
                $organization->update([
                    'name' => $request->input('organization_name'),
                    'description' => $request->input('description'),
                ]);
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
