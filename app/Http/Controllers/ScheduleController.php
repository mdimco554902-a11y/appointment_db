<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('doctor')->orderBy('AvailableDate', 'asc')->get();
        $doctors = Doctor::all();

        return view('schedules.index', compact('schedules', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'DoctorID' => 'required',
            'AvailableDate' => 'required|date',
            'Shift' => 'required|in:AM,PM,Full Day',
            'MaxCapacity' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'DoctorID' => $request->DoctorID,
            'AvailableDate' => $request->AvailableDate,
            'Shift' => $request->Shift,
            'MaxCapacity' => $request->MaxCapacity,
            'CurrentBookings' => 0,
        ]);

        return redirect()->back()->with('success', 'Daily schedule created successfully!');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Schedule removed.');
    }
}