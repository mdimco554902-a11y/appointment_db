<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // 1. Fetch data for the services management table
        $services = Service::with('department')->get();
        $departments = Department::all();

        // 2. Fetch stats required by the dashboard layout
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $activeDoctors = Doctor::count();

        // 3. Fetch recent appointments required by the dashboard table
        // We fetch the latest 5 appointments to keep the dashboard clean
        $appointments = Appointment::with(['patient', 'doctor'])->latest()->take(5)->get();

        // 4. Return view with EVERYTHING your layout needs to stop crashing
        return view('services.index', compact(
            'services', 
            'departments', 
            'totalPatients', 
            'totalAppointments', 
            'activeDoctors',
            'appointments'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ServiceName' => 'required|string|max:255',
            'DeptID' => 'required|exists:departments,DeptID',
            'Description' => 'nullable|string'
        ]);

        Service::create($request->all());

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return redirect()->back()->with('success', 'Service updated!');
    }

    public function destroy($id)
    {
        Service::destroy($id);
        return redirect()->back()->with('success', 'Service deleted!');
    }
}