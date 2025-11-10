<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display certificates for the logged-in youth user.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'Youth') {
            abort(403, 'Unauthorized access');
        }

        // For now, return an empty view - certificates feature can be implemented later
        return view('youth.certificates', [
            'certificates' => collect([])
        ]);
    }
}
