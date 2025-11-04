<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\YouthProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route that redirects based on user role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'Admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'Organization') {
        return redirect()->route('organization.dashboard');
    } elseif ($user->role === 'Youth') {
        return redirect()->route('opportunities.list');
    }

    // Default fallback
    return redirect()->route('profile.edit');
})->name('dashboard');


// Organization routes
Route::middleware(['auth', 'role:Organization'])->group(function () {

    // Dashboard - list organization’s own opportunities
    Route::get('/organization/dashboard', [OrganizationController::class, 'dashboard'])->name('organization.dashboard');

    // Post a new opportunity
    Route::post('/organization/opportunities', [OpportunityController::class, 'store'])->name('opportunities.store');

    // View applicants for a specific opportunity
    Route::get('/organization/opportunity/{id}/applicants', [OrganizationController::class, 'viewApplicants'])->name('organization.applicants');

    // Update application status
    Route::post('/organization/application/{id}/status', [OrganizationController::class, 'updateApplicationStatus'])->name('organization.application.status');

    // Organization Profile
    Route::get('/organization/profile', [ProfileController::class, 'edit'])->name('organization.profile.edit');
    Route::patch('/organization/profile', [ProfileController::class, 'update'])->name('organization.profile.update');
});


// Youth routes
Route::middleware(['auth', 'role:Youth'])->group(function () {

    // Youth Profile
    Route::get('/youth/profile', [YouthProfileController::class, 'index'])->name('youth.profile');
    Route::get('/youth/profile/edit', [YouthProfileController::class, 'edit'])->name('youth.profile.edit');
    Route::post('/youth/profile/update', [YouthProfileController::class, 'update'])->name('youth.profile.update');

    // Opportunities
    Route::get('/opportunities', [OpportunityController::class, 'list'])->name('opportunities.list');
    Route::get('/opportunities/{id}', [OpportunityController::class, 'show'])->name('opportunities.show');

    // Apply to opportunity
    Route::post('/opportunities/{id}/apply', [ApplicationController::class, 'apply'])->name('opportunity.apply');

    // My applications
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');

    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('youth.certificates');
});


// Admin routes
Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Verify or revoke organizations
    Route::post('/admin/verify/{id}', [AdminController::class, 'verifyOrg'])->name('admin.verify');
    Route::post('/admin/revoke/{id}', [AdminController::class, 'revokeOrg'])->name('admin.revoke');

    // Optionally, view applications or opportunities
    // Route::get('/admin/opportunities', [AdminController::class, 'viewOpportunities'])->name('admin.opportunities');
});


// Role-based /profile route
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', function () {
        $user = Auth::user();

        if ($user->role === 'Youth') {
            return redirect()->route('youth.profile');
        } elseif ($user->role === 'Organization') {
            return redirect()->route('organization.profile.edit');
        } else {
            // fallback for Admin or others
            return view('profile.edit', ['user' => $user]);
        }
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
