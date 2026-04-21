<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController; // Added this for Patient functionality

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');

    // Appointment Actions
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // --- UPDATED: Patient Records Routes ---
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // Sidebar Placeholder Routes (Remaining)
    Route::get('/doctors', function() { return "Doctors Page - Coming Soon"; })->name('doctors.index');
    Route::get('/departments', function() { return "Departments Page - Coming Soon"; })->name('departments.index');

    // Logout (MUST BE POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});