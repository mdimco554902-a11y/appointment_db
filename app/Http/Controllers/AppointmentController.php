<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\DailySchedule; 
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Dashboard View: Shows statistics and lists
     */
    public function index()
    {
        $services = Service::all(); 
        $doctors = Doctor::with('department')->get();
        // Only show future available schedules
        $schedules = DailySchedule::where('AvailableDate', '>=', now()->toDateString())->get();

        // Admin sees everything; Patient sees only theirs
        if (Auth::user()->isAdmin()) {
            $appointments = Appointment::with(['patient', 'doctor', 'service'])->oldest('AppointmentID')->get();
        } else {
            $appointments = Appointment::with(['patient', 'doctor', 'service'])
                ->where('PatientID', Auth::user()->PatientID)
                ->oldest('AppointmentID')
                ->get();
        }
        
        $totalAppointments = Appointment::count();
        $totalPatients = Patient::count();
        $activeDoctors = Doctor::count();

        return view('dashboard', compact(
            'appointments', 
            'totalPatients', 
            'activeDoctors', 
            'totalAppointments', 
            'services', 
            'doctors', 
            'schedules'
        ));
    }

    /**
     * Appointments Sidebar View: Dedicated management page
     */
    public function appointmentsIndex() 
    {
        $query = Appointment::with(['patient', 'doctor', 'service', 'dailySchedule']);

        if (!Auth::user()->isAdmin()) {
            $query->where('PatientID', Auth::user()->PatientID);
        }

        $appointments = $query->latest('AppointmentID')->get();
        
        $patients = Patient::all();
        $doctors = Doctor::all();
        $services = Service::all();
        $schedules = DailySchedule::where('AvailableDate', '>=', now()->toDateString())->get();
        
        return view('appointments.index', compact('appointments', 'patients', 'doctors', 'services', 'schedules'));
    }

    /**
     * Store: Create new appointment with Auto-Registration logic
     */
    public function store(Request $request) 
    {
        $request->validate([
            'ScheduleID'    => 'required',
            'ServiceID'     => 'required',
            'BookingReason' => 'nullable|string',
            // Manual Patient Entry Validation
            'FirstName'     => 'required_without:PatientID',
            'MiddleName'    => 'nullable', // Optional Middle Name
            'LastName'      => 'required_without:PatientID',
            'Email'         => 'required_without:PatientID|email',
            'Phone'         => 'required_without:PatientID',
            'Gender'        => 'required_without:PatientID',
            'Age'           => 'required_without:PatientID',
            'BirthDate'     => 'required_without:PatientID',
        ]);

        try {
            $patientId = $request->PatientID;

            // Auto-register the patient if no ID exists
            if (!$patientId) {
                $newPatient = Patient::create([
                    'FirstName'  => $request->FirstName,
                    'MiddleName' => $request->MiddleName,
                    'LastName'   => $request->LastName,
                    'Email'      => $request->Email,
                    'Phone'      => $request->Phone,
                    'Gender'     => $request->Gender,
                    'Age'        => $request->Age,
                    'BirthDate'  => $request->BirthDate,
                ]);
                $patientId = $newPatient->PatientID;
            }

            $schedule = DailySchedule::findOrFail($request->ScheduleID);

            if ($schedule->CurrentBookings >= $schedule->MaxCapacity) {
                return back()->withErrors(['msg' => 'This schedule slot is fully booked.']);
            }

            $schedule->increment('CurrentBookings');
            $priorityNumber = (int) $schedule->CurrentBookings;

            Appointment::create([
                'PatientID'       => $patientId,
                'DoctorID'        => $schedule->DoctorID, 
                'ScheduleID'      => $schedule->ScheduleID,
                'ServiceID'       => $request->ServiceID,
                'PriorityNumber'  => $priorityNumber,
                'BookingReason'   => $request->BookingReason,
                'Shift'           => $schedule->Shift, 
                'AppointmentTime' => $request->AppointmentTime,
                'Status'          => 'Pending'
            ]);
            
            return redirect()->back()->with('success', "Appointment booked! Priority Number: #$priorityNumber");
            
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Submission Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Update: Modify existing appointment
     */
    public function update(Request $request, $id) 
    {
        $appointment = Appointment::where('AppointmentID', $id)->firstOrFail();

        $validated = $request->validate([
            'AppointmentTime' => 'nullable',
            'Status'          => 'required|string',
        ]);

        try {
            if ($request->Status === 'Cancelled' && $appointment->Status !== 'Cancelled') {
                if ($appointment->dailySchedule) {
                    $appointment->dailySchedule->decrement('CurrentBookings');
                }
            }
            
            if ($request->Status === 'Pending' && $appointment->Status === 'Cancelled') {
                if ($appointment->dailySchedule) {
                    $appointment->dailySchedule->increment('CurrentBookings');
                }
            }

            $appointment->update($validated);
            return redirect()->back()->with('success', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * Destroy: Delete appointment
     */
    public function destroy($id) 
    {
        $appointment = Appointment::where('AppointmentID', $id)->firstOrFail();
        
        if($appointment->dailySchedule && $appointment->Status !== 'Cancelled') {
            $appointment->dailySchedule->decrement('CurrentBookings');
        }

        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment removed.');
    }
}