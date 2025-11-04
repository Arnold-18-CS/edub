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
            $user->bio = $request->input('bio');
            $user->skills = $request->input('skills');
        } elseif ($user->role === 'Organization') {
            $user->organization_name = $request->input('organization_name');
            $user->description = $request->input('description');
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
