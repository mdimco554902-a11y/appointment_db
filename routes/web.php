<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController; // Added for Service functionality
use App\Http\Controllers\DailyScheduleController; // Added for Schedule functionality

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
    
    /**
     * UPDATE: This route handles both Admin edits and Patient cancellations 
     * as defined in your index.blade.php form method.
     */
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // --- Patient Records Routes ---
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // --- Doctors Routes ---
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

    // --- Department Routes ---
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    // --- NEW: Medical Services Routes ---
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // --- NEW: Daily Schedules Routes ---
    Route::get('/schedules', [DailyScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/schedules', [DailyScheduleController::class, 'store'])->name('schedules.store');
    Route::put('/schedules/{id}', [DailyScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{id}', [DailyScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Logout (MUST BE POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});