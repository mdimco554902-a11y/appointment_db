<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentController extends Controller
{
  public function index() {
    $appointments = Appointment::with(['patient', 'doctor'])->latest('AppointmentID')->get();
    
    $totalAppointments = Appointment::count(); // Add this line
    $totalPatients = Patient::count();
    $activeDoctors = Doctor::count();
    
    // Add totalAppointments to the compact list below
    return view('dashboard', compact('appointments', 'totalPatients', 'activeDoctors', 'totalAppointments'));
}

    public function store(Request $request) {
        // 1. Get all data from the form
        $data = $request->all();

        // 2. Force the Status to be 'Pending' if it's not provided
        if (!isset($data['Status'])) {
            $data['Status'] = 'Pending';
        }

        // 3. Create the appointment
        try {
            Appointment::create($data);
            return redirect()->route('dashboard')->with('success', 'Saved successfully!');
        } catch (\Exception $e) {
            // This displays the specific error if the database rejects the save
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Appointment cancelled.');
    }
}