<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Youth,Organization,Admin'],
        ];

        // Add organization validation rules for Organization and Admin roles
        if (in_array($request->role, ['Organization', 'Admin'])) {
            $rules['organization_name'] = ['required', 'string', 'max:255'];
            $rules['contact_email'] = ['required', 'email', 'max:255'];
            $rules['organization_type'] = ['nullable', 'string', 'max:100'];
            $rules['contact_phone'] = ['nullable', 'string', 'max:20'];
            $rules['location'] = ['nullable', 'string', 'max:255'];
            $rules['organization_description'] = ['nullable', 'string', 'max:1000'];
        }

        $validated = $request->validate($rules);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create organization record for Organization and Admin roles
        if (in_array($validated['role'], ['Organization', 'Admin'])) {
            Organization::create([
                'user_id' => $user->id,
                'name' => $validated['organization_name'],
                'type' => $validated['organization_type'] ?? null,
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'] ?? null,
                'location' => $validated['location'] ?? null,
                'description' => $validated['organization_description'] ?? null,
                'verified' => $validated['role'] === 'Admin', // Auto-verify Admin organizations
            ]);

            // Also store organization name in user model for easy access
            $user->update([
                'organization_name' => $validated['organization_name'],
                'description' => $validated['organization_description'] ?? null,
            ]);
        }

        // Auto-verify Admin users
        if ($validated['role'] === 'Admin') {
            $user->update(['verified' => true]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
