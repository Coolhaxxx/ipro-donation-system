<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CampaignController;

// Redirect root to donation form
Route::get('/', [DonationController::class, 'index'])->name('donation.index');

// Donation routes
Route::get('/donate', [DonationController::class, 'index'])->name('donation.form');
Route::post('/donate', [DonationController::class, 'store'])->name('donation.store');
Route::post('/check-donor', [DonationController::class, 'checkDonor'])->name('donation.check');

// Confirmation and payment pages
Route::get('/donation/{id}/confirmation', [DonationController::class, 'confirmation'])->name('donation.confirmation');
Route::get('/donation/{id}/payment', [DonationController::class, 'payment'])->name('donation.payment');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect /admin to dashboard if logged in, otherwise to login
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });
    
    // Login routes (guest only)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // Protected admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/donations', [DashboardController::class, 'donations'])->name('donations');
        Route::get('/donations/{id}', [DashboardController::class, 'showDonation'])->name('donations.show');
        Route::get('/donors/{id}', [DashboardController::class, 'showDonor'])->name('donors.show');
        Route::post('/donations/{id}/status', [DashboardController::class, 'updateDonationStatus'])->name('donations.update-status');
        Route::get('/donors', [DashboardController::class, 'donors'])->name('donors');
        
        // Campaign routes
        Route::resource('campaigns', CampaignController::class);
        Route::post('/campaigns/{campaign}/toggle-active', [CampaignController::class, 'toggleActive'])->name('campaigns.toggle-active');
        Route::post('/campaigns/{campaign}/set-default', [CampaignController::class, 'setDefault'])->name('campaigns.set-default');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
