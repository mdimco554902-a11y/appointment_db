<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DepartmentController; // Added for Department functionality

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    
    // Dashboard (Overview)
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');

    // --- Appointments Page Routes ---
    Route::get('/appointments', [AppointmentController::class, 'appointmentsIndex'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // --- Patient Records Routes ---
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // --- Doctors Routes ---
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

    // --- UPDATED: Department Routes (No longer "Coming Soon") ---
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    // Logout (MUST BE POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});