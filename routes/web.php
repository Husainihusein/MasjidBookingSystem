<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| This file defines all web routes for the application.
| Routes are grouped by public access, authenticated users, and admin-only.
*/

// =============================
// ✅ PUBLIC ROUTES
// =============================

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Booking form (GET: show form, POST: submit form)
Route::get('/booking', [BookingController::class, 'create']);
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// =============================
// ✅ AUTHENTICATED USER ROUTES
// =============================
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout route (POST only)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('logout');

// =============================
// ✅ ADMIN-ONLY ROUTES
// =============================
Route::middleware(['auth', 'admin'])->group(function () {
    // Redirect dashboard to admin booking list
    Route::get('/dashboard', function () {
        return redirect('/admin/bookings');
    })->name('dashboard');

    // Booking management
    Route::get('/admin/bookings', [AdminController::class, 'index'])->name('admin.bookings');
    Route::post('/admin/bookings/{id}/approve', [AdminController::class, 'approve'])->name('admin.bookings.approve');
    Route::post('/admin/bookings/{id}/reject', [AdminController::class, 'reject'])->name('admin.bookings.reject');
    Route::post('/admin/bookings/{booking}/cancel', [AdminController::class, 'cancel'])->name('admin.bookings.cancel');
});

// =============================
// ✅ EXPORT ROUTES (Optional status filter)
// =============================
Route::get('/admin/export/{status?}', [AdminController::class, 'export'])->name('admin.export');

// =============================
// ✅ SIGNED ACTION HANDLER (Optional use)
// =============================
Route::get('/admin/bookings/{booking}/action', [BookingController::class, 'handleAction'])
    ->name('bookings.action')
    ->middleware('signed'); // Optional: signed URL for added security

// =============================
// ✅ AUTH ROUTES (Laravel Breeze, Jetstream, or Fortify)
// =============================
require __DIR__ . '/auth.php';
