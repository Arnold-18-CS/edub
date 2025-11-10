<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TwoFactorAuthentication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TwoFactorAuthController extends Controller
{
    /**
     * Show the 2FA verification form
     */
    public function show(): View
    {
        return view('auth.two-factor');
    }

    /**
     * Handle 2FA verification
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = session('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $twoFactor = TwoFactorAuthentication::where('user_id', $userId)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$twoFactor) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // Mark code as used
        $twoFactor->update(['used' => true]);

        // Clear 2FA session
        session()->forget('2fa_user_id');

        // Log the user in
        $user = User::findOrFail($userId);
        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Resend 2FA code
     */
    public function resend(): RedirectResponse
    {
        $userId = session('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = User::findOrFail($userId);
        $this->sendCode($user);

        return back()->with('status', 'Verification code resent to your email.');
    }

    /**
     * Send 2FA code to user's email
     */
    public static function sendCode(User $user)
    {
        $twoFactor = TwoFactorAuthentication::generateCode($user->id);

        // Send email with code
        Mail::raw("Your EduBridge verification code is: {$twoFactor->code}\n\nThis code will expire in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('EduBridge - Two-Factor Authentication Code');
        });

        return $twoFactor;
    }
}

