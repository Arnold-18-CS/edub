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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Youth,Organization,Admin'],
        ];

        // Name validation - required for Youth, optional for Organization/Admin
        if ($request->role === 'Youth') {
            $rules['name'] = ['required', 'string', 'max:255'];
        } else {
            $rules['name'] = ['nullable', 'string', 'max:255'];
        }

        // Add organization validation rules for Organization and Admin roles
        if (in_array($request->role, ['Organization', 'Admin'])) {
            $rules['organization_name'] = ['required', 'string', 'max:255'];
            $rules['contact_email'] = ['required', 'email', 'max:255'];
            $rules['organization_type'] = ['nullable', 'string', 'max:100'];
            $rules['contact_phone'] = ['nullable', 'string', 'max:20'];
            $rules['location'] = ['nullable', 'string', 'max:255'];
            $rules['organization_description'] = ['nullable', 'string', 'max:1000'];
            $rules['bio'] = ['nullable', 'string', 'max:500'];
            $rules['skills'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        // For Organization/Admin, use organization_name as user name if name not provided
        $userName = $validated['name'] ?? ($validated['organization_name'] ?? 'Organization User');

        // Create user
        $user = User::create([
            'name' => $userName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create organization record for Organization and Admin roles
        if (in_array($validated['role'], ['Organization', 'Admin'])) {
            // Process skills if provided (convert comma-separated to array)
            $skillsArray = null;
            if (!empty($validated['skills'])) {
                $skillsArray = array_map('trim', explode(',', $validated['skills']));
                $skillsArray = array_filter($skillsArray);
            }

            Organization::create([
                'user_id' => $user->id,
                'name' => $validated['organization_name'],
                'type' => $validated['organization_type'] ?? null,
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'] ?? null,
                'location' => $validated['location'] ?? null,
                'description' => $validated['organization_description'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'skills' => $skillsArray,
                'verified' => $validated['role'] === 'Admin', // Auto-verify Admin organizations
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
