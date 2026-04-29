<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    public function index() {
        // Change: Use oldest('AppointmentID') so new records appear at the bottom
        $appointments = Appointment::with(['patient', 'doctor'])->oldest('AppointmentID')->get();
        
        $totalAppointments = Appointment::count(); 
        $totalPatients = Patient::count();
        $activeDoctors = Doctor::count();
        
        return view('dashboard', compact('appointments', 'totalPatients', 'activeDoctors', 'totalAppointments'));
    }

    /**
     * NEW: Method for the dedicated Appointments sidebar page.
     * This fetches patients and doctors so they appear in your "New Appointment" modal.
     */
    public function appointmentsIndex() {
        $appointments = Appointment::with(['patient', 'doctor'])->oldest('AppointmentID')->get();
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        return view('appointments.index', compact('appointments', 'patients', 'doctors'));
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
            
            // Professional touch: Redirect back to the page the user came from
            return redirect()->back()->with('success', 'Appointment saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        $appointment = Appointment::where('AppointmentID', $id)->firstOrFail();

        $validated = $request->validate([
            'AppointmentTime' => 'required',
            'Status' => 'required|string',
        ]);

        try {
            $appointment->update($validated);
            return redirect()->back()->with('success', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        $appointment = Appointment::where('AppointmentID', $id)->firstOrFail();
        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment cancelled.');
    }
}